<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->uid = '';
        $this->key = '';
        $this->secret = '';
        $this->passphrase = '';
    }
    // home page
    public function index()
    {
        return view('home');
    }


    // Call KuCoin API
    public function callAPI($url, $request_path, $method = 'GET', $body = '')
    {
        $body = is_array($body) ? json_encode($body) : $body; // Body must be in json format
        $timestamp = time() * 1000;
        $what = $timestamp . $method . $request_path . $body;
        $kc_api_sign = base64_encode(hash_hmac("sha256", $what, $this->secret, true));
        $updated_passphrase = base64_encode(hash_hmac("sha256", $this->passphrase, $this->secret, true)); // For the V2

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 120,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'KC-API-KEY:' . $this->key,
                'KC-API-SIGN:' . $kc_api_sign,
                'KC-API-TIMESTAMP:' . $timestamp,
                'KC-API-PASSPHRASE:' . $updated_passphrase,
                'KC-API-KEY-VERSION: 2'
            )
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return ['error' => 1, 'result' => json_decode($err)];
        } else {
            return ['error' => 0, 'result' => json_decode($response)];
        }
    }


    /**
     * KuCoin Auth API
     */
    public function auth(Request $request)
    {
        if ($request->ajax()) {
            $this->uid = $request->data['accId'];
            $this->key = $request->data['apiKey'];
            $this->passphrase = $request->data['pw'];
            $this->secret = $request->data['secret'];

            $url = 'https://api.kucoin.com/api/v1/accounts';
            $request_path = '/api/v1/accounts';

            $response = $this->callAPI($url, $request_path, 'GET', '');

            if ($response['error']) {
                return response()->json([
                    'status' => 'error',
                    'data' => $response
                ]);
            } else {
                return response()->json([
                    'status' => 'success',
                    'data' => $response
                ]);
            }
        }
    }
}
