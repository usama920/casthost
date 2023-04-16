<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BasicSettings;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\StoreCategories;
use App\Models\Subscribers;
use App\Models\SubscriptionPayout;
use App\Models\User;
use App\Models\UserStorePage;
use App\Models\UserSubscribers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Stripe\OAuth;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\StripeClient;
use Stripe\Payout;

class StorePaymentController extends Controller
{
    private $stripe;
    public function __construct()
    {
        $this->stripe = new StripeClient(env('STRIPE_SECRET_KEY', null));
        Stripe::setApiKey(env('STRIPE_SECRET_KEY', null));
    }

    public function Payout()
    {
        $user = User::find(Auth::user()->id);
        if ($user->stripe_connect_id != null) {
            try {
                $account = $this->stripe->accounts->retrieve($user->stripe_connect_id);
                if ($account->charges_enabled) {
                    $user->completed_stripe_onboarding = 1;
                    $user->save();
                } else {
                    $user->completed_stripe_onboarding = 0;
                    $user->save();
                }
            } catch (\Throwable $th) {
                $user->completed_stripe_onboarding = 0;
                $user->stripe_connect_id = null;
                $user->save();
            }
        }
        $items = OrderItem::where(['user_id' => Auth::user()->id])->orderBy('created_at', 'DESC')->get();
        return view('admin.store_payout', compact('user', 'items'));
    }
    
    public function SubscriptionPayout()
    {
        $user = User::find(Auth::user()->id);
        if ($user->stripe_connect_id != null) {
            try {
                $account = $this->stripe->accounts->retrieve($user->stripe_connect_id);
                if ($account->charges_enabled) {
                    $user->completed_stripe_onboarding = 1;
                    $user->save();
                } else {
                    $user->completed_stripe_onboarding = 0;
                    $user->save();
                }
            } catch (\Throwable $th) {
                $user->completed_stripe_onboarding = 0;
                $user->stripe_connect_id = null;
                $user->save();
            }
        }
        $items = SubscriptionPayout::where(['user_id' => Auth::user()->id])->orderBy('created_at', 'DESC')->get();
        return view('admin.subscription_payouts', compact('user', 'items'));
    }

    public function CreatePayout()
    {
        $user = User::find(Auth::user()->id);
        if ($user->stripe_connect_id != null && $user->completed_stripe_onboarding == 1) {
            Session::flash('message', 'Account linked successfully!');
            Session::flash('alert-type', 'success');
            return redirect()->back();
        }
        if ($user->stripe_connect_id != null) {
            $id = $user->stripe_connect_id;
        } else {
            $account = $this->stripe->accounts->create(['type' => 'express']);
            $id = $account->id;
            $user->stripe_connect_id = $id;
            $user->save();
        }
        if ($user->role == 1) {
            $refresh_url = url('/admin/store/stripe/create');
            $return_url = url('/admin/store/payout');
        } else {
            $refresh_url = url('/user/store/stripe/create');
            $return_url = url('/user/store/payout');
        }
        $link = $this->stripe->accountLinks->create(
            [
                'account' => $id,
                'refresh_url' => $refresh_url,
                'return_url' => $return_url,
                'type' => 'account_onboarding',
            ]
        );
        return redirect($link->url);
        die;
    }

