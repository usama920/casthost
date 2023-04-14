<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\SubscriptionPrice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminProfileController extends Controller
{
    public function Profile()
    {
        $user = User::where(['id' => Auth::user()->id])->with(['SubscriptionInfo'])->first();
        return view('admin.profile', compact('user'));
    }

    public function SaveProfile(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);
        $user = User::find(Auth::user()->id);

        $SubscriptionInfo = SubscriptionPrice::where(['user_id' => Auth::user()->id, 'price' => $request->price])->first();
        
        if($SubscriptionInfo) {
            $user->subscription_price_id = $SubscriptionInfo->id;
            SubscriptionPrice::where(['user_id' => Auth::user()->id])->update(['status' => 0]);
            SubscriptionPrice::where(['id' => $SubscriptionInfo->id])->update(['status' => 1]);
        } else {
            SubscriptionPrice::where(['user_id' => Auth::user()->id])->update(['status' => 0]);

            $price_id = StorePaymentController::createPrice($request->price);
            $SubscriptionInfo = new SubscriptionPrice();
            $SubscriptionInfo->user_id = Auth::user()->id;
            $SubscriptionInfo->price_id = $price_id;
            $SubscriptionInfo->product_id = env('PRODUCT_ID');
            $SubscriptionInfo->price = $request->price;
            $SubscriptionInfo->status = 1;
            $SubscriptionInfo->save();

            $user->subscription_price_id = $SubscriptionInfo->id;
        }

        $user->name = $request->name;
        $user->facebook = $request->facebook;
        $user->twitter = $request->twitter;
        $user->instagram = $request->instagram;
        $user->save();
        
        return redirect()->back();
    }
}
