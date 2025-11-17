<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminLteDemoController extends Controller
{
    public function index()
    {
        return redirect()->route('adminlte.login');
    }

    public function login()
    {
        return view('adminlte.auth.login');
    }

    public function register()
    {
        return view('adminlte.auth.register');
    }
}
