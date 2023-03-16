<?php

use App\Models\BasicSettings;
use App\Models\UserAboutPage;
use App\Models\UserSubscribers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

function prx($value) {
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

function is_super_admin() {
    if (Session::has('super_admin_id') && Session::has('super_admin_username')) {
        return true;
    } else {
        return false;
    }
}

function logged_in() {
    if (Auth::check() && Auth::user()->role == '2') {
        return true;
    } else {
        return false;
    }
}

function is_admin() {
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
    if(isset($_COOKIE['subscriber_id'])) {
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
    if($subscribed) {
        return true;
    } else {
        return false;
    }
}

function setRandomId()
{
    setcookie('random_id', uniqid().time(), strtotime('+100 days'), '/');
}

function random_id()
{
    if(isset($_COOKIE['random_id'])) {
        return $_COOKIE['random_id'];
    } else {
        return null;
    }
}

function settings() {
    $settings = BasicSettings::first();
    return $settings;
}

function about_page() {
    $page = UserAboutPage::first();
    return $page;
}