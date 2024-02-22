<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'store_id', 'user_id', 'status', 'payment_method', 'payment_status'
    ];
    public function store()
    {
        return $this->belongsToMany(Store::class);
    }
    public function user()
    {
        return $this->belongsToMany(User::class)->withDefault([
            'name' => 'Guest Customer'
        ]);
    }
    public function address(){
        return $this->hasMany(OrderAdress::class,'order_id','id');
    }
    public function billingAddress(){
        return $this->hasOne(OrderAdress::class,'order_id','id')
        ->where('type','=','billing');
    }
    public function shippingAddress(){
        return $this->hasOne(OrderAdress::class,'order_id','id')
        ->where('type','=','shipping');
    }
    public function products()
    {
        return $this->belongsToMany(
            Product::class,'order_items','order_id','product_id','id', 'id'
        )->using(OrderItem::class) // to determin the model we use using(name of model)
            ->withPivot(['product_name','price','quantity','options']);
    }

    public function items(){
        return $this->hasMany(OrderItem::class,'order_id');
    }

    public function delivery()
    {
        return $this->hasOne(Delivery::class,'order_id');
    }
//  create order item number dependent nextOrderNumber 
    protected static function booted()
    {
        static::creating(function (Order $order) {
            $order->number = Order::getNextOrderNumber();
        });
    }
    // Create a function getNextOrderNumber depending the year number
    public static function getNextOrderNumber()
    {
        $year = Carbon::now()->year;
        $number = Order::whereYear('created_at', $year)->max('number');
        if ($number) {
            return $number + 1;
        }
        return $year . '0001';
    }
}
