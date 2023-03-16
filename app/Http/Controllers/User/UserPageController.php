<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\UserAboutPage;
use App\Models\UserContactPage;
use App\Models\UserHomePage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserPageController extends Controller
{
    public function HomePage()
    {
        $page = UserHomePage::where(['user_id' => Auth::user()->id])->first();
        return view('dashboard.user_home_page', compact('page'));
    }

    public function HomePageSave(Request $request)
    {
        prx($request->file());
        $page = UserHomePage::where(['user_id' => Auth::user()->id])->first();
        if ($request->hasFile('image')) {
            $file_path = public_path('project_assets/images/' . $page->image);
            if (file_exists($file_path) && $page->image != null) {
                unlink($file_path);
            }
            $image = $request->file('image');
            $ext = $image->extension();
            $image_name = time() . uniqid() . '.' . $ext;
            $image->move(public_path('project_assets/images'), $image_name);
            $page->image = $image_name;
            $page->save();
        }
        return redirect()->back();
    }

    public function ContactPage()
    {
        $page = UserContactPage::where(['user_id' => Auth::user()->id])->first();
        return view('dashboard.user_contact_page', compact('page'));
    }

    public function ContactPageSave(Request $request)
    {
        $request->validate([
            'heading' =>  'required',
            'text' =>  'required'
        ]);
        $page = UserContactPage::where(['user_id' => Auth::user()->id])->first();
        if ($request->hasFile('image')) {
            $file_path = public_path('project_assets/images/' . $page->image);
            if (file_exists($file_path) && $page->image != null) {
                unlink($file_path);
            }
            $image = $request->file('image');
            $ext = $image->extension();
            $image_name = time() . uniqid() . '.' . $ext;
            $image->move(public_path('project_assets/images'), $image_name);
            $page->image = $image_name;
        }
        $page->heading = $request->heading;
        $page->text = $request->text;
        $page->save();
        return redirect()->back();
    }

    public function AboutPage()
    {
        $page = UserAboutPage::where(['user_id' => Auth::user()->id])->first();
        return view('dashboard.user_about_page', compact('page'));
    }

    public function AboutPageSave(Request $request)
    {
        $request->validate([
            'heading' =>  'required',
            'text' =>  'required'
        ]);
        $page = UserAboutPage::where(['user_id' => Auth::user()->id])->first();
        if ($request->hasFile('cover_image')) {
            $file_path = public_path('project_assets/images/' . $page->cover_image);
            if (file_exists($file_path) && $page->cover_image != null) {
                unlink($file_path);
            }
            $image = $request->file('cover_image');
            $ext = $image->extension();
            $image_name = time() . uniqid() . '.' . $ext;
            $image->move(public_path('project_assets/images'), $image_name);
            $page->cover_image = $image_name;
        }
        if ($request->hasFile('profile_image')) {
            $file_path = public_path('project_assets/images/' . $page->profile_image);
            if (file_exists($file_path) && $page->profile_image != null) {
                unlink($file_path);
            }
            $image = $request->file('profile_image');
            $ext = $image->extension();
            $image_name = time() . uniqid() . '.' . $ext;
            $image->move(public_path('project_assets/images'), $image_name);
            $page->profile_image = $image_name;
        }
        $page->heading = $request->heading;
        $page->text = $request->text;
        $page->save();
        return redirect()->back();
    }
}
