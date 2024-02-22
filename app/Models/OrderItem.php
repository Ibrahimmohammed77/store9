<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

// this is Model class connection between 2 models Product and Order model
class OrderItem extends Pivot
{
    use HasFactory;
    protected $table = "order_items";
    public $timestamps=false;
    public $incrementing = true;
    public function product()
    {
        return $this->belongsTo(Product::class)->withDefault([
            'name' => $this->product_name
        ]);
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
