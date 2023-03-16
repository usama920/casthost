<?php

namespace App\Http\Controllers;

use App\Models\AboutPage;
use App\Models\BasicSettings;
use App\Models\Downloads;
use App\Models\HomePage;
use App\Models\Podcast;
use App\Models\Subscribers;
use App\Models\User;
use App\Models\UserAboutPage;
use App\Models\UserContact;
use App\Models\UserContactPage;
use App\Models\UserHomePage;
use App\Models\UserSubscribers;
use App\Models\Views;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function Home()
    {
        Artisan::call('storage:link');
        // die;
        $podcasts = Podcast::where([
            'status'   =>  1,
            'admin_status' => 1
        ])->where('premiere_datetime', '<', date('Y-m-d H:i:s'))->with(['category:id,title', 'user:id,name,username'])->latest()->paginate(18);
        $page = HomePage::first();
        return view('front.home', compact('podcasts', 'page'));
    }

    public function UserHomePage($username)
    {
        $user = User::where(['username' => $username])->first();
        if ($user) {
            $podcasts = Podcast::where([
                'status'   =>  1,
                'admin_status' => 1
            ])->where('premiere_datetime', '<', date('Y-m-d H:i:s'))->with(['category:id,title', 'user:id,name,username', 'views', 'downloads'])->whereRelation('user', 'username', '=', $username)->latest()->paginate(18);
            $page = UserHomePage::where(['user_id' => $user->id])->first();
            return view('front.user_home', compact('podcasts', 'page', 'user'));
        } else {
            return redirect('/');
        }
    }

    public function Category($id)
    {
        $podcasts = Podcast::where([
            'status'   =>  1,
            'admin_status' => 1,
            'category_id' => $id
        ])->where('premiere_datetime', '<', date('Y-m-d H:i:s'))->with(['category:id,title', 'user:id,name'])->latest()->paginate(18);
        $page = HomePage::first();
        return view('front.home', compact('podcasts', 'page'));
    }

    public function UserCategoryPage($username, $category_id)
    {
        $user = User::where(['username' => $username])->first();
        if ($user) {
            $podcasts = Podcast::where([
                'status'   =>  1,
                'admin_status' => 1
            ])->where('premiere_datetime', '<', date('Y-m-d H:i:s'))->with(['category:id,title', 'user:id,name,username'])->whereRelation('user', 'username', '=', $username)->whereRelation('category', 'id', '=', $category_id)->latest()->paginate(18);
            $page = UserHomePage::where(['user_id' => $user->id])->first();
            return view('front.user_home', compact('podcasts', 'page', 'user'));
        } else {
            return redirect('/');
        }
    }

    public function User($id)
    {
        $podcasts = Podcast::where([
            'status'   =>  1,
            'admin_status' => 1,
            'user_id' => $id
        ])->where('premiere_datetime', '<', date('Y-m-d H:i:s'))->with(['category:id,title', 'user:id,name'])->latest()->get();
        $page = HomePage::first();
        return view('front.home', compact('podcasts', 'page'));
    }

    public function PodcastDownload($id)
    {
        $podcast = Podcast::find($id);
        if ($podcast) {
            $download = new Downloads();
            $download->podcast_id = $id;
            if (logged_in()) {
                if ($podcast->id == Auth::user()->id) {
                    $headers = [
                        'Content-Description' => 'File Download',
                        'Content-Type' => 'video/mp4',
                    ];
                    $download_name = $podcast->title . '.' . $podcast->podcast_ext;
                    return response()->download(public_path('storage/podcast/' . $id . '/' . $podcast->title),  $download_name, $headers);
                }
                $download->user_id = Auth::user()->id;
                $download->user_type = 'user';
            } else if (is_subscriber()) {
                $download->user_id = subscriber_id();
                $download->user_type = 'subsciber';
            } else if (isset($_COOKIE['random_id'])) {
                $download->user_id = random_id();
                $download->user_type = 'random';
            } else {
                setRandomId();
                $download->user_id = random_id();
                $download->user_type = 'random';
            }
            $download->save();
            $headers = [
                'Content-Description' => 'File Download',
                'Content-Type' => 'video/mp4',
            ];
            $download_name = $podcast->title . '.' . $podcast->podcast_ext;
            return response()->download(public_path('storage/podcast/' . $id . '/' . $podcast->podcast),  $download_name, $headers);
        }
        return redirect()->back();
    }

    public function About()
    {
        $page = AboutPage::first();
        return view('front.about', compact('page'));
    }

    public function UserAboutPage($username)
    {
        $user = User::where(['username' => $username])->first();
        if ($user) {
            $page = UserAboutPage::where(['user_id' => $user->id])->first();
            return view('front.user_about', compact('page', 'user'));
        } else {
            return redirect('/');
        }
    }

    public function UserContactPage($username)
    {
        $user = User::where(['username' => $username])->first();
        if ($user) {
            $page = UserContactPage::where(['user_id' => $user->id])->first();
            return view('front.user_contact', compact('page', 'user'));
        } else {
            return redirect('/');
        }
    }

    public function ContactUserSave(Request $request)
    {
        $request->validate([
            'user_id'  =>  'required',
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

        // try {
        Mail::send('mails.user_message_notification', $data, function ($message) use ($user, $mail_username) {
            $message->from($mail_username, $user['site_title']);
            $message->sender($mail_username, $user['site_title']);
            $message->to($user['to']);
            $message->subject('Message Notification.');
            $message->priority(3);
        });
        // } catch (Exception $e) {
        // }
        UserContact::create([
            'user_id'  =>  $request->user_id,
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

    public function PodcastView(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'duration' => 'required'
        ]);
        $podcast = Podcast::find($request->id);
        if ($podcast) {
            if (logged_in()) {
                if ($podcast->user_id == Auth::user()->id) {
                    return response()->json(['status' => 'My Own Podcast.']);
                }
                $existing_views = Views::where([
                    'podcast_id' => $request->id,
                    'user_id' => Auth::user()->id,
                    'user_type' => 'user'
                ])->latest()->first();
                if ($existing_views) {
                    $previos_view_time = strtotime(date($existing_views->created_at));
                    $time_now = strtotime(date('Y-m-d H:i:s'));
                    if (($previos_view_time + $request->duration) > $time_now) {
                        return response()->json(['status' => 'Already View Added.']);
                    } else {
                        $view = new Views();
                        $view->podcast_id = $request->id;
                        $view->user_id = Auth::user()->id;
                        $view->user_type = 'user';
                        $view->save();
                        return response()->json(['status' => 'success']);
                    }
                } else {
                    $view = new Views();
                    $view->podcast_id = $request->id;
                    $view->user_id = Auth::user()->id;
                    $view->user_type = 'user';
                    $view->save();
                    return response()->json(['status' => 'success']);
                }
            } else if (is_subscriber()) {
                $existing_views = Views::where([
                    'podcast_id' => $request->id,
                    'user_id' => Auth::user()->id,
                    'user_type' => 'subscriber',
                ])->latest()->first();
                if ($existing_views) {
                    $previos_view_time = strtotime(date($existing_views->created_at));
                    $time_now = strtotime(date('Y-m-d H:i:s'));
                    if (($previos_view_time + $request->duration) > $time_now) {
                        return response()->json(['status' => 'Already View Added.']);
                    } else {
                        $view = new Views();
                        $view->podcast_id = $request->id;
                        $view->user_id = subscriber_id();
                        $view->user_type = 'subscriber';
                        $view->save();
                        return response()->json(['status' => 'success']);
                    }
                } else {
                    $view = new Views();
                    $view->podcast_id = $request->id;
                    $view->user_id = subscriber_id();
                    $view->user_type = 'subscriber';
                    $view->save();
                    return response()->json(['status' => 'success']);
                }
            } else if (isset($_COOKIE['random_id'])) {
                $existing_views = Views::where([
                    'podcast_id' => $request->id,
                    'user_id' => random_id(),
                    'user_type' => 'random',
                ])->latest()->first();
                if ($existing_views) {
                    $previos_view_time = strtotime(date($existing_views->created_at));
                    $time_now = strtotime(date('Y-m-d H:i:s'));
                    if (($previos_view_time + $request->duration) > $time_now) {
                        return response()->json(['status' => 'Already View Added.']);
                    } else {
                        $view = new Views();
                        $view->podcast_id = $request->id;
                        $view->user_id = random_id();
                        $view->user_type = 'random';
                        $view->save();
                        return response()->json(['status' => 'success']);
                    }
                } else {
                    $view = new Views();
                    $view->podcast_id = $request->id;
                    $view->user_id = random_id();
                    $view->user_type = 'random';
                    $view->save();
                    return response()->json(['status' => 'success']);
                }
            } else {
                setRandomId();
                $view = new Views();
                $view->podcast_id = $request->id;
                $view->user_id = random_id();
                $view->user_type = 'random';
                $view->save();
                return response()->json(['status' => 'success']);
            }
        }
    }

    public function SubscriberVerifyEmail(Request $request)
    {
        $request->validate([
            'email' => 'required'
        ]);
        $code = rand(100000, 999999);
        $subscriber = Subscribers::where(['email' => $request->email])->first();
        if($subscriber) {
            $subscriber->code = $code;
        } else {
            $subscriber = new Subscribers();
            $subscriber->email = $request->email;
            $subscriber->code = $code;
            $subscriber->status = 0;
            $subscriber->admin_status = 0;
        }

        $mail_username = env('MAIL_USERNAME');
        $basic_settings = BasicSettings::first();
        $data = ['logo' => $basic_settings->site_logo, 'site_name' => $basic_settings->site_title, 'code' => $code, 'site_title' => $basic_settings->site_title];
        $users['site_title'] = $basic_settings->site_title;
        $users['to'] = $request->email;

        // try {
            Mail::send('mails.subscriber_verification', $data, function ($message) use ($users, $mail_username) {
                $message->from($mail_username, $users['site_title']);
                $message->sender($mail_username, $users['site_title']);
                $message->to($users['to']);
                $message->subject('Subscription Verification');
                $message->priority(3);
            });
        // } catch (Exception $e) {
        // }

        $subscriber->save();
        return response()->json(['status' => 'success']);
    }

    public function UnsubscriberUser($user_id)
    {
        $subscriber_id = subscriber_id();
        if($subscriber_id != null) {
            UserSubscribers::where(['user_id' => $user_id, 'subscriber_id' => $subscriber_id])->delete();
            Session::flash('message', 'User unsubscribed!');
            Session::flash('alert-type', 'success');
        }
        return redirect()->back();
    }

    public function SubscriberUser($user_id)
    {
        $subscriber_id = subscriber_id();
        
        if ($subscriber_id != null) {

            $existing_user_subscriber = UserSubscribers::where(['user_id' => $user_id, 'subscriber_id' => $subscriber_id])->first();
            if ($existing_user_subscriber) {
                Session::flash('message', 'Already subscribed!');
                Session::flash('alert-type', 'success');
                return redirect()->back();
            }

            $user_subscriber = new UserSubscribers();
            $user_subscriber->subscriber_id = $subscriber_id;
            $user_subscriber->user_id = $user_id;
            $user_subscriber->status = 1;
            $user_subscriber->save();

            Session::flash('message', 'Subscribed successfully!');
            Session::flash('alert-type', 'success');
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }

    public function SubscriberVerify(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'code' => 'required',
        ]);
        $subscriber = Subscribers::where(['email' => $request->email, 'code' => $request->code])->first();
        if ($subscriber) {
            $subscriber->status = 1;
            $subscriber->admin_status = 1;
            $subscriber->save();
            
            set_subscriber_id($subscriber->id);

            if (random_id() != null) {
                $random_id = random_id();
                $views = Views::where(['user_id' => $random_id, 'user_type' => 'random'])->get();
                foreach($views as $view) {
                    $view->user_id = $subscriber->id;
                    $view->user_type = 'subscriber';
                    $view->save();
                }
                $downloads = Downloads::where(['user_id' => $random_id, 'user_type' => 'random'])->get();
                foreach ($downloads as $download) {
                    $download->user_id = $subscriber->id;
                    $download->user_type = 'subscriber';
                    $download->save();
                }
            }
            Session::flash('message', 'Logged in as subscriber!');
            Session::flash('alert-type', 'success');
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Code does not match.']);
        }
    }

    public function SubscriberLogout()
    {
        setcookie('subscriber_id', 0, time() - 0, '/');
        Session::flash('message', 'Logged out successfully!');
        Session::flash('alert-type', 'success');
        return redirect()->back();
    }
    
    public function SubscriberVerifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'code' => 'required',
            'user_id' => 'required'
        ]);
        $subscriber = Subscribers::where(['email' => $request->email, 'code' => $request->code])->first();
        if ($subscriber) {
            $subscriber->status = 1;
            $subscriber->admin_status = 1;
            $subscriber->save();
            
            set_subscriber_id($subscriber->id);

            $existing_user_subscriber = UserSubscribers::where(['user_id' => $request->user_id, 'subscriber_id' => $subscriber->id])->first();
            if($existing_user_subscriber) {
                if (random_id() != null) {
                    $random_id = random_id();
                    $views = Views::where(['user_id' => $random_id, 'user_type' => 'random'])->get();
                    foreach($views as $view) {
                        $view->user_id = $subscriber->id;
                        $view->user_type = 'subscriber';
                        $view->save();
                    }
                    $downloads = Downloads::where(['user_id' => $random_id, 'user_type' => 'random'])->get();
                    foreach ($downloads as $download) {
                        $download->user_id = $subscriber->id;
                        $download->user_type = 'subscriber';
                        $download->save();
                    }
                }

                Session::flash('message', 'Already subscribed!');
                Session::flash('alert-type', 'success');
                return response()->json(['status' => 'success']);
            }

            $user_subscriber = new UserSubscribers();
            $user_subscriber->subscriber_id = $subscriber->id;
            $user_subscriber->user_id = $request->user_id;
            $user_subscriber->status = 1;
            $user_subscriber->save();

            if (random_id() != null) {
                $random_id = random_id();
                $views = Views::where(['user_id' => $random_id, 'user_type' => 'random'])->get();
                foreach ($views as $view) {
                    $view->user_id = $user_subscriber->id;
                    $view->user_type = 'subscriber';
                    $view->save();
                }
                $downloads = Downloads::where(['user_id' => $random_id, 'user_type' => 'random'])->get();
                foreach ($downloads as $download) {
                    $download->user_id = $user_subscriber->id;
                    $download->user_type = 'subscriber';
                    $download->save();
                }
            }

            Session::flash('message', 'Successfully subscribed!');
            Session::flash('alert-type', 'success');
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Code does not match.']);
        }
    }

    public function SendForgotPasswordCode(Request $request)
    {
        $request->validate([
            'email' => 'required'
        ]);
        $user = User::where(['email' => $request->email, 'status' => 1])->first();
        if ($user) {
            $code = rand(100000, 999999);
            $user->forgot_password_code = $code;
            $user->save();
            $mail_username = env('MAIL_USERNAME');
            $basic_settings = BasicSettings::first();
            $data = ['logo' => $basic_settings->site_logo, 'site_name' => $basic_settings->site_title, 'name' => $user->name, 'code' => $code, 'site_title' => $basic_settings->site_title];
            $users['site_title'] = $basic_settings->site_title;
            $users['to'] = $user->email;

            try {
                Mail::send('mails.forgot_password', $data, function ($message) use ($users, $mail_username) {
                    $message->from($mail_username, $users['site_title']);
                    $message->sender($mail_username, $users['site_title']);
                    $message->to($users['to']);
                    $message->subject('Forgot Password');
                    $message->priority(3);
                });
            } catch (Exception $e) {
            }

            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Please provide valid email.']);
        }
    }

    public function ForgotPasswordVerifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'code' => 'required'
        ]);
        $user = User::where(['email' => $request->email, 'forgot_password_code' => $request->code])->first();
        if ($user) {
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Code does not match.']);
        }
    }

    public function ForgotPasswordSave(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'code' => 'required',
            'password' => 'required'
        ]);
        $password = Hash::make($request->password);
        // prx($password);
        $user = User::where(['email' => $request->email, 'forgot_password_code' => $request->code])->first();
        if ($user) {
            User::where(['email' => $request->email, 'forgot_password_code' => $request->code])->update([
                'password' => $password
            ]);
            Session::flash('message', 'Please login to continue!');
            Session::flash('alert-type', 'success');
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong.']);
        }
    }

    public function UserRSS($username)
    {
        $basic_settings = BasicSettings::first();
        $link = url('/'.$username);
        // $user = User::where(['username' => $username])->first();
        // $feed = '<?xml version="1.0" encoding="UTF-8"';
        // $feed .= '<rss xmlns:atom="http://www.w3.org/2005/Atom" version="2.0">';
        // $feed .= '<channel>';
        // $feed .= "<title>$basic_settings->site_title</title>";
        // $feed .= "<link>$link</link>";
        // $feed .= "<description>$basic_settings->site_title RSS Feed</description>";
        $podcasts = Podcast::where([
            'status'   =>  1,
            'admin_status' => 1
        ])->where('premiere_datetime', '<', date('Y-m-d H:i:s'))->with(['category:id,title', 'user:id,name,username', 'views', 'downloads'])->whereRelation('user', 'username', '=', $username)->latest()->paginate(18);
        return response()->view('rss', [
            'link' => $link,
            'basic_settings' => $basic_settings,
            'podcasts' => $podcasts
        ])->header('Content-Type', 'text/xml');
        // prx($feed);
        // if ($user) {
        //     $page = UserHomePage::where(['user_id' => $user->id])->first();
        //     return view('front.user_home', compact('podcasts', 'page', 'user'));
        // } else {
        //     return redirect('/');
        // }   
    }
}
