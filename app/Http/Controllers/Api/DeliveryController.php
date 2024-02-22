<?php

namespace App\Http\Controllers\Api;

use App\Events\DeliveryLocationUpdated;
use App\Http\Controllers\Controller;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliveryController extends Controller
{
    public function show( $id)
    {
         $delivery=Delivery::query()->select([
            "id",
            "order_id",
            DB::raw("ST_X(current_location) AS lat"),
            DB::raw("ST_Y(current_location) AS lng"),
            'created_at'
         ])->where('id',$id)
         ->firstOrFail();
         return response()->json($delivery);
    }
    public function update(Request $request, $delivery)
    {
         $request->validate([
            "lng"=> ['required','numeric'],
            "lat"=>['required','numeric']
        ]);
        $delivery=Delivery::find($delivery);
        $delivery->update([
            'current_location'=>DB::raw("POINT({$request->lng},{$request->lat})"),
        ]);
        event(new DeliveryLocationUpdated($request->lat,$request->lng));
        return $delivery;
    //    print_r('h');
    //    return 'h';
    }
    
}