    public function UserCheckoutPage($username)
    {
        // $charge = Charge::create(array(
        //     "amount" => 10000,
        //     "currency" => "usd",
        //     "source" => "tok_visa",
        //     "transfer_group" => "ORDER10",
        // ));
        // prx($charge);

        // $transfer = $this->stripe->transfers->create(
        //     [
        //         'amount' => 7000,
        //         'currency' => 'usd',
        //         'destination' => 'acct_1MtbtaBCZum4ka3I',
        //         'source_transaction' => $charge->id,
        //         'transfer_group' => 'ORDER10',
        //         ]
        //     );
        // prx($transfer);




        // prx($this->stripe->balance->retrieve([]));
        // $payout = Payout::create([
        //     'amount' => 1000,
        //     'currency' => 'usd',
        // ], [
        //     'stripe_account' => 'acct_1MtbtaBCZum4ka3I',
        // ]);
        // prx($payout);
        // $intent = $this->stripe->paymentIntents->create(
        //     ['amount' => 10000, 'currency' => 'usd', 'transfer_group' => 'ORDER10']
        // );
        // $this->stripe->accounts->update(
        //     'acct_1MtbtaBCZum4ka3I',
        //     ['settings' => ['payouts' => ['schedule' => ['interval' => 'manual']]]]
        // );
        // $transfer = $this->stripe->transfers->create(
        //     [
        //         'amount' => 7000,
        //         'currency' => 'usd',
        //         'destination' => 'acct_1MtbtaBCZum4ka3I',
        //         'transfer_group' => 'ORDER10',
        //         ]
        //     );
        //     prx($transfer);



        // $intent = $this->stripe->paymentIntents->retrieve(
        //     'pi_3MuJ2QB23sC6EPYt0cG6bZ61',
        //     []
        // );
        // $session = $this->stripe->checkout->sessions->retrieve(
        //     'cs_test_b1uCjgG0U1li26hlQ4pIThrua59y4ia8U2GDd7qXhCdXkawXkULU80EFS6',
        //     []
        // );
        // prx($intent->charges->data[0]->id);

        Session::put('other_username', $username);
        if (!is_subscriber()) {
            return redirect('/login');
        }
        $user = User::where(['username' => $username])->first();
        if ($user) {
            if ($user->role == 1) {
                $page = UserStorePage::where(['user_id' => $user->id])->first();
            } else {
                $page = UserStorePage::where(['user_id' => $user->belongs_to])->first();
            }
            $cart_items = Cart::where(['subscriber_id' => subscriber_id()])->with(['product'])->get();
            if (count($cart_items) == 0) {
                return redirect()->back();
            }
            $total_price = 0;
            foreach ($cart_items as $item) {
                $total_price += $item->product->price * $item->quantity;
            }
            return view('front.user_checkout', compact('cart_items', 'page', 'user', 'total_price'));
        } else {
            return redirect()->back();
        }
    }

