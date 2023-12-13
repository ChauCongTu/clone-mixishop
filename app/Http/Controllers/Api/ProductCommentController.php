<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CommentRequest;
use App\Models\ProductComment;
use Illuminate\Http\Request;

class ProductCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = ProductComment::orderBy('product_id', 'DESC')->orderBy('id', 'DESC')->paginate(10);
        return response()->json($comments);
    }
    public function getByProduct(int $product_id){
        $comments = ProductComment::with('user')->where('product_id', $product_id)->orderBy('created_at', 'DESC')->paginate(5);
        return response()->json($comments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentRequest $request)
    {
        $comment = $request->only('product_id', 'user_id', 'avatar', 'name', 'content', 'reply_id');
        $createdComment = ProductComment::create($comment);
        if ($createdComment) {
            return response()->json($createdComment);
        }
        return response()->json(['message' => 'Has an error'], 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $comments = ProductComment::where('id', $id);
        return response()->json($comments);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CommentRequest $request, int $id)
    {
        $comment = $request->only('product_id', 'user_id', 'avatar', 'name', 'content', 'reply_id');
        $updatedComment = ProductComment::where('id', $id)->update($comment);
        if ($updatedComment) {
            return response()->json(['message' => 'Updated!']);
        }
        return response()->json(['message' => 'Has an error'], 400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        ProductComment::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }
}
