<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\BasicSettings;
use App\Models\User;
use App\Models\UserContact;
use App\Models\UserMessagesReply;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class UserMessagesController extends Controller
{
    public function UnreadMessages()
    {
        $messages = UserContact::where(['user_id' => Auth::user()->id, 'read' => 0])->latest()->get();
        return view('dashboard.user_unread_messages', compact('messages'));
    }

    public function ReadMessages()
    {
        $messages = UserContact::where(['user_id' => Auth::user()->id, 'read' => 1])->latest()->get();
        return view('dashboard.user_read_messages', compact('messages'));
    }

    public function MessageDetail($id)
    {
        $message = UserContact::where(['user_id' => Auth::user()->id, 'id' => $id])->latest()->first();
        $message->read = 1;
        $message->update();
        $previous_messages = UserMessagesReply::where(['message_id' => $id])->latest()->get();
        return view('dashboard.user_message_detail', compact('message', 'previous_messages'));
    }

    public function MessageReply(Request $request)
    {
        $message = UserContact::where(['id' => $request->id])->first();
        $mail_username = env('MAIL_USERNAME');
        if($message) {
            $reply = new UserMessagesReply();
            $reply->message_id = $request->id;
            $reply->user_id = Auth::user()->id;
            $reply->reply = $request->reply;
            $reply->save();
        }

        $user = User::where(['id' => $message->user_id])->first();
        $basic_settings = BasicSettings::first();
        $data = ['logo' => $basic_settings->site_logo, 'site_name' => $basic_settings->site_title, 'subject' => $message->subject, 'name' => $message->name, 'reply' => $request->reply, 'user_name' => $user->name, 'user_username' => $user->username,'site_title' => $basic_settings->site_title];
        $user['site_title'] = $basic_settings->site_title;
        $user['to'] = $message->email;

        try {
            Mail::send('mails.user_message_response', $data, function ($message) use ($user, $mail_username) {
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
        return redirect('/users/messages/read');
    }
}
