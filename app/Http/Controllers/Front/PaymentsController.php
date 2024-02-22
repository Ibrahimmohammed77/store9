<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function create(Order $order)
    {
       
        return view('front.payments.create')->with([
            'order' => $order
        ]);

    }
    public function createStripePaymentIntent(Order $order)
    {
        $amount=$order->items->sum(function($item){
            return $item->price * $item->quantity;
        });
        $stripe = new \Stripe\StripeClient(config('services.stripe.secret_key'));
        $paymentIntent= $stripe->paymentIntents->create([
            'amount' => $amount,
            'currency' => 'usd',
            'automatic_payment_methods' => ['enabled' => true],
        ]);
        return [
            'clientSecret' => $paymentIntent->client_secret,
        ];
    }
    public function confirm(Request $request,Order $order)
    {
        $stripe = new \Stripe\StripeClient(config('services.stripe.secret_key'));
        $paymentIntent=$stripe->paymentIntents->retrieve($request->query('payment_intent'), []);
        if($paymentIntent->status=='succeeded'){
            // create payment
            $payment=new Payment();
            $payment->forceFill([
                'order_id'=>$order->id,
                'amount'=> $paymentIntent->amount,
                'currency'=> $paymentIntent->currency,
                'status'=>'completed',
                'method'=>$paymentIntent->payment_method,
                'transaction_id'=>$paymentIntent->id,
                'transaction_data'=>json_encode($paymentIntent)
            ])->save();
            event('payment.created',$payment->id);
        }
        return redirect()->route('home',[
            'status'=>'created-succeeded'
        ]);
    }
}
