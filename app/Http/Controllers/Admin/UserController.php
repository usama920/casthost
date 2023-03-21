<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Models\BasicSettings;
use App\Models\Categories;
use App\Models\DefaultAboutPage;
use App\Models\DefaultContactPage;
use App\Models\DefaultHomePage;
use App\Models\Downloads;
use App\Models\Podcast;
use App\Models\User;
use App\Models\UserAboutPage;
use App\Models\UserContact;
use App\Models\UserContactPage;
use App\Models\UserHomePage;
use App\Models\UserMessagesReply;
use App\Models\UserSubscribers;
use App\Models\Views;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function ExportUsers()
    {
        return Excel::download(new UsersExport, 'UsersData.csv');
    }

    public function AddUser(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required',
            'password' => 'required',
            'username' => 'required',
            'memory_limit' => 'required'
        ]);
        $user = new User();
        $user->email = $request->email;
        $user->name = $request->name;
        $user->memory_limit = $request->memory_limit;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->role = 2;
        $user->belongs_to = Auth::user()->id;
        $user->status = 1;
        $user->save();
        $user_id = $user->id;
        
        $default_about_page = DefaultAboutPage::first();
        $user_about_page = new UserAboutPage();
        $user_about_page->user_id = $user_id;
        $user_about_page->cover_image = null;
        $file_path = public_path('project_assets/images/' . $default_about_page->cover_image);
        if (file_exists($file_path) && $default_about_page->cover_image != null) {
            $extension = pathinfo(public_path('project_assets/images/' . $default_about_page->cover_image), PATHINFO_EXTENSION);
            $image_name = time() . uniqid() . '.' . $extension;
            File::copy(public_path('project_assets/images/'.$default_about_page->cover_image), public_path('project_assets/images/'.$image_name));
            $user_about_page->cover_image = $image_name;
        }
        $user_about_page->profile_image = null;
        $file_path = public_path('project_assets/images/' . $default_about_page->profile_image);
        if (file_exists($file_path) && $default_about_page->profile_image != null) {
            $extension = pathinfo(public_path('project_assets/images/' . $default_about_page->profile_image), PATHINFO_EXTENSION);
            $image_name = time() . uniqid() . '.' . $extension;
            File::copy(public_path('project_assets/images/' . $default_about_page->profile_image), public_path('project_assets/images/' . $image_name));
            $user_about_page->profile_image = $image_name;
        }
        $user_about_page->heading = $default_about_page->heading;
        $user_about_page->text = $default_about_page->text;
        $user_about_page->save();

        $default_contact_page = DefaultContactPage::first();
        $user_contact_page = new UserContactPage();
        $user_contact_page->user_id = $user_id;
        $user_contact_page->image = null;
        $file_path = public_path('project_assets/images/' . $default_contact_page->image);
        if (file_exists($file_path) && $default_contact_page->image != null) {
            $extension = pathinfo(public_path('project_assets/images/' . $default_contact_page->image), PATHINFO_EXTENSION);
            $image_name = time() . uniqid() . '.' . $extension;
            File::copy(public_path('project_assets/images/' . $default_contact_page->image), public_path('project_assets/images/' . $image_name));
            $user_contact_page->image = $image_name;
        }
        $user_contact_page->heading = $default_contact_page->heading;
        $user_contact_page->text = $default_contact_page->text;
        $user_contact_page->save();

        $default_home_page = DefaultHomePage::first();
        $user_home_page = new UserHomePage();
        $user_home_page->user_id = $user_id;
        $user_home_page->image = null;
        $file_path = public_path('project_assets/images/' . $default_home_page->image);
        if (file_exists($file_path) && $default_home_page->image != null) {
            $extension = pathinfo(public_path('project_assets/images/' . $default_home_page->image), PATHINFO_EXTENSION);
            $image_name = time() . uniqid() . '.' . $extension;
            File::copy(public_path('project_assets/images/' . $default_home_page->image), public_path('project_assets/images/' . $image_name));
            $user_home_page->image = $image_name;
        }
        $user_home_page->save();

        $basic_settings = BasicSettings::first();
        $data = ['logo' => $basic_settings->site_logo, 'site_name' => $basic_settings->site_title, 'name' => $request->name, 'user_email' => $request->email, 'user_password' => $request->password, 'site_title' => $basic_settings->site_title];
        $user['site_title'] = $basic_settings->site_title;
        $user['to'] = $request->email;
        $mail_username = env('MAIL_USERNAME');

        try {
            Mail::send('mails.add_user', $data, function ($message) use ($user, $mail_username) {
                $message->from($mail_username, $user['site_title']);
                $message->sender($mail_username, $user['site_title']);
                $message->to($user['to']);
                $message->subject('Welcome to '.$user['site_title']);
                $message->priority(3);
            });
        } catch (Exception $e) {
        }

        Session::flash('message', 'New user added successfully...');
        Session::flash('alert-type', 'success');
        return redirect()->back();
        return view('admin.add-user');    
    }

    public function AddUserVerifyDuplication(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'username' => 'required'
        ]);
        $users = User::where(['email' => $request->email])->get();
        if(count($users) > 0) {
            return response()->json(['status' => 'error', 'message' => 'Email already exists.']);
        }
        $users = User::where(['username' => $request->username])->get();
        if (count($users) > 0) {
            return response()->json(['status' => 'error', 'message' => 'Username already exists.']);
        }
        return response()->json(['status' => 'success']);
    }

    public function Users()
    {
        $users = User::where(['role' => 2, 'belongs_to' => Auth::user()->id])->withCount(['podcasts', 'subscribers'])->get();
        $admin_memory_limit = Auth::user()->memory_limit;
        foreach($users as $key => $user) {
            $admin_memory_limit -= $user->memory_limit;
            $users[$key]->total_views = 0;
            $users[$key]->total_downloads = 0;
            $podcasts = $user->podcasts;
            foreach($podcasts as $podcast) {
                $users[$key]->total_views += Views::where(['podcast_id' => $podcast->id])->count();
                $users[$key]->total_downloads += Downloads::where(['podcast_id' => $podcast->id])->count();
            }
        }
        
        return view('admin.users', compact('users', 'admin_memory_limit'));
    }

    public function UserDetail($id)
    {
        $user = User::find($id);
        if (!$user || $user->belongs_to != Auth::user()->id) {
            return redirect()->back();
        }
        $user_podcasts = $user->podcasts;
        $total_views = 0;
        $total_downloads = 0;
        foreach($user_podcasts as $key => $podcast) {
            $user_podcasts[$key]->category = Categories::find($podcast->category_id);
            $total_views += Views::where(['podcast_id' => $podcast->id])->count();
            $total_downloads += Downloads::where(['podcast_id' => $podcast->id])->count();
        }
        return view('admin.user_detail', compact('user', 'total_views', 'total_downloads'));
    }

    public function SearchUser(Request $request)
    {
        $users = User::where(['role' => 2, 'belongs_to' => Auth::user()->id])->where('email', 'like', '%' . $request->title . '%')->orWhere('name', 'like', '%' . $request->title . '%')->withCount(['podcasts', 'subscribers'])->get();
        foreach ($users as $key => $user) {
            $users[$key]->total_views = 0;
            $users[$key]->total_downloads = 0;
            $podcasts = $user->podcasts;
            foreach ($podcasts as $podcast) {
                $users[$key]->total_views += Views::where(['podcast_id' => $podcast->id])->count();
                $users[$key]->total_downloads += Downloads::where(['podcast_id' => $podcast->id])->count();
            }
            $users[$key]->subscribers = count($user->subscribers);
        }
        return view('admin.users', compact('users'));
    }

    public function InactiveUser($id)
    {
        $user = User::find($id);
        if($user && $user->belongs_to == Auth::user()->id) {
            User::where('id', $id)->update(['status'   =>  0]);
        }
        return redirect()->back();
    }

    public function ActiveUser($id)
    {
        $user = User::find($id);
        if ($user && $user->belongs_to == Auth::user()->id) {
            User::where('id', $id)->update(['status'   =>  1]);
        }
        return redirect()->back();
    }

    public function InactivePodcast($id)
    {
        $podcast = Podcast::find($id);
        if($podcast) {
            $user = User::find($podcast->user_id);
            if($user && $user->belongs_to == Auth::user()->id) {
                Podcast::where('id', $id)->update(['admin_status'   =>  0]);
            }
        }
        return redirect()->back();
    }

    public function ActivePodcast($id)
    {
        $podcast = Podcast::find($id);
        if ($podcast) {
            $user = User::find($podcast->user_id);
            if ($user && $user->belongs_to == Auth::user()->id) {
                Podcast::where('id', $id)->update(['admin_status'   =>  1]);
            }
        }
        return redirect()->back();
    }

    public function DeleteUser($id)
    {
        $user = User::where(['id' => $id, 'role' => 2, 'belongs_to' => Auth::user()->id])->with(['podcasts'])->first();
        if ($user) {
            $podcasts = $user->podcasts;
            foreach ($podcasts as $podcast) {
                $file_path = storage_path('app/public/podcast/' . $podcast->id);
                if (file_exists($file_path)) {
                    $this->delTree($file_path);
                }
                Views::where(['podcast_id' => $podcast->id])->delete();
                Downloads::where(['podcast_id' => $podcast->id])->delete();
            }
            Podcast::where(['user_id' => $id])->delete();

            UserSubscribers::where(['user_id' => $id])->delete();
            $user_contact = UserContact::where(['user_id' => $id])->get();
            foreach ($user_contact as $contact) {
                UserMessagesReply::where(['message_id' => $contact->id])->delete();
            }
            UserContact::where(['user_id' => $id])->delete();

            $user_home_page = UserHomePage::where(['user_id' => $id])->first();
            if ($user_home_page && $user_home_page->image !== null) {
                $file_path = public_path('project_assets/images/' . $user_home_page->image);
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }
            UserHomePage::where(['user_id' => $id])->delete();

            $user_contact_page = UserContactPage::where(['user_id' => $id])->first();
            if ($user_contact_page && $user_contact_page->image !== null) {
                $file_path = public_path('project_assets/images/' . $user_contact_page->image);
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }
            UserContactPage::where(['user_id' => $id])->delete();

            $user_about_page = UserAboutPage::where(['user_id' => $id])->first();
            if ($user_about_page && $user_about_page->profile_image !== null) {
                $file_path = public_path('project_assets/images/' . $user_about_page->profile_image);
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }
            if ($user_about_page && $user_about_page->cover_image !== null) {
                $file_path = public_path('project_assets/images/' . $user_about_page->cover_image);
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }
            UserAboutPage::where(['user_id' => $id])->delete();

            User::where(['id' => $id, 'role' => 1])->delete();
        }
        return redirect()->back();
    }

    public function UserEditMemory(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'newMemoryLimit' => 'required'
        ]);
        $user = User::where(['id' => $request->id, 'belongs_to' => Auth::user()->id])->first();
        if ($user) {
            $get_memory_usage_bytes = get_memory_usage_bytes($user->id, "admin");
            if ($get_memory_usage_bytes < ($request->newMemoryLimit * 1073741824)) {
                User::where(['id' => $request->id])->update([
                    'memory_limit' => $request->newMemoryLimit
                ]);
                Session::flash('message', 'Memory limit updated successfully.');
                Session::flash('alert-type', 'success');
            } else {
                Session::flash('message', 'Invalid memory limit.');
                Session::flash('alert-type', 'error');
            }
        } else {
            Session::flash('message', 'Invalid user access.');
            Session::flash('alert-type', 'error');
        }
        return redirect()->back();
    }
}
