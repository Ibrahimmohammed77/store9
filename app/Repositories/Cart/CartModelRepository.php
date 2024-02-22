<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class CartModelRepository implements CartRepository
{
    protected $items;
    public function __construct()
    {
        $this->items = collect([]);
    }
    public function get(): Collection
    {
        if (!$this->items->count()) {
            $this->items = Cart::with('product')->get();
        }
        return $this->items;
        // return Cart::with('product')
        // ->where('cookie_id', '=', $this->getCookieId()) #use this condition in Cart Model as Global Scope
        // ->get();
    }
    public function add(Product $product, $quantity = 1)
    {
        $item = Cart::where('product_id', '=', $product->id)
            // ->where('cookie_id', '=', $this->getCookieId()) #use this condition in Cart Model as Global Scope
            ->first();
        // dd($item);
        if (!$item) {
            $cart =  Cart::create([
                // 'cookie_id' => $this->getCookieId(), # use this events in CartObserve
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $quantity
            ]);
            $this->get()->push($cart);
            // return redirect()->route('cart');
        } else {
            $item->increment('quantity', $quantity);
        }
    }
    public function update($id, $quantity)
    {
        Cart::where('id', '=', $id)
            // ->where('cookie_id', '=', $this->getCookieId()) #use this condition in Cart Model as Global Scope
            ->update([
                'quantity' => $quantity
            ]);
    }
    public function delete($id)
    {
        Cart::where([
            'id' => $id,
            // 'cookie_id' => $this->getCookieId() #use this condition in Cart Model as Global Scope
        ])->delete();
    }
    public function empty()
    {
        // Cart::where('cookie_id', $this->getCookieId())->destroy(); #use this condition in Cart Model as Global Scope
        Cart::query()->delete();
    }
    public function total(): float
    {
        /*
        return (float)
        # Cart::where('cookie_id', $this->getCookieId())-> #use this condition in Cart Model as Global Scope
        Cart::join('products', 'products.id', '=', 'carts.product_id')
            ->selectRaw('SUM(products.price*carts.quantity) as total')
            ->value('total');*/
        return $this->get()->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
    }
    // protected function getCookieId()
    // {
    //     $cookie_id = Cookie::get('cart_id');
    //     if (!$cookie_id) {
    //         $cookie_id = Str::uuid();
    //         Cookie::queue('cart_id', $cookie_id, 30 * 24 * 60 * 60);
    //     }
    //     return $cookie_id;
    // }
}
