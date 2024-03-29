<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\CurrencyConvert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class CurrencyConverterController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'currency_code'=>'required|string|size:3',
        ]);
        
        $baseCurrencyCode=config('app.currency');
        $currencyCode = $request->input('currency_code');
        
        $cache_key='currency_rate_'.$currencyCode;
        $rate=Cache::get($cache_key,0);
        
        if(!$rate){
            $conventer=new CurrencyConvert(config('services.currency_converter.api_key'));
            $rate=$conventer->convert($baseCurrencyCode,$currencyCode);
            Cache::put($cache_key,$rate,now()->addMinutes());
        }

        Session::put('currency_code', $currencyCode);
        return redirect()->back();
    }
}
