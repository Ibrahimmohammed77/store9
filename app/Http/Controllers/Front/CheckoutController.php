<?php

namespace App\Http\Controllers\Front;

use App\Events\OrderCreated;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Intl\Countries;
use Throwable;

class CheckoutController extends Controller
{
    public function create(CartRepository $cart)
    {
        if ($cart->get()->count() == 0) {
            throw new \App\Exceptions\InvalidOrderException('Your cart is empty');
            // 'message' => 'Your Cart Is Empty',
            // return redirect()->route('home')->with([
            // ]);
        }
        return view('front.checkout')->with([
            'cart'=> $cart,
            'countries'=>Countries::getNames(config('app.locale'))
        ]);
    }
    public function store(Request $request, CartRepository $cart)
    {
        // $request->validate([
        //     'addr.billing.first_name'=>['required','string','max:255'],
        //     'addr.billing.last_name'=>['required','string','max:255'],
        //     'addr.billing.email'=>['required','email'],
        //     'addr.billing.phone_number'=>['required','integer','max:12'],
        //     'addr.billing.street_addres'=>['required','string','max:255'],
        //     // 'addr.billing.city'=>['required','string','max'],
        //     // 'addr.billing.first_name'=>['required','string','max'],
        // ]);
        $items = $cart->get();

        $items = $items->groupBy('product.store_id')->all();// collection
        DB::beginTransaction();
        try {
            foreach ($items as $store_id => $cart_item) {
                # code...
                $order = Order::create([
                    'store_id' => $store_id,
                    'user_id' => Auth::id(),
                    'payment_method' => 'pay'
                ]);
                // create order item
                foreach ($cart_item as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product->id,
                        'product_name' => $item->product->name,
                        'price' => $item->product->price,
                        'quantity' => $item->quantity
                    ]);
                }
                // address of pepole Who order the item
                foreach ($request->post('addr') as $type => $address) {
                    $address['type'] = $type;
                    $order->address()->create($address);
                }
            }
            $cart->empty(); #use event and Listener EmptyCart::class
            DB::commit();
            // event('order.created',$order);
            event(new OrderCreated($order));
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        // return redirect()->route('home');
        return redirect()->route('orders.payments.create',$order->id);
    }
}
