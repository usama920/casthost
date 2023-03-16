<?php

namespace App\Console\Commands;

use App\Models\BasicSettings;
use App\Models\Podcast;
use App\Models\Subscribers;
use App\Models\User;
use App\Models\UserSubscribers;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SubscribersMail extends Command
{
    protected $signature = 'custom:subscribers_mail';
    protected $description = 'Cron Job to send mail to subscribers about podcast.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        Podcast::where(['subscribers_mail' => 0])->where('premiere_datetime', '<=', date('y-m-d H:i:s'))->update([
            'subscribers_mail' => 1
        ]);
        // $podcasts = Podcast::where(['subscribers_mail' => 0])->where('premiere_datetime', '<=', date('y-m-d H:i:s'))->get();
        // $mail_username = env('MAIL_USERNAME');
        // foreach ($podcasts as $podcast) {
        //     $basic_settings = BasicSettings::first();
        //     $user = User::where(['id' => $podcast->user_id])->first();
        //     if ($user) {
        //         $data = ['logo' => $basic_settings->site_logo, 'site_name' => $basic_settings->site_title, 'username' => $user->username, 'title' => $podcast->title, 'name' => $user->name, 'site_title' => $basic_settings->site_title];
        //         $user['site_title'] = $basic_settings->site_title;
        //         $user_subscribers = UserSubscribers::where(['user_id' => $user->id])->get();
        //         $all_subscribers = [];
        //         foreach ($user_subscribers as $subscriber) {
        //             $subscriber = Subscribers::where(['id' => $subscriber->subscriber_id])->first();
        //             if ($subscriber) {
        //                 array_push($all_subscribers, $subscriber->email);
        //             }
        //         }

        //         prx($all_subscribers);

        //         // try {
        //             Mail::send('mails.subscribers_mail', $data, function ($message) use ($user, $all_subscribers, $mail_username) {
        //                 $message->from($mail_username, $user['site_title']);
        //                 $message->sender($mail_username, $user['site_title']);
        //                 $message->bcc($all_subscribers);
        //                 $message->subject('Podcast Notification');
        //                 $message->priority(3);
        //             });
        //         // } catch (Exception $e) {
        //         // }
        //     }
        //     $podcast->subscribers_mail = 1;
        //     $podcast->save();
        // }
    }
}
