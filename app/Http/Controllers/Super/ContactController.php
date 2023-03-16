<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use App\Models\BasicSettings;
use App\Models\Contact;
use App\Models\ContactPage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class ContactController extends Controller
{
    public function Contact()
    {
        $page = ContactPage::first();
        return view('front.contact', compact('page'));
    }

    public function SaveContact(Request $request)
    {
        $request->validate([
            'name'  =>  'required',
            'email'  =>  'required',
            'message'  =>  'required',
            'subject'  =>  'required'
        ]);
        $basic_settings = BasicSettings::first();
        $data = ['logo' => $basic_settings->site_logo, 'site_name' => $basic_settings->site_title, 'name' => $request->name, 'site_title' => $basic_settings->site_title];
        $user['site_title'] = $basic_settings->site_title;
        $user['to'] = $basic_settings->email;
        $mail_username = env('MAIL_USERNAME');

        try {
            Mail::send('mails.admin_message_notification', $data, function ($message) use ($user, $mail_username) {
                $message->from($mail_username, $user['site_title']);
                $message->sender($mail_username, $user['site_title']);
                $message->to($user['to']);
                $message->subject('Message Notification.');
                $message->priority(3);
            });
        } catch (Exception $e) {
        }
        Contact::create([
            'name'  =>  $request->name,
            'email'  =>  $request->email,
            'message'  =>  $request->message,
            'subject'  =>  $request->subject,
            'read'  =>  0,
        ]);
        Session::flash('message', 'Message sent successfully.');
        Session::flash('alert-type', 'success');
        return redirect()->back();
    }
}