    public function CheckoutDone(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'country' => 'required',
            'street_address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'phone' => 'required'
        ]);

        $previous_orders = Order::where(['subscriber_id' => subscriber_id(), 'status' => 0])->where('created_at', '<=', date('Y-m-d'))->get();
        foreach ($previous_orders as $order) {
            OrderItem::where(['order_id' => $order->id])->delete();
        }
        $cart_items = Cart::where(['subscriber_id' => subscriber_id()])->with(['product'])->get();
        $total_price = 0;
        foreach ($cart_items as $item) {
            $total_price += $item->product->price * $item->quantity;
        }

        $order = new Order();
        $order->subscriber_id = subscriber_id();
        $order->first_name = $request->first_name;
        $order->last_name = $request->last_name;
        $order->country = $request->country;
        $order->street_address = $request->street_address;
        $order->city = $request->city;
        $order->state = $request->state;
        $order->zip = $request->zip;
        $order->phone = $request->phone;
        $order->notes = $request->notes;
        $order->price = $total_price;
        $order->status = 0;
        $order->save();

        $items = [];

        foreach ($cart_items as $item) {
            $order_item = new OrderItem();
            $order_item->order_id = $order->id;
            $order_item->user_id = $item->product->user_id;
            $order_item->product_id = $item->product_id;
            $order_item->product_name = $item->product->title;
            $order_item->price = $item->product->price;
            $order_item->quantity = $item->quantity;
            $order_item->color = $item->color;
            $order_item->size = $item->size;
            $order_item->save();

            array_push($items, [
                'name' => $item->product->title,
                'amount' => $item->product->price * 100,
                'currency' => 'usd',
                'quantity' => $item->quantity
            ]);
        }

        $other_username = Session::get('other_username');
        $session = StripeSession::create([
            'line_items' => $items,
            'payment_intent_data' => [
                'transfer_group' => 'ORDER' . $order->id,
            ],
            'success_url' => url('/' . $other_username . '/subscriber/orders'),
            'cancel_url' => url('/' . $other_username . '/checkout'),
        ]);
        $order->stripe_session_id = $session->id;
        $order->stripe_payment_intent = $session->payment_intent;
        $order->save();
        return redirect($session->url);
    }


    public static function CheckoutPaymentDone()
    {
        $orders = Order::where(['subscriber_id' => subscriber_id(), 'status' => 0])->get();
        $stripe = new StripeClient(env('STRIPE_SECRET_KEY', null));
        foreach ($orders as $order) {
            if ($order->stripe_session_id != null || $order->stripe_payment_intent != null) {
                $session = $stripe->checkout->sessions->retrieve(
                    $order->stripe_session_id,
                    []
                );
                if ($session->payment_status == "paid") {
                    $intent = $stripe->paymentIntents->retrieve(
                        $session->payment_intent,
                        []
                    );
                    $charge_id = $intent->charges->data[0]->id;

                    $items = OrderItem::where(['order_id' => $order->id])->get();
                    $basic_settings = BasicSettings::first();
                    foreach ($items as $item) {
                        $item_price = $item->price * $item->quantity * 100;

                        $margin = round(($item_price * ($basic_settings->store_commission / 100)) + $basic_settings->stripe_transaction_fee + ($item_price * ($basic_settings->stripe_transaction_commission / 100)), 2);
                        $product = Product::where(['id' => $item->product_id])->first();
                        $user = User::where(['id' => $product->user_id])->first();
                        if ($user->stripe_connect_id != null || $user->completed_stripe_onboarding == 1) {

                            $stripe->transfers->create(
                                [
                                    'amount' => round($item_price - $margin),
                                    'currency' => 'usd',
                                    'destination' => $user->stripe_connect_id,
                                    'source_transaction' => $charge_id,
                                ]
                            );
                        }
                        $item->user_payout = ($item_price - $margin) / 100;
                        $item->save();
                        Cart::where(['subscriber_id' => subscriber_id(), 'product_id' => $item->product_id])->delete();
                    }
                    Order::where(['id' => $order->id])->update(['status' => 1]);
                }
            }
        }
    }

    public static function createCustomer($email)
    {
        $stripe = new StripeClient(env('STRIPE_SECRET_KEY', null));
        $customer = $stripe->customers->create([
            'email' => $email
        ]);
        return $customer->id;
    }

    public static function createCustomerSubscription($user_id)
    {
        $stripe = new StripeClient(env('STRIPE_SECRET_KEY', null));
        $basicSettings = BasicSettings::first();
        $subscriber = Subscribers::where(['id' => subscriber_id()])->first();
        $user = User::with('SubscriptionInfo')->find($user_id);
        $transaction_fee_percentage = ($basicSettings->stripe_transaction_fee / $user->SubscriptionInfo->price) * 100;
        $total_application_fee = (int)$basicSettings->subscription_commission + $transaction_fee_percentage + (int)$basicSettings->stripe_transaction_commission;
        $session = $stripe->checkout->sessions->create([
            'customer' => $subscriber->stripe_id,
            'success_url' => url('/' . $user->username),
            'cancel_url' => url('/' . $user->username),
            'line_items' => [
                [
                    'price' => $user->SubscriptionInfo->price_id,
                    'quantity' => 1,
                ],
            ],
            'subscription_data' => [
                'application_fee_percent' => $total_application_fee,
                'transfer_data' => ['destination' => $user->stripe_connect_id]
            ],
            'mode' => 'subscription'
        ]);
        return ['url' => $session->url, 'session_id' => $session->id];
    }

    public static function createPrice($price)
    {
        $stripe = new StripeClient(env('STRIPE_SECRET_KEY', null));
        $response = $stripe->prices->create([
            'unit_amount' => $price * 100,
            'currency' => 'usd',
            'recurring' => ['interval' => 'month'],
            'product' => env('PRODUCT_ID')
        ]);
        return $response->id;
    }

    public static function cancelSubscription($id)
    {
        $stripe = new StripeClient(env('STRIPE_SECRET_KEY', null));
        $userSubscriber = UserSubscribers::where(['id' => $id, 'subscriber_id' => subscriber_id()])->first();
        if($userSubscriber) {
            if($userSubscriber->paid == 1 && $userSubscriber->stripe_sub_id != null) {
                $stripe->subscriptions->cancel(
                    $userSubscriber->stripe_sub_id,
                    []
                );
            }
        }
    }
}
