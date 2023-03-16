<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Podcast;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPodcastController extends Controller
{
    public function UsersPodcasts()
    {
        $users = User::where(['belongs_to' => Auth::user()->id])->get();
        $user_ids = [];
        foreach ($users as $user) {
            array_push($user_ids, $user->id);
        }
        $podcasts = Podcast::whereIn('user_id', $user_ids)->with(['category', 'views', 'downloads'])->latest()->get();
        return view('admin.all_podcasts', compact('podcasts'));
    }

    public function UsersPodcastsSearch(Request $request)
    {
        $users = User::where(['belongs_to' => Auth::user()->id])->get();
        $user_ids = [];
        foreach ($users as $user) {
            array_push($user_ids, $user->id);
        }
        $podcasts = Podcast::whereIn('user_id', $user_ids)->where('title', 'like', '%' . $request->title . '%')->get();
        return view('admin.all_podcasts', compact('podcasts'));
    }

    public function PodcastDetail($id)
    {
        $podcast = Podcast::where('id', $id)->with(['views', 'downloads'])->first();
        $user = User::where(['id' => $podcast->user_id])->first();

        if($podcast && $user && $user->belongs_to == Auth::user()->id) {
            $user = User::find($podcast->user_id);
            if($user && $user->belongs_to == Auth::user()->id) {
                $seven_days_date = Carbon::today()->subDays(7);
                $thirty_days_date = Carbon::today()->subDays(30);
                $total_views = $podcast->podcastViewsCount();
                $total_views = count($podcast->views);
                $last_day_views = count($podcast->views->where('created_at', '>=', date('Y-m-d')));
                $last_seven_day_views = count($podcast->views->where('created_at', '>=', $seven_days_date));
                $last_thirty_day_views = count($podcast->views->where('created_at', '>=', $thirty_days_date));
        
                $total_downloads = count($podcast->downloads);
                $last_day_downloads = count($podcast->downloads->where('created_at', '>=', date('Y-m-d')));
                $last_seven_day_downloads = count($podcast->downloads->where('created_at', '>=', $seven_days_date));
                $last_thirty_day_downloads = count($podcast->downloads->where('created_at', '>=', $thirty_days_date));
        
        
                $total_views = $podcast->podcastViewsCount();
                $total_downloads = $podcast->podcastDownloadsCount();
                return view('admin.podcast_detail', compact('podcast','total_views', 'last_day_views', 'last_seven_day_views', 'last_thirty_day_views', 'total_downloads', 'last_day_downloads', 'last_seven_day_downloads', 'last_thirty_day_downloads'));
            }
        }

        return redirect()->back();
    }
}
