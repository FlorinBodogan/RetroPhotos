<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
    if ($this->checkUserToken()) {
        return redirect('/dashboard');
    }

    return view('home');
    }

    public function checkUserToken()
    {
    return request()->hasCookie('user');
    }

}
