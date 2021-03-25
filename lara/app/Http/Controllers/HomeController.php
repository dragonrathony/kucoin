<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    // home page
    public function index()
    {
        return view('home');
    }


    // authentication
    public function auth(Request $request)
    {
        if ($request->ajax()) {
            $acc_id = $request->data['accId'];
            $api_key = $request->data['apiKey'];
            $pw = $request->data['pw'];
            $secret = $request->data['secret'];
            // dd($api_key);

            return response()->json([
                'status' => 'success',
                'msg' => 'Authentication successfully',
                'data' => []
            ]);
        }
    }
}
