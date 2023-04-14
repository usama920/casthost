<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\User;
use App\Models\UserStorePage;
use Exception;
use Illuminate\Http\Request;
use Stripe\OAuth;
use Stripe\Stripe;
use Stripe\StripeClient;

class PaymentController extends Controller
{
    private $stripe;
    public function __construct()
    {
        $this->stripe = new StripeClient(env('STRIPE_SECRET_KEY', null));
        Stripe::setApiKey(env('STRIPE_SECRET_KEY', null));
    }

    public function CreatePayout()
    {
        $account = $this->stripe->accounts->create(['type' => 'express']);
        prx($account);
        $id = 'acct_1MtZqkPWebTapsNL';
        $link = $this->stripe->accountLinks->create(
            [
                'account' => $id,
                'refresh_url' => 'http://127.0.0.1:8000/redirect',
                'return_url' => 'http://127.0.0.1:8000',
                'type' => 'account_onboarding',
            ]
        );
        prx($link);

        $this->stripe->checkout->sessions->create(
            [
                'mode' => 'payment',
                'line_items' => [['price' => '{{PRICE_ID}}', 'quantity' => 1]],
                'payment_intent_data' => [
                    'application_fee_amount' => 123,
                    'transfer_data' => ['destination' => '{{CONNECTED_ACCOUNT_ID}}'],
                ],
                'success_url' => 'https://example.com/success',
                'cancel_url' => 'https://example.com/cancel',
            ]
        );
    }


    

    public function index()
    {
        $queryData = [
            'response_type' => 'code',
            'client_id' => env('STRIPE_CLIENT_ID', null),
            'scope' => 'read_write',
            'redirect_uri' => env('STRIPE_REDIRECT_URI', null),
        ];
        $connectUri = 'https://connect.stripe.com/oauth/authorize'.'?'.http_build_query($queryData);
        return view('payment.payment_options', compact('connectUri'));
    }

    public function redirect(Request $request)
    {
        $token = $this->getToken($request->code);
        if(!empty($token['error'])) {
            $request->session()->flash('danger', $token['error']);
            return response()->redirectTo('/user/payment-options');
        }
        $connectedAccountId = $token->stripe_user_id;
        $account = $this->getAccount($connectedAccountId);
        if(!empty($account['error'])) {
            $request->session()->flash('danger', $account['error']);
            return response()->redirectTo('/user/payment-options');
        }
        dd($account['id']);
        return view('accountTest', compact('account'));
    }

    private function getToken($code)
    {
        $token = null;
        try {
            $token = OAuth::token([
                'grant_type' => 'authorization_code',
                'code' => $code
            ]);
        } catch (Exception $e) {
            $token['error'] = $e->getMessage();
        }
        return $token;
    }

    private function getAccount($connectedAccountId)
    {
        $account = null;
        try {
            $account = $this->stripe->accounts->retrieve(
                $connectedAccountId,
                []
            );
        } catch (Exception $e) {
            $account['error'] = $e->getMessage();
        }
        return $account;
    }



}
