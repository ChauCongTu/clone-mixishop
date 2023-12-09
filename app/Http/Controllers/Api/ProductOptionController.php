<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\OptionRequest;
use App\Models\ProductComment;
use App\Models\ProductOption;
use Illuminate\Http\Request;

class ProductOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    public function getByProduct(int $product_id)
    {
        $options = ProductOption::where('product_id', $product_id)->orderBy('created_at', 'DESC')->paginate(5);
        return response()->json($options);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(OptionRequest $request)
    {
        $options = $request->only('product_id', 'color', 'size', 'quantity');
        $createdOption = ProductOption::create($options);
        if ($createdOption) {
            return response()->json($createdOption);
        }
        return response()->json(['message' => 'Has an Error'], 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $options = $request->only('product_id', 'color', 'size', 'quantity');
        $updatedOption = ProductOption::where('id', $id)->update($options);
        if ($updatedOption) {
            return response()->json(['message' => 'Updated']);
        }
        return response()->json(['message' => 'Has an Error'], 400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        ProductOption::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }
}
