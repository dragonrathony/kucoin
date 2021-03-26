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
        $this->base_url = 'https://api.kucoin.com';
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

            $request_path = '/api/v1/accounts';
            $url = $this->base_url . $request_path;

            $response = $this->callAPI($url, $request_path, 'GET', '');

            if ($response['error']) {
                return response()->json([
                    'status' => 'error',
                    'data' => $response
                ]);
            } else {
                // get current price
                $current_price = 0;

                $symbol = 'THETA-USDT';
                $request_path = "/api/v1/market/orderbook/level1?symbol={$symbol}";
                $url = $this->base_url . $request_path;
                $current_price_result = $this->callAPI($url, $request_path, 'GET', '');
                if ($current_price_result['error']) {
                    return response()->json([
                        'status' => 'error',
                        'data' => $current_price
                    ]);
                } else {
                    $current_price = $current_price_result['result']->data->price;

                    // get margin account
                    $request_path = "/api/v1/margin/account";
                    $url = $this->base_url . $request_path;
                    $margin_result = $this->callAPI($url, $request_path, 'GET', '');
                    if ($margin_result['error']) {
                        return response()->json([
                            'status' => 'error',
                            'data' => $margin_result
                        ]);
                    } else {
                        // dd($margin_result);
                        $debtRatio = $margin_result['result']->data->debtRatio;
                        $theta = $margin_result['result']->data->accounts[0];
                        $usdt = $margin_result['result']->data->accounts[1];

                        $theta_total = $theta->totalBalance;
                        $usdt_total = $usdt->totalBalance;
                        $usdt_liability = $usdt->liability;

                        $data['current_price'] = $current_price;
                        $data['debtRatio'] = $debtRatio;
                        $data['theta_total'] = $theta_total;
                        $data['usdt_liability'] = $usdt_liability;
                        $data['usdt_total'] = $usdt_total;

                        return response()->json([
                            'status' => 'success',
                            'data' => $data
                        ]);
                    }
                }
            }
        }
    }
}
