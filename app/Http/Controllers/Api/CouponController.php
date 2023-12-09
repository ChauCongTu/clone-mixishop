<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coupons = Coupon::orderBy('created_at', 'DESC')->paginate(10);
        return response()->json($coupons);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CouponRequest $request)
    {
        $coupon = $request->only('code', 'type', 'value', 'min_price', 'expired_at');
        $createdCoupon = Coupon::create($coupon);
        if ($createdCoupon) {
            return response()->json($createdCoupon);
        }
        return response()->json(['message' => 'Has an Error! Please try again.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $coupon = Coupon::where('id', $id)->first();
        if ($coupon) {
            return response()->json($coupon);
        }
        return response()->json(['message' => 'Coupon not found'], 400);
    }
    public function findByCode(Request $request) {
        if (!$request->code) {
            return response()->json(['message' => 'Please enter code'], 400);
        }
        $coupon = Coupon::where('code', $request->code)->first();
        if ($coupon) {
            return response()->json($coupon);
        }
        return response()->json(['message' => 'Coupon not found'], 400);
    }

    public function apply(string $code) {
        $coupon = Coupon::where('code',$code)->first();
        $coupon->is_used = 1;
        $coupon->save();
        return response()->json(['message' => 'Apply Successful']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CouponRequest $request, int $id)
    {
        $coupon = $request->only('code', 'type', 'value', 'min_price', 'expired_at');
        $updatedCoupon = Coupon::where('id', $id)->update($coupon);
        if ($updatedCoupon) {
            return response()->json(['message' => 'Updated!']);
        }
        return response()->json(['message' => 'Has an Error! Please try again.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        Coupon::destroy($id);
        return response()->json(['message' => 'Deleted!']);
    }
}
