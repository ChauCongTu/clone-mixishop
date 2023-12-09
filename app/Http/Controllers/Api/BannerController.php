<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BannerRequest;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $banners = Banner::orderBy('created_at', 'DESC')->paginate(6);
        return response()->json($banners, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BannerRequest $request)
    {
        if (!$request->hasFile('image')) {
            return response()->json(['error' => 'Please Upload Image'], 400);
        }
        $image = $request->image;
        $allowedImageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'svg'];
        $imageExtension = strtolower($image->getClientOriginalExtension());

        if (!in_array($imageExtension, $allowedImageExtensions)) {
            return response()->json(['error' => 'Invalid image format'], 400);
        }

        $maxSize = 5 * 1024 * 1024;
        if ($image->getSize() > $maxSize) {
            return response()->json(['error' => 'File size exceeds 5MB limit'], 400);
        }

        $imageName = 'bg-mixishop-' . time() . '.' . $image->extension();
        Storage::putFileAs('public/banners', $image, $imageName);
        $createdBanner = Banner::create([
            'url_image' => env('APP_URL').'/storage/banners/' . $imageName
        ]);

        return response()->json($createdBanner, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $banner = Banner::find($id);
        return response()->json($banner, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BannerRequest $request, int $id)
    {
        return response()->json(['message' => 'API Update Banner Is Not Supported'], 405);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            Banner::where('id', $id)->delete();
        }
        catch(\Exception $e) {
            return response()->json(['message' => 'Deletion Failed', 'error' => $e->getMessage()], 400);
        }
        return response()->json(['message' => 'Deleted Successfully']);
    }
}
