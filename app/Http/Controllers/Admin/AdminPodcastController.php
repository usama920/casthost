<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Podcast;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\PodcastsExport;
use App\Exports\UserPodcastsExport;
use App\Models\Categories;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Image;


class AdminPodcastController extends Controller
{
    public function ExportPodcasts()
    {
        return Excel::download(new PodcastsExport, 'PodcastsData.csv');
    }
    
    public function ExportUserPodcasts($id)
    {
        Session::put('UserPodcastsExportId', $id);
        return Excel::download(new UserPodcastsExport($id), 'PodcastsData.csv');
    }

    public function AdminPodcasts()
    {
        $podcasts = Podcast::where(['user_id' => Auth::user()->id])->with(['category', 'views', 'downloads'])->latest()->get();
        return view('admin.my_podcasts', compact('podcasts'));
    }

    public function NewPodcast()
    {
        $categories = Categories::where(['status' => 1, 'admin_id' => Auth::user()->id])->get();
        $date_now = date('Y-m-d H:i:s');
        return view('admin.new_podcast', compact('categories', 'date_now'));
    }

    public function UploadPodcast(Request $request)
    {
        if ($request->hasFile('podcast')) {
            $file = $request->file('podcast');
            $filename = $file->getClientOriginalName();
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            $random_filename = time() . uniqid() . "." . $ext;
            $folder = uniqid() . '-' . now()->timestamp;
            $file->storeAs('public/podcast/tmp/' . $folder, $random_filename);

            DB::table('podcast_tmp_file')->insert([
                'folder'    =>  $folder,
                'filename'  =>  $random_filename,
                'extension' =>  $ext,
            ]);
            return $folder;
        }
        return 'nothing';
    }

    public function RevertPodcast($id)
    {
        $file = DB::table('podcast_tmp_file')->where('folder', $id)->first();
        $file_path = storage_path('app/public/podcast/tmp/' . $id . '/' . $file->filename);
        if (file_exists($file_path)) {
            unlink($file_path);
            rmdir(storage_path('app/public/podcast/tmp/' . $file->folder));
        }
        DB::table('podcast_tmp_file')->where('folder', $id)->delete();
    }

    public function SavePodcast(Request $request)
    {

        $request->validate([
            'title' =>  'required',
            'category_id' =>  'required',
            'paid' =>  'required',
            'description'   =>  'required',
            'premiere_datetime' =>  'required'
        ]);

        $podcast = new Podcast();
        $podcast->user_id = Auth::user()->id;
        $podcast->title = $request->title;
        $podcast->slug = $request->title;
        $podcast->category_id = $request->category_id;
        $podcast->paid = $request->paid;
        $podcast->description = $request->description;
        $podcast->premiere_datetime = $request->premiere_datetime;
        $podcast->cover_image = $request->cover_image;
        $podcast->status = 1;
        $podcast->save();
        $podcast_id = $podcast->id;

        if ($request->hasFile('cover_image')) {
            $cover_image = $request->file('cover_image');
            $ext = $cover_image->extension();

            $rss_image_name = time() . uniqid() . '1500' . '.' . $ext;
            $destinationPath = public_path('/storage/podcast' . $podcast_id . '/images');
            $imgFile = Image::make($cover_image->getRealPath());
            $imgFile->resize(1500, 1500)->save($destinationPath . '/' . $rss_image_name);

            $cover_image_name = time() . uniqid() . '.' . $ext;
            $cover_image->storeAs('public/podcast/' . $podcast_id . '/images', $cover_image_name);
            Podcast::where('id', $podcast_id)->update([
                'cover_image'    =>  $cover_image_name,
                'other_rss_image'    =>  $rss_image_name
            ]);
        } else {
            Podcast::where('id', $podcast_id)->delete();
            Session::flash('message', 'Please provide valid cover image...');
            Session::flash('alert-type', 'error');
            return redirect()->back();
        }
        $file_path = storage_path('app/public/podcast/' . $podcast_id);
        $dirPermissions = "0755";
        if (file_exists($file_path)) {
            chmod($file_path, octdec($dirPermissions));
        }
        $file_path = storage_path('app/public/podcast/' . $podcast_id . '/images');
        if (file_exists($file_path)) {
            chmod($file_path, octdec($dirPermissions));
        }

        if ($request->podcast != null) {
            $podcast_tmp_file = DB::table('podcast_tmp_file')->where('folder', $request->podcast)->first();
            if ($podcast_tmp_file) {
                $file_path = storage_path('app/public/podcast/tmp/' . $podcast_tmp_file->folder . '/' . $podcast_tmp_file->filename);
                if (file_exists($file_path)) {
                    Storage::move('public/podcast/tmp/' . $podcast_tmp_file->folder . '/' . $podcast_tmp_file->filename, 'public/podcast/' . $podcast_id . '/' . $podcast_tmp_file->filename);
                    Podcast::where('id', $podcast_id)->update(['podcast'    =>  $podcast_tmp_file->filename, 'podcast_ext' => $podcast_tmp_file->extension]);
                    rmdir(storage_path('app/public/podcast/tmp/' . $podcast_tmp_file->folder));
                }
            } else {
                Podcast::where('id', $podcast_id)->delete();
                Session::flash('message', 'Please provide valid podcast file...');
                Session::flash('alert-type', 'error');
                return redirect()->back();
            }
        }

        Session::flash('message', 'Podcast Saved Successfully...');
        Session::flash('alert-type', 'success');
        return redirect('/admin/podcasts');
    }

