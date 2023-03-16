<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BasicSettings;
use App\Models\SupportMessages;
use App\Models\SupportMessagesReply;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class SupportController extends Controller
{
    public function Support()
    {
        $supportMessages = SupportMessages::where(['admin_id' => Auth::user()->id])->get();
        return view('admin.support', compact('supportMessages'));
    }

    public function SupportDetail($id)
    {
        $message = SupportMessages::where(['id' => $id])->first();
        $message->read = 1;
        $message->update();
        $previous_messages = SupportMessagesReply::where(['support_message_id' => $id])->latest()->get();
        return view('admin.support_detail', compact('message', 'previous_messages'));
    }

    public function NewSupport(Request $request)
    {
        // prx($request->post());
        $request->validate([
            'message' => 'required',
            'subject' => 'required',
        ]);
        
        $support = new SupportMessages();
        $support->admin_id = Auth::user()->id;
        $support->subject = $request->subject;
        $support->message = $request->message;
        $support->read = 0;
        $support->save();

        try {
            $mail_username = env('MAIL_USERNAME');
            $basic_settings = BasicSettings::first();
            $data = ['logo' => $basic_settings->site_logo, 'site_name' => $basic_settings->site_title, 'subject' => $request->subject];
            $user['site_title'] = $basic_settings->site_title;
            $user['to'] = $basic_settings->email;

            Mail::send('mails.admin_support_message_response', $data, function ($message) use ($user, $mail_username) {
                $message->from($mail_username, $user['site_title']);
                $message->sender($mail_username, $user['site_title']);
                $message->to($user['to']);
                $message->subject('Support Response');
                $message->priority(3);
            });
        } catch (Exception $e) {
        }

        Session::flash('message', 'Message sent successfully!');
        Session::flash('alert-type', 'success');
        return redirect('/admin/support');
    }

    public function SupportReply(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'reply' => 'required'
        ]);
        $message = SupportMessages::where(['id' => $request->id])->first();
        $mail_username = env('MAIL_USERNAME');
        if ($message) {
            $reply = new SupportMessagesReply();
            $reply->support_message_id = $request->id;
            $reply->reply = $request->reply;
            $reply->reply_from = 'admin';
            $reply->save();
        }

        try {
            $basic_settings = BasicSettings::first();
            $data = ['logo' => $basic_settings->site_logo, 'site_name' => $basic_settings->site_title, 'subject' => $message->subject];
            $user['site_title'] = $basic_settings->site_title;
            $user['to'] = $basic_settings->email;

            Mail::send('mails.admin_support_message_response', $data, function ($message) use ($user, $mail_username) {
                $message->from($mail_username, $user['site_title']);
                $message->sender($mail_username, $user['site_title']);
                $message->to($user['to']);
                $message->subject('Support Response');
                $message->priority(3);
            });
        } catch (Exception $e) {
        }

        Session::flash('message', 'Message sent successfully!');
        Session::flash('alert-type', 'success');
        return redirect('/admin/support');
    }
}
