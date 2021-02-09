<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CustomerLoginController extends Controller
{

    public function showLogin(Request $request)
    {
        return view('customer.customer_login');
    }

    public function login(Request $request)
    {
        if (Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password])) {
            // Authentication passed...
            return redirect()->action('CustomerFrontendController@index');
        }
        return redirect()->back()->withInput()->with('message', 'Login Failed Please Make sure you are already a customer');
    }


    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();
        return redirect()->action('Auth\CustomerLoginController@showLogin');
    }
}
