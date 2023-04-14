<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\UserSubscribers;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\StorePaymentController;

class SubscriberController extends Controller
{
    public function Profile($username)
    {
        $user = User::where(['username' => $username])->first();
        return view('front.subscriber_profile', compact('user'));
    }
    
    public function Orders($username)
    {
        StorePaymentController::CheckoutPaymentDone();

        $user = User::where(['username' => $username])->first();
        if($user) {
            $orders = Order::where(['subscriber_id' => subscriber_id()])->where('status', '!=', 0)->get();
            return view('front.subscriber_orders', compact('user', 'orders'));
        } else {
            return redirect()->back();
        }
    }

    public function OrderDetail(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        $order = Order::where(['subscriber_id' => subscriber_id(), 'id' => $request->id])->first();
        if($order) {
            $order_items = OrderItem::where(['order_id' => $order->id])->get();
            return response()->json(['status' => 'success', 'order_items' => $order_items]);
        } else {
            return response()->json(['status' => 'status']);
        }
    }

    function UsersSubscribed($username)
    {
        $user = User::where(['username' => $username])->first();
        if ($user) {
            $users_subscribed = UserSubscribers::where(['subscriber_id' => subscriber_id()])->with('user')->get();
            return view('front.subscriber_users_subscribed', compact('user', 'users_subscribed'));
        } else {
            return redirect()->back();
        }
    }
}
