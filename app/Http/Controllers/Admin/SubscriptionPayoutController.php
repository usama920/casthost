<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPayout;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionPayoutController extends Controller
{
    public function SubscriptionPayout()
    {
        // $user = User::find(Auth::user()->id);
        // if ($user->stripe_connect_id != null) {
        //     try {
        //         $account = $this->stripe->accounts->retrieve($user->stripe_connect_id);
        //         if ($account->charges_enabled) {
        //             $user->completed_stripe_onboarding = 1;
        //             $user->save();
        //         } else {
        //             $user->completed_stripe_onboarding = 0;
        //             $user->save();
        //         }
        //     } catch (\Throwable $th) {
        //         $user->completed_stripe_onboarding = 0;
        //         $user->stripe_connect_id = null;
        //         $user->save();
        //     }
        // }
        // $items = SubscriptionPayout::where(['user_id' => Auth::user()->id])->orderBy('created_at', 'DESC')->get();
        // return view('admin.store_payout', compact('user', 'items'));
    }
}
