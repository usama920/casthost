<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Downloads;
use App\Models\Podcast;
use App\Models\User;
use App\Models\UserSubscribers;
use App\Models\Views;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function Dashboard()
    {
        $podcasts = Podcast::where('user_id', Auth::user()->id)->with(['views', 'downloads'])->latest()->get();
        $total_views = 0;
        $last_day_views = 0;
        $last_seven_day_views = 0;
        $last_thirty_day_views = 0;

        $total_downloads = 0;
        $last_day_downloads = 0;
        $last_seven_day_downloads = 0;
        $last_thirty_day_downloads = 0;

        $seven_days_date = Carbon::today()->subDays(7);
        $thirty_days_date = Carbon::today()->subDays(30);

        foreach($podcasts as $podcast) {
            $total_views += count($podcast->views);
            $last_day_views += Views::where(['podcast_id' => $podcast->id])->where('created_at', '>=', date('Y-m-d'))->count();
            $last_seven_day_views += Views::where(['podcast_id' => $podcast->id])->where('created_at', '>=', $seven_days_date)->count();
            $last_thirty_day_views += Views::where(['podcast_id' => $podcast->id])->where('created_at', '>=', $thirty_days_date)->count();


            $total_downloads += count($podcast->views);
            $last_day_downloads += Downloads::where(['podcast_id' => $podcast->id])->where('created_at', '>=', date('Y-m-d'))->count();
            $last_seven_day_downloads += Downloads::where(['podcast_id' => $podcast->id])->where('created_at', '>=', $seven_days_date)->count();
            $last_thirty_day_downloads += Downloads::where(['podcast_id' => $podcast->id])->where('created_at', '>=', $thirty_days_date)->count();
        }
        $total_subscribers = UserSubscribers::where(['user_id' => Auth::user()->id])->count();

        return view('dashboard.home', compact('podcasts', 'last_day_views', 'last_seven_day_views', 'last_thirty_day_views', 'total_views','last_day_downloads', 'last_seven_day_downloads', 'last_thirty_day_downloads', 'total_downloads', 'total_subscribers'));
    }

    public function UserChangePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6'
        ]);

        $user = User::where(['id' => Auth::user()->id])->first();
        if($user) {
            $check = Hash::check($request->old_password, $user->password);
            if($check) {
                $user->password = Hash::make($request->new_password);
                $user->save();
                Session::flash('message', 'Password changed!');
                Session::flash('alert-type', 'success');
                return redirect()->back();
            } else {
                Session::flash('message', 'Old password does not match!');
                Session::flash('alert-type', 'error');
                return redirect()->back();
            }
        } else {
            Session::flash('message', 'Something went wrong!');
            Session::flash('alert-type', 'error');
            return redirect()->back();
        }
    }
}
