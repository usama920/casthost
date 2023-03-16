<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Podcast;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PodcastController extends Controller
{
    public function UserPodcasts()
    {
        $podcasts = Podcast::where('user_id', Auth::user()->id)->with(['category', 'views', 'downloads'])->latest()->get();
        return view('dashboard.all_podcasts', compact('podcasts'));
    }
    
    public function PodcastDetail($id)
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
        if($podcast->premiere_datetime > $date_now) {
            // prx($podcast);
        }
        return view('dashboard.podcast_detail', compact('podcast', 'categories', 'total_views', 'last_day_views', 'last_seven_day_views', 'last_thirty_day_views', 'total_downloads', 'last_day_downloads', 'last_seven_day_downloads', 'last_thirty_day_downloads', 'date_now'));
    }
    
    public function NewPodcast()
    {
        $categories = Categories::where(['status' => 1, 'admin_id' => Auth::user()->belongs_to])->get();
        $date_now = date('Y-m-d H:i:s');
        return view('dashboard.new_podcast', compact('categories', 'date_now'));
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
        return '';
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
            'description'   =>  'required|min:50',
            'premiere_datetime' =>  'required',
            'cover_image'   =>  'required',
            'podcast'   =>  'required'
        ]);

        $podcast = new Podcast();
        $podcast->user_id = Auth::user()->id;
        $podcast->title = $request->title;
        $podcast->slug = $request->title;
        $podcast->category_id = $request->category_id;
        $podcast->description = $request->description;
        $podcast->premiere_datetime = $request->premiere_datetime;
        $podcast->cover_image = $request->cover_image;
        $podcast->status = 1;
        $podcast->save();
        $podcast_id = $podcast->id;

        if ($request->hasFile('cover_image')) {
            $cover_image = $request->file('cover_image');
            $ext = $cover_image->extension();
            $cover_image_name = time() . uniqid() . '.' . $ext;
            $cover_image->storeAs('public/podcast/'.$podcast_id.'/images', $cover_image_name);
            Podcast::where('id', $podcast_id)->update(['cover_image'    =>  $cover_image_name]);
        } else {
            Podcast::where('id', $podcast_id)->delete();
            Session::flash('message', 'Please provide valid cover image...');
            Session::flash('alert-type', 'error');
            return redirect()->back();
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
        return redirect('/users/podcasts');
    }

    public function UpdatePodcast(Request $request)
    {
        $request->validate([
            'title' =>  'required',
            'category_id' =>  'required',
            'description'   =>  'required|min:50',
        ]);
        $existing_podcast = Podcast::find($request->id);

        if ($request->hasFile('cover_image')) {
            $file_path = storage_path('app/public/podcast/'.$request->id.'/images/'.$existing_podcast->cover_image);
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            $cover_image = $request->file('cover_image');
            $ext = $cover_image->extension();
            $cover_image_name = time() . uniqid() . '.' . $ext;
            $cover_image->storeAs('public/podcast/'.$request->id.'/images', $cover_image_name);
            $existing_podcast->cover_image = $cover_image_name;
        }
        if(isset($request->premiere_datetime) && $request->premiere_datetime != null) {

            $existing_podcast->premiere_datetime = $request->premiere_datetime;
        }

        $existing_podcast->title = $request->title;
        $existing_podcast->category_id = $request->category_id;
        $existing_podcast->description = $request->description;
        $existing_podcast->save();

        Session::flash('message', 'Podcast Updated Successfully...');
        Session::flash('alert-type', 'success');
        return redirect()->back();
    }

    public function DeletePodcast($id)
    {
        $podcast = Podcast::where('id', $id)->first();
        $file_path = storage_path('app/public/podcast/' . $podcast->id . '/images/' . $podcast->cover_image);
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        $file_path = storage_path('app/public/podcast/' . $podcast->id . '/' . $podcast->podcast);
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        if(file_exists(storage_path('app/public/podcast/' . $podcast->id))) {
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
}
