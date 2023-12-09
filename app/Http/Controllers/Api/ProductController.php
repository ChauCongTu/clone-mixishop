<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productsQuery = Product::with('images')->orderBy('created_at', 'DESC');
        $products = $productsQuery->paginate(6);

        return response()->json($products);
    }

    public function getByCategory(int $category_id) {
        $productsQuery = Product::with('images')->orderBy('created_at', 'DESC');
        $productsQuery->where('category_id', $category_id);
        $products = $productsQuery->paginate(6);
        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request)
    {
        $product = $request->only('product_code', 'name', 'summary', 'desc', 'total_quantity', 'price', 'category_id');
        $product['slug'] = Str::slug($product['name'], '-') . '-' . time();
        $createdProduct = Product::create($product);
        if ($createdProduct) {
            return response()->json($createdProduct);
        }
        return response()->json(['message' => 'Has an Error! Please try again.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $product = Product::where('id', $id)
            ->with('images')
            ->with('reviews')
            ->with('comments')
            ->with('options')->first();
        if ($product) {
            return response()->json($product);
        }
        return response()->json(['message' => 'Product is Not Found'], 400);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, int $id)
    {
        $product = $request->only('product_code', 'name', 'summary', 'desc', 'total_quantity', 'price', 'category_id');
        $product['slug'] = Str::slug($product['name'], '-') . '-' . time();
        $updatedProduct = Product::where('id', $id)->update($product);
        if ($updatedProduct) {
            return response()->json(['message' => 'Updated!']);
        }
        return response()->json(['message' => 'Has an Error! Please try again.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            Product::destroy($id);
            return response()->json(['message' => 'Deleted!']);
        }
        catch (\Exception $e) {
            return response()->json(['message' => 'Has an error!', 'error' => $e->getMessage()], 400);
        }
    }
}
