<?php

use App\Models\BasicSettings;
use App\Models\User;
use App\Models\UserAboutPage;
use App\Models\UserSubscribers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

function prx($value)
{
    echo "<pre>";
    print_r($value);
    die;
}

function any_logged_in()
{
    if (Auth::check()) {
        return true;
    } else {
        return false;
    }
}

function is_super_admin()
{
    if (Session::has('super_admin_id') && Session::has('super_admin_username')) {
        return true;
    } else {
        return false;
    }
}

function logged_in()
{
    if (Auth::check() && Auth::user()->role == '2') {
        return true;
    } else {
        return false;
    }
}

function is_admin()
{
    if (Auth::check() && Auth::user()->role === '1') {
        return true;
    } else {
        return false;
    }
}

function is_subscriber()
{
    if (isset($_COOKIE['subscriber_id'])) {
        return true;
    } else {
        return false;
    }
}

function subscriber_id()
{
    if (isset($_COOKIE['subscriber_id'])) {
        return $_COOKIE['subscriber_id'];
    } else {
        return null;
    }
}

function set_subscriber_id($id)
{
    setcookie('subscriber_id', $id, strtotime('+100 days'), '/');
}

function is_user_subscriber($user_id)
{
    $subscribed = UserSubscribers::where(['user_id' => $user_id, 'subscriber_id' => subscriber_id()])->first();
    if ($subscribed) {
        return true;
    } else {
        return false;
    }
}

function setRandomId()
{
    setcookie('random_id', uniqid() . time(), strtotime('+100 days'), '/');
}

function random_id()
{
    if (isset($_COOKIE['random_id'])) {
        return $_COOKIE['random_id'];
    } else {
        return null;
    }
}

function settings()
{
    $settings = BasicSettings::first();
    return $settings;
}

function about_page()
{
    $page = UserAboutPage::first();
    return $page;
}

// function get_podcast_size($path) {
//     return file
// }

function get_memory_usage($id, $type)
{
    $total_size = 0;
    if ($type == "user") {
        $user = User::where(['id' => $id])->with(['podcasts', 'products'])->first();
        if ($user) {
            $podcasts = $user->podcasts;
            foreach ($podcasts as $podcast) {
                $file_path = storage_path('app/public/podcast/' . $podcast->id);
                if (file_exists($file_path)) {
                    $file_data = scandir($file_path);
                    foreach ($file_data as $file) {
                        if ($file === '.' || $file === '..') {
                            continue;
                        } else {
                            $path = $file_path . '/' . $file;
                            $total_size += filesize($path);
                        }
                    }
                }
            }
            $products = $user->products;
            foreach ($products as $product) {
                $file_path = storage_path('app/public/store/' . $product->id);
                if (file_exists($file_path)) {
                    $file_data = scandir($file_path);
                    foreach ($file_data as $file) {
                        if ($file === '.' || $file === '..') {
                            continue;
                        } else {
                            $path = $file_path . '/' . $file;
                            $total_size += filesize($path);
                        }
                    }
                }
            }
        }
    } elseif ($type == "admin") {
        $users = User::where(['id' => $id])->orWhere(['belongs_to' => $id])->with(['podcasts', 'products'])->get();
        foreach ($users as $user) {
            $podcasts = $user->podcasts;
            foreach ($podcasts as $podcast) {
                $file_path = storage_path('app/public/podcast/' . $podcast->id);
                if (file_exists($file_path)) {
                    $file_data = scandir($file_path);
                    foreach ($file_data as $file) {
                        if ($file === '.' || $file === '..') {
                            continue;
                        } else {
                            $path = $file_path . '/' . $file;
                            $total_size += filesize($path);
                        }
                    }
                }
            }

            $products = $user->products;
            foreach ($products as $product) {
                $file_path = storage_path('app/public/store/' . $product->id);
                if (file_exists($file_path)) {
                    $file_data = scandir($file_path);
                    foreach ($file_data as $file) {
                        if ($file === '.' || $file === '..') {
                            continue;
                        } else {
                            $path = $file_path . '/' . $file;
                            $total_size += filesize($path);
                        }
                    }
                }
            }
        }
    }
    return format_folder_size($total_size);
}

