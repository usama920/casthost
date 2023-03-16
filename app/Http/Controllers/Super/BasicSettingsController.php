<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use App\Models\BasicSettings;
use Illuminate\Http\Request;

class BasicSettingsController extends Controller
{
    public function BasicSettings()
    {
        $settings = BasicSettings::first();
        return view('super_admin.basic_settings', compact('settings'));
    }

    public function BasicSettingsSave(Request $request)
    {
        $request->validate([
            'site_title' => 'required'
        ]);
        $existing_settings = BasicSettings::first();
        if ($request->hasFile('site_logo')) {
            $file_path = public_path('project_assets/images/' . $existing_settings->site_logo);
            if(file_exists($file_path) && $existing_settings->site_logo) {
                unlink($file_path);
            }
            $site_logo = $request->file('site_logo');
            $ext = $site_logo->extension();
            $site_logo_name = time() . uniqid() . '.' . $ext;
            $request->site_logo->move(public_path('project_assets/images'), $site_logo_name);
            BasicSettings::first()->update([
                'site_logo' =>  $site_logo_name,
            ]);
        }
        if ($request->hasFile('admin_logo')) {
            $file_path = public_path('project_assets/images/' . $existing_settings->admin_logo);
            if (file_exists($file_path) && $existing_settings->admin_logo != null) {
                unlink($file_path);
            }
            $admin_logo = $request->file('admin_logo');
            $ext = $admin_logo->extension();
            $admin_logo_name = time() . uniqid() . '.' . $ext;
            $request->admin_logo->move(public_path('project_assets/images'), $admin_logo_name);
            BasicSettings::first()->update([
                'admin_logo' =>  $admin_logo_name,
            ]);
        }

        BasicSettings::first()->update([
            'site_title' =>  $request->site_title,
            'phone' =>  $request->phone,
            'email' =>  $request->email,
            'twitter' =>  $request->twitter,
            'facebook' =>  $request->facebook,
            'instagram' =>  $request->instagram,
        ]);
        return redirect()->back();
    }
}
