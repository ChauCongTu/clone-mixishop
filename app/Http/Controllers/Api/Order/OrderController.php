<?php

namespace App\Http\Controllers\Api\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OrderRequest;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::orderBy('created_at', 'DESC')->paginate(10);
        return response()->json($orders);
    }

    public function getByUser(int $user_id)
    {
        $orders = Order::where('user_id', $user_id)->orderBy('created_at', 'DESC')->paginate(10);
        return response()->json($orders);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderRequest $request)
    {
        $order = $request->only('user_id', 'total', 'final_total', 'payment_method', 'payment_status', 'name', 'email', 'phone', 'post_code', 'address', 'ward', 'district', 'city');
        $order['order_code'] = 'U'.$order['user_id'].'T'.date('yyyyMMddHHii', time());
        $order['address'] = $order['address'] . ', ' . $order['ward'] . ', ' . $order['district'] . ', ' . $order['city'];
        $createdOrder = Order::create($order);
        if ($createdOrder) {
            return response()->json($createdOrder);
        }
        return response()->json(['message' => 'Has an error'], 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $order = Order::with('details')->find($id);
        return response()->json($order);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $order = $request->only('user_id', 'total', 'final_total', 'payment_method', 'payment_status', 'name', 'email', 'phone', 'post_code', 'address', 'ward', 'district', 'city');
        $order['address'] = $order['address'] . ', ' . $order['ward'] . ', ' . $order['district'] . ', ' . $order['city'];
        $updatedOrder = Order::where('id', $id)->update($order);
        if ($updatedOrder) {
            return response()->json(['message' => 'Updated']);
        }
        return response()->json(['message' => 'Has an error'], 400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        Order::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }
}
