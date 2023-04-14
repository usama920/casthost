<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\DefaultAboutPage;
use App\Models\DefaultContactPage;
use App\Models\DefaultHomePage;
use App\Models\Downloads;
use App\Models\Podcast;
use App\Models\SuperAdmin;
use App\Models\User;
use App\Models\UserAboutPage;
use App\Models\UserContact;
use App\Models\UserContactPage;
use App\Models\UserHomePage;
use App\Models\UserMessagesReply;
use App\Models\UserStorePage;
use App\Models\UserSubscribers;
use App\Models\Views;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class SuperDashboardController extends Controller
{
    public function Login()
    {
        if(is_super_admin()) {
            return redirect('/superAdmin');
        }
        return view('super_admin.login');
    }

    public function TryLogin(Request $request)
    {
        $request->validate([
            'username' => 'required', 
            'password' => 'required'
        ]);

        $super_admin = SuperAdmin::where(['username' => $request->username])->first();
        if($super_admin) {
            $check = Hash::check($request->password, $super_admin->password);
            if($check) {
                $request->session()->put('super_admin_id', $super_admin->id);
                $request->session()->put('super_admin_username', $super_admin->username);
                return redirect('/superAdmin/dashboard');
            } else {
                return redirect()->back();
            }
        } else {
            return redirect()->back();
        }
    }

    public function SuperLogout()
    {
        Session::forget('super_admin_id');
        Session::forget('super_admin_username');
        return redirect('/superAdmin/login');
    }

    public function Dashboard()
    {
        $admins = User::where(['role' => 1])->get();
        $podcasts = Podcast::all();

        $total_downloads = 0;
        $last_day_downloads = 0;
        $last_seven_day_downloads = 0;
        $last_thirty_day_downloads = 0;

        $seven_days_date = Carbon::today()->subDays(7);
        $thirty_days_date = Carbon::today()->subDays(30);
        $all_views = Views::all();
        $total_views = count($all_views);
        $last_day_views = $all_views->where('created_at', '>=', date('Y-m-d'))->count();
        $last_seven_day_views = $all_views->where('created_at', '>=', $seven_days_date)->count();
        $last_thirty_day_views = $all_views->where('created_at', '>=', $thirty_days_date)->count();

        $all_downloads = Downloads::all();
        $total_downloads = count($all_downloads);
        $last_day_downloads = $all_downloads->where('created_at', '>=', date('Y-m-d'))->count();
        $last_seven_day_downloads = $all_downloads->where('created_at', '>=', $seven_days_date)->count();
        $last_thirty_day_downloads = $all_downloads->where('created_at', '>=', $thirty_days_date)->count();

        return view('super_admin.dashboard', compact('admins', 'podcasts', 'last_day_views', 'last_seven_day_views', 'last_thirty_day_views', 'total_views', 'last_day_downloads', 'last_seven_day_downloads', 'last_thirty_day_downloads', 'total_downloads'));
    }

    public function Admins()
    {
        $admins = User::where('role', '=', 1)->get();
        foreach($admins as $key => $admin) {
            $admins[$key]->memory_used = 0;
        }
        return view('super_admin.admins', compact('admins'));
    }

    public function AdminLogin($id)
    {
        $admin = User::where(['id' => $id, 'role' => 1])->first();
        if($admin) {
            Auth::login($admin);
            return redirect('/admin/dashboard');
        } else {
            return redirect()->back();
        }
    }

    public function AddAdminVerifyDuplication(Request $request)
    {
        $request->validate([
            // 'email' => 'required|email',
            'username' => 'required'
        ]);
        // $users = User::where(['email' => $request->email])->get();
        // if (count($users) > 0) {
        //     return response()->json(['status' => 'error', 'message' => 'Email already exists.']);
        // }
        $users = User::where(['username' => $request->username])->get();
        if (count($users) > 0) {
            return response()->json(['status' => 'error', 'message' => 'Username already exists.']);
        }
        return response()->json(['status' => 'success']);
    }

    public function AdminAdd(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'name' => 'required',
            'username' => 'required',
            'password' => 'required',
            'memory_limit' => 'required'
        ]);
        $hashed_password = Hash::make($request->password);
        $admin = new User();
        $admin->name = $request->name;
        $admin->username = $request->username;
        $admin->email = $request->email;
        $admin->memory_limit = $request->memory_limit;
        $admin->role = 1;
        $admin->status = 1;
        $admin->password = $hashed_password;
        $admin->save();

        $default_home_page = new DefaultHomePage();
        $default_home_page->image = null;
        $file_path = public_path('project_assets/images/default_home.jpg');
        if (file_exists($file_path)) {
            $extension = pathinfo(public_path('project_assets/images/default_home.jpg'), PATHINFO_EXTENSION);
            $image_name = time() . uniqid() . '.' . $extension;
            File::copy(public_path('project_assets/images/default_home.jpg'), public_path('project_assets/images/' . $image_name));
            $default_home_page->image = $image_name;
        }
        $default_home_page->admin_id = $admin->id;
        $default_home_page->save();

        $default_contact_page = new DefaultContactPage();
        $default_contact_page->image = null;
        $file_path = public_path('project_assets/images/default_contact.jpg');
        if (file_exists($file_path)) {
            $extension = pathinfo(public_path('project_assets/images/default_contact.jpg'), PATHINFO_EXTENSION);
            $image_name = time() . uniqid() . '.' . $extension;
            File::copy(public_path('project_assets/images/default_contact.jpg'), public_path('project_assets/images/' . $image_name));
            $default_contact_page->image = $image_name;
        }
        $default_contact_page->heading = "Contact";
        $default_contact_page->text = "Contact Description";
        $default_contact_page->admin_id = $admin->id;
        $default_contact_page->save();

        $default_about_page = new DefaultAboutPage();
        $default_about_page->cover_image = null;
        $file_path = public_path('project_assets/images/default_about.jpg');
        if (file_exists($file_path)) {
            $extension = pathinfo(public_path('project_assets/images/default_about.jpg'), PATHINFO_EXTENSION);
            $image_name = time() . uniqid() . '.' . $extension;
            File::copy(public_path('project_assets/images/default_about.jpg'), public_path('project_assets/images/' . $image_name));
            $default_about_page->cover_image = $image_name;
        }
        $default_about_page->profile_image = null;
        $file_path = public_path('project_assets/images/default_about_profile.jpg');
        if (file_exists($file_path)) {
            $extension = pathinfo(public_path('project_assets/images/default_about_profile.jpg'), PATHINFO_EXTENSION);
            $image_name = time() . uniqid("", true) . '.' . $extension;
            File::copy(public_path('project_assets/images/default_about_profile.jpg'), public_path('project_assets/images/' . $image_name));
            $default_about_page->profile_image = $image_name;
        }
        $default_about_page->heading = "About Me";
        $default_about_page->text = "About Me Description";
        $default_about_page->admin_id = $admin->id;
        $default_about_page->save();

        $default_about_page = DefaultAboutPage::where(['admin_id' => $admin->id])->first();
        $user_about_page = new UserAboutPage();
        $user_about_page->user_id = $admin->id;
        $user_about_page->cover_image = null;
        $file_path = public_path('project_assets/images/' . $default_about_page->cover_image);
        if (file_exists($file_path) && $default_about_page->cover_image != null) {
            $extension = pathinfo(public_path('project_assets/images/' . $default_about_page->cover_image), PATHINFO_EXTENSION);
            $image_name = time() . uniqid() . '.' . $extension;
            File::copy(public_path('project_assets/images/' . $default_about_page->cover_image), public_path('project_assets/images/' . $image_name));
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

        $default_contact_page = DefaultContactPage::where(['admin_id' => $admin->id])->first();
        $user_contact_page = new UserContactPage();
        $user_contact_page->user_id = $admin->id;
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

        $default_home_page = DefaultHomePage::where(['admin_id' => $admin->id])->first();
        $user_home_page = new UserHomePage();
        $user_home_page->user_id = $admin->id;
        $user_home_page->image = null;
        $file_path = public_path('project_assets/images/' . $default_home_page->image);
        if (file_exists($file_path) && $default_home_page->image != null) {
            $extension = pathinfo(public_path('project_assets/images/' . $default_home_page->image), PATHINFO_EXTENSION);
            $image_name = time() . uniqid() . '.' . $extension;
            File::copy(public_path('project_assets/images/' . $default_home_page->image), public_path('project_assets/images/' . $image_name));
            $user_home_page->image = $image_name;
        }
        $user_home_page->save();

        $user_store_page = new UserStorePage();
        $user_store_page->user_id = $admin->id;
        $user_store_page->image = null;
        $file_path = public_path('project_assets/images/' . $default_home_page->image);
        if (file_exists($file_path) && $default_home_page->image != null) {
            $extension = pathinfo(public_path('project_assets/images/' . $default_home_page->image), PATHINFO_EXTENSION);
            $image_name = time() . uniqid() . '.' . $extension;
            File::copy(public_path('project_assets/images/' . $default_home_page->image), public_path('project_assets/images/' . $image_name));
            $user_store_page->image = $image_name;
        }
        $user_store_page->save();

        return redirect()->back();
    }

    public function SearchAdmin(Request $request)
    {
        $admins = User::where('email', 'like', '%' . $request->title . '%')->where('role', '=', 1)->get();
        return view('super_admin.admins', compact('admins'));
    }

    public function InactiveAdmin($id)
    {
        User::where('id', $id)->update(['status'   =>  0]);
        return redirect()->back();
    }

    public function ActiveAdmin($id)
    {
        User::where('id', $id)->update(['status'   =>  1]);
        return redirect()->back();
    }

    public function AdminDelete($id)
    {
        $admin = User::where(['id' => $id, 'role' => 1])->with(['podcasts'])->first();
        if($admin) {
            $users = User::where(['belongs_to' => $admin->id])->with(['podcasts'])->get();
            foreach($users as $user) {
                $podcasts = $user->podcasts;
                foreach($podcasts as $podcast) {
                    $file_path = storage_path('app/public/podcast/' . $podcast->id);
                    if (file_exists($file_path)) {
                       $this->delTree($file_path);
                    }
                    Views::where(['podcast_id' => $podcast->id])->delete();
                    Downloads::where(['podcast_id' => $podcast->id])->delete();
                }
                Podcast::where(['user_id' => $user->id])->delete();

                UserSubscribers::where(['user_id' => $user->id])->delete();
                $user_contact = UserContact::where(['user_id' => $user->id])->get();
                foreach($user_contact as $contact) {
                    UserMessagesReply::where(['message_id' => $contact->id])->delete();
                }
                UserContact::where(['user_id' => $user->id])->delete();

                $user_home_page = UserHomePage::where(['user_id' => $user->id])->first();
                if($user_home_page && $user_home_page->image !== null) {
                    $file_path = public_path('project_assets/images/' . $user_home_page->image);
                    if (file_exists($file_path)) {
                        unlink($file_path);
                    }
                }
                UserHomePage::where(['user_id' => $user->id])->delete();

                $user_contact_page = UserContactPage::where(['user_id' => $user->id])->first();
                if ($user_contact_page && $user_contact_page->image !== null) {
                    $file_path = public_path('project_assets/images/' . $user_contact_page->image);
                    if (file_exists($file_path)) {
                        unlink($file_path);
                    }
                }
                UserContactPage::where(['user_id' => $user->id])->delete();

                $user_about_page = UserAboutPage::where(['user_id' => $user->id])->first();
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
                UserAboutPage::where(['user_id' => $user->id])->delete();
            }
            User::where(['belongs_to' => $admin->id])->delete();

            $podcasts = $admin->podcasts;
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

            $user_store_page = UserStorePage::where(['user_id' => $id])->first();
            if ($user_store_page && $user_store_page->image !== null) {
                $file_path = public_path('project_assets/images/' . $user_store_page->image);
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }
            UserStorePage::where(['user_id' => $id])->delete();

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

            $default_home_page = DefaultHomePage::where(['admin_id' => $id])->first();
            if ($default_home_page && $default_home_page->image !== null) {
                $file_path = public_path('project_assets/images/' . $default_home_page->image);
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }
            DefaultHomePage::where(['admin_id' => $id])->delete();

            $default_contact_page = DefaultContactPage::where(['admin_id' => $id])->first();
            if ($default_contact_page && $default_contact_page->image !== null) {
                $file_path = public_path('project_assets/images/' . $default_contact_page->image);
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }
            DefaultContactPage::where(['admin_id' => $id])->delete();

            $default_about_page = DefaultAboutPage::where(['admin_id' => $id])->first();
            if ($default_about_page && $default_about_page->profile_image !== null) {
                $file_path = public_path('project_assets/images/' . $default_about_page->profile_image);
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }
            if ($default_about_page && $default_about_page->cover_image !== null) {
                $file_path = public_path('project_assets/images/' . $default_about_page->cover_image);
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }
            DefaultAboutPage::where(['admin_id' => $id])->delete();

            Categories::where(['admin_id' => $id])->delete();

            User::where(['id' => $id, 'role' => 1])->delete();
        }
        return redirect()->back();
    }

    public function delTree($dir)
    {
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? $this->delTree("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    } 

    public function AdminEditMemory(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'newMemoryLimit' => 'required'
        ]);
        $user = User::where(['id' => $request->id])->first();
        if($user) {
            $get_memory_usage_bytes = get_memory_usage_bytes($user->id, "admin");
            if($get_memory_usage_bytes < ($request->newMemoryLimit * 1073741824)) {
                User::where(['id' => $request->id])->update([
                    'memory_limit' => $request->newMemoryLimit
                ]);
                Session::flash('message', 'Memory limit updated successfully.');
                Session::flash('alert-type', 'success');
            } else {
                Session::flash('message', 'Invalid memory limit.');
                Session::flash('alert-type', 'error');
            }
        }
        return redirect()->back();
    }

}
