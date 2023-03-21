<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Downloads;
use App\Models\Podcast;
use App\Models\Subscribers;
use App\Models\User;
use App\Models\UserSubscribers;
use App\Models\Views;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminDashboardController extends Controller
{
    public function Dashboard()
    {
        $users = User::where(['belongs_to' => Auth::user()->id])->with('podcasts')->get();
        $user_ids = [];
        $podcast_ids = [];
        foreach ($users as $user) {
            array_push($user_ids, $user->id);
        }
        $podcasts = Podcast::whereIn('user_id', $user_ids)->orWhere(['user_id' => Auth::user()->id])->get();
        foreach ($podcasts as $podcast) {
            array_push($podcast_ids, $podcast->id);
        }

        $total_downloads = 0;
        $last_day_downloads = 0;
        $last_seven_day_downloads = 0;
        $last_thirty_day_downloads = 0;

        $seven_days_date = Carbon::today()->subDays(7);
        $thirty_days_date = Carbon::today()->subDays(30);
        $all_views = Views::whereIn('podcast_id', $podcast_ids)->get();

        $total_views = count($all_views);
        $last_day_views = $all_views->where('created_at', '>=', date('Y-m-d'))->count();
        $last_seven_day_views = $all_views->where('created_at', '>=', $seven_days_date)->count();
        $last_thirty_day_views = $all_views->where('created_at', '>=', $thirty_days_date)->count();

        $all_downloads = Downloads::whereIn('podcast_id', $podcast_ids)->get();

        $total_downloads = count($all_downloads);
        $last_day_downloads = $all_downloads->where('created_at', '>=', date('Y-m-d'))->count();
        $last_seven_day_downloads = $all_downloads->where('created_at', '>=', $seven_days_date)->count();
        $last_thirty_day_downloads = $all_downloads->where('created_at', '>=', $thirty_days_date)->count();

        $total_subscribers = UserSubscribers::whereIn('user_id', $user_ids)->count();

        return view('admin.home', compact('users', 'podcasts', 'last_day_views', 'last_seven_day_views', 'last_thirty_day_views', 'total_views', 'last_day_downloads', 'last_seven_day_downloads', 'last_thirty_day_downloads', 'total_downloads', 'total_subscribers'));
    }

    public function AdminChangePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6'
        ]);

        $user = User::where(['id' => Auth::user()->id])->first();
        if ($user) {
            $check = Hash::check($request->old_password, $user->password);
            if ($check) {
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
