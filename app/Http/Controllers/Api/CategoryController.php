<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CreateRequest;
use App\Http\Requests\Category\UpdateRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::orderBy('name', 'DESC')->with('children')->where('is_parent', 1)->get();
        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request)
    {
        try {
            $imageName = "/storage/none.png";
            $category  = $request->only('name', 'is_parent', 'parent_id', 'desc');
            $category['slug'] = Str::slug($category['name'], '-');
            $category['thumb'] = env('APP_URL') . $imageName;
            if ($request->hasFile('thumb')) {
                $image = $request->thumb;
                $allowedImageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'svg'];
                $imageExtension = strtolower($image->getClientOriginalExtension());

                if (!in_array($imageExtension, $allowedImageExtensions)) {
                    return response()->json(['error' => 'Invalid image format'], 400);
                }

                $maxSize = 5 * 1024 * 1024;
                if ($image->getSize() > $maxSize) {
                    return response()->json(['error' => 'File size exceeds 5MB limit'], 400);
                }

                $imageName = $category['slug'] . '.' . $image->extension();
                Storage::putFileAs('public/categories', $image, $imageName);
                $category['thumb'] = env('APP_URL') . '/storage/categories/' . $imageName;
            }
            $createdCategory = Category::create($category);
            if ($createdCategory) {
                return response()->json($createdCategory);
            }
            return response()->json(['message' => 'Something Went Wrong!'], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $category = Category::with('children')->with('product')->where('id', $id)->first();
        if ($category) {
            return response()->json($category);
        }
        return response()->json(['message' => 'Category is Not Found'], 400);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, int $id)
    {
        try {
            $imageName = "/storage/none.png";
            $category  = $request->only('name', 'is_parent', 'parent_id', 'desc');
            $category['slug'] = Str::slug($category['name'], '-');
            if ($request->hasFile('thumb')) {
                $image = $request->thumb;
                $allowedImageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'svg'];
                $imageExtension = strtolower($image->getClientOriginalExtension());

                if (!in_array($imageExtension, $allowedImageExtensions)) {
                    return response()->json(['error' => 'Invalid image format'], 400);
                }

                $maxSize = 5 * 1024 * 1024;
                if ($image->getSize() > $maxSize) {
                    return response()->json(['error' => 'File size exceeds 5MB limit'], 400);
                }

                $imageName = $category['slug'] . '.' . $image->extension();
                Storage::putFileAs('public/categories', $image, $imageName);
                $category['thumb'] = env('APP_URL') . '/storage/categories/' . $imageName;
            }
            $updatedCategory = Category::where('id', $id)->update($category);
            if ($updatedCategory) {
                return response()->json(['message' => 'Updated!']);
            }
            return response()->json(['message' => 'Something Went Wrong!'], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        DB::beginTransaction();

        try {
            Category::destroy($id);

            DB::commit();

            return response()->json(['message' => 'Deleted Successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Deletion Failed', 'error' => $e->getMessage()], 400);
        }
    }
}
