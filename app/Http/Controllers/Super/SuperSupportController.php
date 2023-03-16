<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use App\Models\BasicSettings;
use App\Models\SupportMessages;
use App\Models\SupportMessagesReply;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class SuperSupportController extends Controller
{
    public function SupportUnread()
    {
        $supportMessages = SupportMessages::where('read', '!=', 1)->with('admin')->get();
        return view('super_admin.support_unread_messages', compact('supportMessages'));
    }

    public function SupportRead()
    {
        $supportMessages = SupportMessages::where(['read' => 1])->with('admin')->get();
        return view('super_admin.support_read_messages', compact('supportMessages'));
    }

    public function SupportDetail($id)
    {
        $message = SupportMessages::where(['id' => $id])->first();
        $message->read = 1;
        $message->update();
        $previous_messages = SupportMessagesReply::where(['support_message_id' => $id])->latest()->get();
        return view('super_admin.support_message_detail', compact('message', 'previous_messages'));
    }

    public function SupportReply(Request $request)
    {
        $message = SupportMessages::where(['id' => $request->id])->with('admin')->first();
        // prx($message->admin->email);
        $mail_username = env('MAIL_USERNAME');
        if ($message) {
            $reply = new SupportMessagesReply();
            $reply->support_message_id = $request->id;
            $reply->reply = $request->reply;
            $reply->reply_from = 'superAdmin';
            $reply->save();
        }

        try {
        $basic_settings = BasicSettings::first();
        $data = ['logo' => $basic_settings->site_logo, 'site_name' => $basic_settings->site_title, 'subject' => $message->subject];
        $user['site_title'] = $basic_settings->site_title;
        $user['to'] = $message->admin->email;

            Mail::send('mails.superadmin_support_message_response', $data, function ($message) use ($user, $mail_username) {
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
        return redirect('/superAdmin/support/messages/read');
    }
}
