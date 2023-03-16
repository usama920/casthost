<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminUsersPageController;

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminDefaultPageController;
use App\Http\Controllers\Admin\AdminPodcastController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Super\ContactController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\SupportController;
use App\Http\Controllers\Admin\UserController;

use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\PodcastController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\UserMessagesController;
use App\Http\Controllers\User\UserPageController;

use App\Http\Controllers\Super\SuperMessageController;
use App\Http\Controllers\Super\BasicSettingsController;
use App\Http\Controllers\Super\SuperDashboardController;
use App\Http\Controllers\Super\SuperPageController;
use App\Http\Controllers\Super\SuperSupportController;

use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'Home']);
Route::get('/login', [LoginController::class, 'Login'])->name('login');
Route::get('/subscriber/logout', [HomeController::class, 'SubscriberLogout']);
Route::post('/subscriber/verify', [HomeController::class, 'SubscriberVerify']);
Route::post('/subscriber/verify/email', [HomeController::class, 'SubscriberVerifyEmail']);
Route::post('/subscriber/verify/code', [HomeController::class, 'SubscriberVerifyCode']);
Route::get('/unsubscribe/{user_id}', [HomeController::class, 'UnsubscriberUser']);
Route::get('/subscribe/{user_id}', [HomeController::class, 'SubscriberUser']);
Route::post('/forgotpassword/code', [HomeController::class, 'SendForgotPasswordCode']);
Route::post('/forgotpassword/verify/code', [HomeController::class, 'ForgotPasswordVerifyCode']);
Route::post('/forgotpassword/save', [HomeController::class, 'ForgotPasswordSave']);

Route::post('/contact/user', [HomeController::class, 'ContactUserSave']);
Route::get('/podcast/category/{id}', [HomeController::class, 'Category']);
Route::get('/podcast/user/{id}', [HomeController::class, 'User']);
Route::get('/podcast/download/{id}', [HomeController::class, 'PodcastDownload']);
Route::post('/podcast/view', [HomeController::class, 'PodcastView']);

Route::post('/login', [LoginController::class, 'LoginCheck']);
Route::get('/logout', [LoginController::class, 'Logout']);
Route::post('/register', [LoginController::class, 'RegisterSave']);
Route::get('/contact', [ContactController::class, 'Contact']);
Route::post('/contact', [ContactController::class, 'SaveContact']);

Route::get('/about', [HomeController::class, 'About']);

Route::group(['prefix' => 'admin', 'middleware' => 'admin_auth'], function () {
    Route::get('/', [AdminDashboardController::class, 'Dashboard']);
    Route::get('/dashboard', [AdminDashboardController::class, 'Dashboard']);
    Route::post('/user/add', [UserController::class, 'AddUser']);
    Route::post('/user/add/verify/email', [UserController::class, 'AddUserVerifyDuplication']);
    Route::get('/users', [UserController::class, 'Users']);
    Route::get('/user/detail/{id}', [UserController::class, 'UserDetail']);
    Route::get('/users/search', [UserController::class, 'SearchUser']);
    Route::get('/user/inactive/{id}', [UserController::class, 'InactiveUser']);
    Route::get('/user/active/{id}', [UserController::class, 'ActiveUser']);

    Route::get('/users/podcasts', [AdminPodcastController::class, 'UsersPodcasts']);
    Route::get('/users/podcasts/search', [AdminPodcastController::class, 'UsersPodcastsSearch']);
    Route::get('/user/podcast/detail/{id}', [AdminPodcastController::class, 'PodcastDetail']);

    Route::get('/user/podcast/inactive/{id}', [UserController::class, 'InactivePodcast']);
    Route::get('/user/podcast/active/{id}', [UserController::class, 'ActivePodcast']);

    Route::get('/support', [SupportController::class, 'Support']);
    Route::post('/support/add', [SupportController::class, 'NewSupport']);
    Route::get('/support/detail/{id}', [SupportController::class, 'SupportDetail']);
    Route::post('/support/reply', [SupportController::class, 'SupportReply']);

    Route::get('/categories', [CategoriesController::class, 'Categories']);
    Route::post('/category/add', [CategoriesController::class, 'AddCategory']);
    Route::get('/category/inactive/{id}', [CategoriesController::class, 'InactiveCategory']);
    Route::get('/category/active/{id}', [CategoriesController::class, 'ActiveCategory']);
    Route::post('/category/edit', [CategoriesController::class, 'EditCategory']);
    Route::get('/category/delete/{id}', [CategoriesController::class, 'DeleteCategory']);

    Route::get('/default/pages/home', [AdminDefaultPageController::class, 'HomePage']);
    Route::post('/default/pages/home', [AdminDefaultPageController::class, 'HomePageSave']);

    Route::get('/default/pages/contact', [AdminDefaultPageController::class, 'ContactPage']);
    Route::post('/default/pages/contact', [AdminDefaultPageController::class, 'ContactPageSave']);

    Route::get('/default/pages/about', [AdminDefaultPageController::class, 'AboutPage']);
    Route::post('/default/pages/about', [AdminDefaultPageController::class, 'AboutPageSave']);

});