function get_memory_usage_bytes($id, $type)
{
    $total_size = 0;
    if ($type == "user") {
        $user = User::where(['id' => $id])->with(['podcasts', 'products'])->first();
        if ($user) {
            $podcasts = $user->podcasts;
            foreach ($podcasts as $podcast) {
                $file_path = storage_path('app/public/podcast/' . $podcast->id);
                if (file_exists($file_path)) {
                    $file_data = scandir($file_path);
                    foreach ($file_data as $file) {
                        if ($file === '.' || $file === '..') {
                            continue;
                        } else {
                            $path = $file_path . '/' . $file;
                            $total_size += filesize($path);
                        }
                    }
                }
            }
            $products = $user->products;
            foreach ($products as $product) {
                $file_path = storage_path('app/public/store/' . $product->id);
                if (file_exists($file_path)) {
                    $file_data = scandir($file_path);
                    foreach ($file_data as $file) {
                        if ($file === '.' || $file === '..') {
                            continue;
                        } else {
                            $path = $file_path . '/' . $file;
                            $total_size += filesize($path);
                        }
                    }
                }
            }
        }
    } elseif ($type == "admin") {
        $users = User::where(['id' => $id])->orWhere(['belongs_to' => $id])->with(['podcasts', 'products'])->get();
        foreach ($users as $user) {
            $podcasts = $user->podcasts;
            foreach ($podcasts as $podcast) {
                $file_path = storage_path('app/public/podcast/' . $podcast->id);
                if (file_exists($file_path)) {
                    $file_data = scandir($file_path);
                    foreach ($file_data as $file) {
                        if ($file === '.' || $file === '..') {
                            continue;
                        } else {
                            $path = $file_path . '/' . $file;
                            $total_size += filesize($path);
                        }
                    }
                }
            }
            $products = $user->products;
            foreach ($products as $product) {
                $file_path = storage_path('app/public/store/' . $product->id);
                if (file_exists($file_path)) {
                    $file_data = scandir($file_path);
                    foreach ($file_data as $file) {
                        if ($file === '.' || $file === '..') {
                            continue;
                        } else {
                            $path = $file_path . '/' . $file;
                            $total_size += filesize($path);
                        }
                    }
                }
            }
        }
    }
    return $total_size;
}

function format_folder_size($size)
{
    if ($size >= 1073741824) {
        $size = number_format($size / 1073741824, 2) . ' GB';
    } elseif ($size >= 1048576) {
        $size = number_format($size / 1048576, 2) . ' MB';
    } elseif ($size >= 1024) {
        $size = number_format($size / 1024, 2) . ' KB';
    } elseif ($size > 1) {
        $size = $size . ' Bytes';
    } elseif ($size == 1) {
        $size = $size . ' Byte';
    } else {
        $size = '0 Bytes';
    }
    return $size;
}

function get_remaining_memory($id)
{
    $total_size = 0;
    $user = User::where(['id' => $id])->with(['podcasts', 'products'])->first();
    if ($user && isset($user->podcasts)) {
        $podcasts = $user->podcasts;
        foreach ($podcasts as $podcast) {
            $file_path = storage_path('app/public/podcast/' . $podcast->id);
            if (file_exists($file_path)) {
                $file_data = scandir($file_path);
                foreach ($file_data as $file) {
                    if ($file === '.' || $file === '..') {
                        continue;
                    } else {
                        $path = $file_path . '/' . $file;
                        $total_size += filesize($path);
                    }
                }
            }
        }
        $products = $user->products;
        foreach ($products as $product) {
            $file_path = storage_path('app/public/store/' . $product->id);
            if (file_exists($file_path)) {
                $file_data = scandir($file_path);
                foreach ($file_data as $file) {
                    if ($file === '.' || $file === '..') {
                        continue;
                    } else {
                        $path = $file_path . '/' . $file;
                        $total_size += filesize($path);
                    }
                }
            }
        }
    }

    $allowed_memory = $user->memory_limit * 1073741824;
    $remaining_memory_bytes = $allowed_memory - $total_size;
    $remaining_mbs = 0;
    if ($remaining_memory_bytes > 0) {
        $remaining_mbs = round($remaining_memory_bytes / 1048576);
        $remaining_mbs -= 2;
    }
    return $remaining_mbs;
}

function paidSubscriptionAllowed($user_id)
{
    $user = User::with('SubscriptionInfo')->find($user_id);
    if ($user->stripe_connect_id != null && $user->completed_stripe_onboarding == 1 && $user->subscription_price_id != null && isset($user->SubscriptionInfo) && isset($user->SubscriptionInfo->price) && $user->SubscriptionInfo->price >= 5) {
        return true;
    } else {
        return false;
    }
}

function purchasedSubscription($user_id) {
    if(!is_subscriber()) {
        return false;
    }
    $subscriber_id = subscriber_id();
    $subscription = UserSubscribers::where(['subscriber_id' => $subscriber_id, 'user_id' => $user_id, 'paid' => 1])->first();
    if($subscription) {
        return true;
    } else {
        return false;
    }
}

function userStoreSaleAllowed($user_id)
{
    $user = User::find($user_id);
    if($user && $user->stripe_connect_id != null && $user->completed_stripe_onboarding == 1) {
        return true;
    } else {
        return false;
    }
}
