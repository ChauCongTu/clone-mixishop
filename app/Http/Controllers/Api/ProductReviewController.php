<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ReviewRequest;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    public function getByProduct(int $product_id){
        $reviews = ProductReview::where('product_id', $product_id)->orderBy('created_at', 'DESC')->paginate(5);
        return response()->json($reviews);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReviewRequest $request)
    {
        $reviews = $request->only('product_id', 'rating', 'user_id', 'avatar', 'name', 'content');
        $createdReviews = ProductReview::create($reviews);
        if ($createdReviews) {
            return response()->json($createdReviews);
        }
        return response()->json(['message' => 'Has an error'], 400);
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
    public function update(ReviewRequest $request, int $id)
    {
        $reviews = $request->only('product_id', 'rating', 'user_id', 'avatar', 'name', 'content');
        $updatedReviews = ProductReview::where('id', $id)->update($reviews);
        if ($updatedReviews) {
            return response()->json(['message' => 'Updated']);
        }
        return response()->json(['message' => 'Has an error'], 400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        ProductReview::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }
}
