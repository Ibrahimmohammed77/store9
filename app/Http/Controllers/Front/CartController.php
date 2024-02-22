<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Repositories\Cart\CartModelRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Repositories\Cart\CartRepository;

class CartController extends Controller
{
    protected $cart;
    public function __construct(CartRepository $cart){
        $this->cart = $cart;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CartRepository $cart)
    {
        // $repository=App::make('cart');
        // $items = $cart->get();
        return view('front.cart')->with([
            'cart' => $cart,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CartRepository $cart)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'nullable|integer|min:1'
        ]);
        $item=$request->post('quantity');
        // dd($item);
        $product = Product::findOrFail($request->post('product_id'));
        // dd($request->post('quantity'));
        // dd($product->id);
        // $repository=new CartModelRepository();
        // $repository->add($product->id, $request->post('quantity'));
        $cart->add($product , $item);
        return redirect()->route('cart.index')->with('succes', "Success Add To Cart");
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);
        $cart = Cart::findOrFail($id);
        // $repository=new CartModelRepository();
        // $repository->update($product->id, $request->post('quantity'));
        $this->cart->update($id,$request->post('quantity'));
        return response()->json([
            'message'=>'sucess'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // public function destroy(CartRepository $cart, $id)
    public function destroy( $id)
    {
        // $repository=new CartModelRepository();
        // $repository->delete($id);
        $this->cart->delete($id);
    }
}
