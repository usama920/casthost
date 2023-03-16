<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use App\Models\AboutPage;
use App\Models\ContactPage;
use App\Models\HomePage;
use App\Models\LoginPage;
use Illuminate\Http\Request;

class SuperPageController extends Controller
{
    public function HomePage()
    {
        $page = HomePage::first();
        return view('super_admin.home_page', compact('page'));
    }

    public function HomePageSave(Request $request)
    {
        $page = HomePage::first();
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

    public function LoginPage()
    {
        $page = LoginPage::first();
        return view('super_admin.login_page', compact('page'));
    }

    public function LoginPageSave(Request $request)
    {
        $request->validate([
            'login_heading' =>  'required',
            'subscriber_heading' =>  'required',
            'login_text' =>  'required',
            'subscriber_text' =>  'required'
        ]);
        $page = LoginPage::first();
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
        $page->login_heading = $request->login_heading;
        $page->subscriber_heading = $request->subscriber_heading;
        $page->login_text = $request->login_text;
        $page->subscriber_text = $request->subscriber_text;
        $page->save();
        return redirect()->back();
    }

    public function ContactPage()
    {
        $page = ContactPage::first();
        return view('super_admin.contact_page', compact('page'));
    }

    public function ContactPageSave(Request $request)
    {
        $request->validate([
            'heading' =>  'required',
            'text' =>  'required'
        ]);
        $page = ContactPage::first();
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
        $page = AboutPage::first();
        return view('super_admin.about_page', compact('page'));
    }

    public function AboutPageSave(Request $request)
    {
        $request->validate([
            'heading' =>  'required',
            'text' =>  'required',
            'mission' =>  'required',
            'vision' =>  'required'
        ]);
        $page = AboutPage::first();
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
        $page->mission = $request->mission;
        $page->vision = $request->vision;
        $page->text = $request->text;
        $page->save();
        return redirect()->back();
    }
}