    public function UpdatePodcast(Request $request)
    {
        $request->validate([
            'title' =>  'required',
            'category_id' =>  'required',
            'paid' =>  'required',
            'description'   =>  'required|min:50',
        ]);
        $existing_podcast = Podcast::find($request->id);

        if ($request->hasFile('cover_image')) {
            $file_path = storage_path('app/public/podcast/' . $request->id . '/images/' . $existing_podcast->cover_image);
            if (file_exists($file_path)) {
                unlink($file_path);
            }

            if ($existing_podcast->other_rss_image != null) {
                $file_path = storage_path('app/public/podcast/' . $request->id . '/images/' . $existing_podcast->other_rss_image);
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }

            $cover_image = $request->file('cover_image');
            $ext = $cover_image->extension();

            $rss_image_name = time() . uniqid() . '1500' . '.' . $ext;
            $destinationPath = public_path('/storage/podcast/' . $request->id . '/images');
            $imgFile = Image::make($cover_image->getRealPath());
            $imgFile->resize(1500, 1500)->save($destinationPath . '/' . $rss_image_name);

            $cover_image_name = time() . uniqid() . '.' . $ext;
            $cover_image->storeAs('public/podcast/' . $request->id . '/images', $cover_image_name);
            $existing_podcast->cover_image = $cover_image_name;
        }
        if (isset($request->premiere_datetime) && $request->premiere_datetime != null) {
            $existing_podcast->premiere_datetime = $request->premiere_datetime;
        }

        $existing_podcast->title = $request->title;
        $existing_podcast->category_id = $request->category_id;
        $existing_podcast->paid = $request->paid;
        $existing_podcast->description = $request->description;
        $existing_podcast->save();

        Session::flash('message', 'Podcast Updated Successfully...');
        Session::flash('alert-type', 'success');
        return redirect()->back();
    }

    public function DeletePodcast($id)
    {
        $podcast = Podcast::where([ 'id' => $id, 'user_id' => Auth::user()->id ])->first();
        if(!$podcast) {
            return redirect()->back();
        }
        $file_path = storage_path('app/public/podcast/' . $podcast->id . '/images/' . $podcast->cover_image);
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        if ($podcast->other_rss_image != null) {
            $file_path = storage_path('app/public/podcast/' . $podcast->id . '/images/' . $podcast->other_rss_image);
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }

        $file_path = storage_path('app/public/podcast/' . $podcast->id . '/' . $podcast->podcast);
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        if (file_exists(storage_path('app/public/podcast/' . $podcast->id))) {
            rmdir(storage_path('app/public/podcast/' . $podcast->id));
        }
        Podcast::where('id', $id)->delete();
        return redirect()->back();
    }

    public function InactivePodcast($id)
    {
        Podcast::where(['id' => $id])->update(['status' => 0]);
        return redirect()->back();
    }

    public function ActivePodcast($id)
    {
        Podcast::where(['id' => $id])->update(['status' => 1]);
        return redirect()->back();
    }

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
        $title = $request->title;
        $user_ids = [];
        foreach ($users as $user) {
            array_push($user_ids, $user->id);
        }
        $podcasts = Podcast::whereIn('user_id', $user_ids)->where('title', 'like', '%' . $title . '%')->get();
        return view('admin.all_podcasts', compact('podcasts', 'title'));
    }

    public function AdminPodcastDetail($id)
    {
        $podcast = Podcast::where('id', $id)->with(['views', 'downloads'])->first();
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
        $categories = Categories::where(['status' => 1])->get();
        $date_now = date('Y-m-d H:i:s');
        return view('admin.podcast_detail_admin', compact('podcast', 'categories', 'total_views', 'last_day_views', 'last_seven_day_views', 'last_thirty_day_views', 'total_downloads', 'last_day_downloads', 'last_seven_day_downloads', 'last_thirty_day_downloads', 'date_now'));
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
