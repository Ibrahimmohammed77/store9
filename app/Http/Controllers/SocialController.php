<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    public function index(string $provider){
    $user=Auth::user();
    $user_provider=Socialite::driver($provider)->stateless()->userFromToken($user->provider_token);
    dd($user_provider);
    }
}
