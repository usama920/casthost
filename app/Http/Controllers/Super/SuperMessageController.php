<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use App\Models\AdminMessagesReply;
use App\Models\BasicSettings;
use App\Models\Contact;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class SuperMessageController extends Controller
{
    public function UnreadMessages()
    {
        $messages = Contact::where(['read' => 0])->get();
        return view('super_admin.unread_messages', compact('messages'));
    }
    
    public function ReadMessages()
    {
        $messages = Contact::where(['read' => 1])->get();
        return view('super_admin.read_messages', compact('messages'));
    }

    public function MessageDetail($id)
    {
        $message = Contact::where(['id' => $id])->first();
        $message->read = 1;
        $message->update();
        $previous_messages = AdminMessagesReply::where(['message_id' => $id])->latest()->get();

        return view('super_admin.message_detail', compact('message', 'previous_messages'));
    }

    public function AdminMessageReply(Request $request)
    {
        $message = Contact::where(['id' => $request->id])->first();
        $mail_username = env('MAIL_USERNAME');
        if ($message) {
            $reply = new AdminMessagesReply();
            $reply->message_id = $request->id;
            $reply->reply = $request->reply;
            $reply->save();
        }

        $basic_settings = BasicSettings::first();
        $data = ['logo' => $basic_settings->site_logo, 'site_name' => $basic_settings->site_title, 'subject' => $message->subject, 'name' => $message->name, 'reply' => $request->reply, 'site_title' => $basic_settings->site_title];
        $user['site_title'] = $basic_settings->site_title;
        $user['to'] = $message->email;

        try {
            Mail::send('mails.admin_message_response', $data, function ($message) use ($user, $mail_username) {
                $message->from($mail_username, $user['site_title']);
                $message->sender($mail_username, $user['site_title']);
                $message->to($user['to']);
                $message->subject('Message Response');
                $message->priority(3);
            });
        } catch (Exception $e) {
        }

        Session::flash('message', 'Message sent successfully!');
        Session::flash('alert-type', 'success');
        return redirect('/superAdmin/messages/read');
    }
}
