<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->uid = '';
        $this->key = '';
        $this->secret = '';
        $this->passphrase = '';
        $this->base_url = 'https://api.kucoin.com';
        $this->values = [
            "current_price" => "0.00",
            "main_theta" => "0.00",
            "main_usdt" => "0.00",
            "debtRatio" => "0.00",
            "theta_total" => "0.00",
            "theta_liability" => "0.00",
            "usdt_liability" => "0.00",
            "usdt_total" => "0.00"
        ];
        
    }
    // home page
    public function index(Request $request)
    {
        $session = $request->session()->get('accId');
        $values = $request->session()->get('values', null);
        if(!empty($values))
            return view('home', ['values' => $values, 'session' => $session]);
        else
            return view('home', ['values' => $this->values, 'session' => $session]);
    }


    // Call KuCoin auth API
    public function authAPI($url, $request_path, $method = 'GET', $body = '')
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

    // Call KuCoin API
    public function callAPI($request, $url, $request_path, $method, $body)
    {
        $body = is_array($body) ? json_encode($body) : $body; // Body must be in json format
        $timestamp = round(microtime(true) * 1000);
        $what = $timestamp . $method . $request_path . $body;

        $secret = $request->session()->get('secret');
        $passphrase = $request->session()->get('pw');
        $key = $request->session()->get('apiKey');
        $kc_api_sign = base64_encode(hash_hmac("sha256", $what, $secret, true));
        $updated_passphrase = base64_encode(hash_hmac("sha256", $passphrase, $secret, true)); // For the V2

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "utf-8",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 120,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'KC-API-KEY:' . $key,
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

    // Get values
    public function getValues($response)
    {
        // get main account
        $main_theta = '';
        $main_usdt = '';
        $auth_res_data = $response['result']->data;
        foreach ($auth_res_data as $item) {
            if ($item->type === 'main') {
                if ($item->currency === "THETA") {
                    $main_theta = $item->balance;
                }
                if ($item->currency === "USDT") {
                    $main_usdt = $item->balance;
                }
            }
        }

        $current_price = $this->currentPrice();

        // get margin account
        $margin_path = "/api/v1/margin/account";
        $margin_result = $this->authAPI($this->base_url . $margin_path, $margin_path, 'GET', '');

        $debtRatio = $margin_result['result']->data->debtRatio;
        $theta = [];
        $usdt = [];
        
        for ($i = 0; $i < count($margin_result['result']->data->accounts); $i++) {
            if ($margin_result['result']->data->accounts[$i]->currency === "THETA") {
                $theta = $margin_result['result']->data->accounts[$i];
            } else if ($margin_result['result']->data->accounts[$i]->currency === "USDT") {
                $usdt = $margin_result['result']->data->accounts[$i];
            }
        }

        $theta_total = $theta->totalBalance;
        $theta_liability = $theta->liability;
        $usdt_total = $usdt->totalBalance;
        $usdt_liability = $usdt->liability;

        $data['current_price'] = $current_price;
        $data['main_theta'] = $main_theta;
        $data['main_usdt'] = $main_usdt;
        $data['debtRatio'] = $debtRatio;
        $data['theta_total'] = $theta_total;
        $data['theta_liability'] = $theta_liability;
        $data['usdt_total'] = $usdt_total;
        $data['usdt_liability'] = $usdt_liability;
        
        return $data;
    }

    /**
     * Get Current Price
     */
    public function currentPrice()
    {
        // get current price
        $current_price = 0;
        $symbol = 'THETA-USDT';
        $request_path = "/api/v1/market/orderbook/level1?symbol={$symbol}";
        $url = $this->base_url . $request_path;
        $current_price_result = $this->authAPI($url, $request_path, 'GET', '');
        $current_price = $current_price_result['result']->data->price;
        return $current_price;
    }

    /**
     * KuCoin Auth API
     */
    public function auth(Request $request)
    {
        $this->uid = $request->all()['accId'];
        $this->key = $request->all()['apiKey'];
        $this->passphrase = $request->all()['pw'];
        $this->secret = $request->all()['secret'];

        $request_path = '/api/v1/accounts';
        $url = $this->base_url . $request_path;

        $response = $this->authAPI($url, $request_path, 'GET', '');

        if ($response['result']->code === "200000") {
            session(['accId' => $request->all()['accId']]);
            session(['apiKey' => $request->all()['apiKey']]);
            session(['pw' => $request->all()['pw']]);
            session(['secret' => $request->all()['secret']]);
            $values = $this->getValues($response);
            $this->values = $values;
            if($request->session()->has('values')){
                $request->session()->forget('values');
            }
            $request->session()->put('values', $values);
            return back()->with('authSuccess','Authentication Success');;
        } else {
            return redirect('/')->with('authError','Authentication Failed');
        }
    }

    /**
     * Log out
     */
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/');
    }

    /**
     * getCurrentPrice
     */
    public function getCurrentPrice(Request $request)
    {
        $session = $request->session()->get('accId');
        if ($session !== null) {
            $current_price = $this->currentPrice();
            return $current_price;
        } else{
            return "0.00";
        }
    }

    /**
     * getAvailableTransferAmount
     */
    public function getAvailableTransferAmount(Request $request)
    {
        $session = $request->session()->get('accId');
        if ($session !== null) {
            if ($request->ajax()) {
                $currency = $request->data['currency'];
                $type = $request->data['type'];
                $request_path = "/api/v1/accounts/transferable?currency=".$currency."&type=".$type;
                $result = $this->callAPI($request, $this->base_url . $request_path, $request_path, 'GET', '');
                if (isset( $result['result']->data)) {
                    return ['status' => true, 'result' => $result['result']->data->transferable];
                } else {
                    return ['status' => false, 'result' => $result['result']->msg];
                }
            }
        } else{
            return ['status' => false, 'result' => "0"];
        }
    }

    /**
     * Transfer
     */
    public function transfer(Request $request)
    {
        $params = array(
            'clientOid' => (string) Str::uuid(),
            'currency' => $request->all()['coin'],
            'from' => $request->all()['from_account'],
            'to' => $request->all()['to_account'],
            'amount' => $request->all()['transfer_amount']
        );
        $request_path = "/api/v2/accounts/inner-transfer";        
        $result = $this->callAPI($request, $this->base_url . $request_path, $request_path, 'POST', $params);
        dd($result);
        
        // return redirect('/');
    }
}