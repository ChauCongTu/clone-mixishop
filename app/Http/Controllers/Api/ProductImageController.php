<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ImageRequest;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }
    public function getByProduct(int $product_id)
    {
        $images = ProductImage::where('product_id', $product_id)->orderBy('created_at', 'DESC')->paginate(5);
        return response()->json($images);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(ImageRequest $request)
    {
        if (!$request->hasFile('images')) {
            return response()->json(['message' => 'Please upload images']);
        }
        $image = $request->images;
        $allowedImageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'svg'];
        $imageExtension = strtolower($image->getClientOriginalExtension());

        if (!in_array($imageExtension, $allowedImageExtensions)) {
            return response()->json(['error' => 'Invalid image format'], 400);
        }

        $maxSize = 5 * 1024 * 1024;
        if ($image->getSize() > $maxSize) {
            return response()->json(['error' => 'File size exceeds 5MB limit'], 400);
        }

        $imageName = 'product-' . $request->product_id . '-' . time() . '.' . $image->extension();
        Storage::putFileAs('public/products', $image, $imageName);
        $product_images = env('APP_URL') . '/storage/products/' . $imageName;
        $createdImage = ProductImage::create([
            'product_id' => $request->product_id,
            'url_image' => $product_images
        ]);
        if ($createdImage) {
            return response()->json($createdImage);
        }
        return response()->json(['message' => 'Has an Error'], 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        ProductImage::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }
}
