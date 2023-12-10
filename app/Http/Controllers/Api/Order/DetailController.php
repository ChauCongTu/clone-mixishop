<?php

namespace App\Http\Controllers\Api\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\DetailRequest;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DetailRequest $request)
    {
        $detail = $request->only('order_id', 'product_id', 'size', 'color', 'price', 'quantity', 'total');
        $createdDetail = OrderDetail::create($detail);
        if ($createdDetail) {
            return response()->json($createdDetail);
        }
        return response()->json(['message' => 'Has an Error'], 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        OrderDetail::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }
}
