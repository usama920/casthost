<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use App\Models\DefaultAboutPage;
use App\Models\DefaultContactPage;
use App\Models\DefaultHomePage;
use App\Models\Downloads;
use App\Models\Podcast;
use App\Models\SuperAdmin;
use App\Models\User;
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
            'email' => 'required|email'
        ]);
        $users = User::where(['email' => $request->email])->get();
        if (count($users) > 0) {
            return response()->json(['status' => 'error', 'message' => 'Email already exists.']);
        }
        return response()->json(['status' => 'success']);
    }

    public function AdminAdd(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        $hashed_password = Hash::make($request->password);
        $admin = new User();
        $admin->email = $request->email;
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
        if (file_exists($file_path) && $default_about_page->profile_image != null) {
            $extension = pathinfo(public_path('project_assets/images/default_about_profile.jpg'), PATHINFO_EXTENSION);
            $image_name = time() . uniqid() . '.' . $extension;
            File::copy(public_path('project_assets/images/default_about_profile.jpg'), public_path('project_assets/images/' . $image_name));
            $default_about_page->profile_image = $image_name;
        }
        $default_about_page->heading = "About Me";
        $default_about_page->text = "About Me Description";
        $default_about_page->admin_id = $admin->id;
        $default_about_page->save();

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

}
