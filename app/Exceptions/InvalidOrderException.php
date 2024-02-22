<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Redirect;

class InvalidOrderException extends Exception
{
    public function render(){
        return Redirect::route('home')
        ->withInput()
        ->withErrors([ 
            'message' =>$this->getMessage(),
        ])
        ->with('info',$this->getMessage());
    }
}
