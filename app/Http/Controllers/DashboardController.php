<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $title = "STORE";
        $user = Auth::user();
        return view('dashboard/index')->with([
            'title' => $title,
            'user' => $user
        ]);
    }
}
