<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function show(Order $order)
    {
        $delivery=$order->delivery()->select([
            "id",
            "order_id",
            DB::raw("ST_X(current_location) AS lat"),
            DB::raw("ST_Y(current_location) AS lng"),
            'created_at'
         ])
         ->first();
        //  dd($delivery);
        return view('front.orders.nativehtml',[
            'order'=> $order,
            'delivery'=>$delivery
        ]);
    }
}