Route::group(['prefix' => 'users', 'middleware' => 'user_auth'], function () {
    Route::get('/dashboard', [DashboardController::class, 'Dashboard']);
    Route::post('/change/password', [DashboardController::class, 'UserChangePassword']);


    Route::get('/podcast/new', [PodcastController::class, 'NewPodcast']);
    Route::get('/podcast/new/revert/{id}', [PodcastController::class, 'RevertPodcast']);
    Route::post('/podcast/new/upload/{id}', [PodcastController::class, 'UploadPodcast']);
    Route::post('/podcast/save', [PodcastController::class, 'SavePodcast']);

    Route::get('/podcasts', [PodcastController::class, 'UserPodcasts']);
    Route::get('/podcast/inactive/{id}', [PodcastController::class, 'InactivePodcast']);
    Route::get('/podcast/active/{id}', [PodcastController::class, 'ActivePodcast']);
    Route::get('/podcast/detail/{id}', [PodcastController::class, 'PodcastDetail']);
    Route::post('/podcast/update', [PodcastController::class, 'UpdatePodcast']);
    Route::get('/podcast/delete/{id}', [PodcastController::class, 'DeletePodcast']);

    Route::get('/profile', [ProfileController::class, 'Profile']);
    Route::post('/profile', [ProfileController::class, 'SaveProfile']);

    Route::get('/pages/home', [UserPageController::class, 'HomePage']);
    Route::post('/pages/home', [UserPageController::class, 'HomePageSave']);

    Route::get('/pages/contact', [UserPageController::class, 'ContactPage']);
    Route::post('/pages/contact', [UserPageController::class, 'ContactPageSave']);

    Route::get('/pages/about', [UserPageController::class, 'AboutPage']);
    Route::post('/pages/about', [UserPageController::class, 'AboutPageSave']);

    Route::get('/messages/unread', [UserMessagesController::class, 'UnreadMessages']);
    Route::get('/messages/read', [UserMessagesController::class, 'ReadMessages']);
    Route::get('/message/detail/{id}', [UserMessagesController::class, 'MessageDetail']);
    Route::post('/message/reply', [UserMessagesController::class, 'MessageReply']);
});
 
Route::group(['prefix' => 'superAdmin'], function () {
    Route::get('/', [SuperDashboardController::class, 'Dashboard']);
    Route::get('/login', [SuperDashboardController::class, 'Login']);
    Route::post('/login', [SuperDashboardController::class, 'TryLogin']);

    Route::get('/admin/login/{id}', [SuperDashboardController::class, 'AdminLogin']);
    Route::post('/admin/add', [SuperDashboardController::class, 'AdminAdd']);
    Route::post('/admin/add/verify/email', [SuperDashboardController::class, 'AddAdminVerifyDuplication']);
    Route::get('/admins/search', [SuperDashboardController::class, 'SearchAdmin']);
    Route::get('/admin/inactive/{id}', [SuperDashboardController::class, 'InactiveAdmin']);
    Route::get('/admin/active/{id}', [SuperDashboardController::class, 'ActiveAdmin']);

    Route::get('/dashboard', [SuperDashboardController::class, 'Dashboard']);
    Route::get('/admins', [SuperDashboardController::class, 'Admins']);

    Route::get('/pages/home', [SuperPageController::class, 'HomePage']);
    Route::post('/pages/home', [SuperPageController::class, 'HomePageSave']);

    Route::get('/pages/login', [SuperPageController::class, 'LoginPage']);
    Route::post('/pages/login', [SuperPageController::class, 'LoginPageSave']);

    Route::get('/pages/contact', [SuperPageController::class, 'ContactPage']);
    Route::post('/pages/contact', [SuperPageController::class, 'ContactPageSave']);

    Route::get('/pages/about', [SuperPageController::class, 'AboutPage']);
    Route::post('/pages/about', [SuperPageController::class, 'AboutPageSave']);

    Route::get('/messages/unread', [SuperMessageController::class, 'UnreadMessages']);
    Route::get('/messages/read', [SuperMessageController::class, 'ReadMessages']);
    Route::get('/message/detail/{id}', [SuperMessageController::class, 'MessageDetail']);
    Route::post('/message/reply', [SuperMessageController::class, 'AdminMessageReply']);

    Route::get('/support/messages/unread', [SuperSupportController::class, 'SupportUnread']);
    Route::get('/support/messages/read', [SuperSupportController::class, 'SupportRead']);
    Route::get('/support/message/detail/{id}', [SuperSupportController::class, 'SupportDetail']);
    Route::post('/support/message/reply', [SuperSupportController::class, 'SupportReply']);

    Route::get('/basic-settings', [BasicSettingsController::class, 'BasicSettings']);
    Route::post('/basic-settings', [BasicSettingsController::class, 'BasicSettingsSave']);

});


Route::get('/{username}', [HomeController::class, 'UserHomePage']);
Route::get('/{username}/about', [HomeController::class, 'UserAboutPage']);
Route::get('/{username}/contact', [HomeController::class, 'UserContactPage']);
Route::get('/{username}/category/{category_id}', [HomeController::class, 'UserCategoryPage']);