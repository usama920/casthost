<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\BasicSettings;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\StoreCategories;
use App\Models\SubscriptionPayout;
use App\Models\User;
use App\Models\UserStorePage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Stripe\OAuth;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\StripeClient;
use Stripe\Payout;

class UserStorePaymentController extends Controller
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
        $total_payout = $items->sum('user_payout');
        $current_month_payout = $items->where('created_at', '>', Carbon::now()->month())->sum('user_payout');
        return view('dashboard.store_payout', compact('user','items', 'total_payout', 'current_month_payout'));
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
        $total_payout = $items->sum('payout');
        $current_month_payout = $items->where('created_at', '>', Carbon::now()->month())->sum('payout');
        return view('dashboard.subscription_payout', compact('user','items', 'total_payout', 'current_month_payout'));
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
}
