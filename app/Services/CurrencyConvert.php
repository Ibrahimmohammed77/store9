<?php 

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CurrencyConvert{
    private $apikey;
    protected $baseUrl="https://free.currconv.com/api/v7/";
    public function __construct($apikey){
        $this->apikey = $apikey;
    }
    public function convert(string $from, string $to,float $amount =1):float
    {
        $q="{$from}_{$to}";
        $response=Http::baseUrl($this->baseUrl)
        ->get('/convert',[
            'q'=>$q,
            'compact'=>'ultra',
            'apiKey'=>$this->apikey
        ]);
        $result=$response->json();
        // dd($result);
        return $result[$q]*$amount;

    }
}