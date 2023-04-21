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
use App\Http\Controllers\Admin\AdminMessagesController;
use App\Http\Controllers\Admin\AdminPageController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\StoreCategoriesController;
use App\Http\Controllers\Admin\StoreColorsController;
use App\Http\Controllers\Admin\StoreOrdersController;
use App\Http\Controllers\Admin\StorePaymentController;
use App\Http\Controllers\Admin\StoreProductController;
use App\Http\Controllers\Admin\StoreSizesController;
use App\Http\Controllers\User\UserStorePaymentController;
use App\Http\Controllers\User\UserStoreSizesController;
use App\Http\Controllers\SubscriberController;
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
use App\Http\Controllers\User\UserStoreCategoriesController;
use App\Http\Controllers\User\UserStoreColorsController;
use App\Http\Controllers\User\UserStoreOrdersController;
use App\Http\Controllers\User\UserStoreProductController;
use Illuminate\Support\Facades\Route;


Route::get('/createStripeAccountId', [PaymentController::class, 'createStripeAccountId']);
Route::get('/', [HomeController::class, 'Home']);
Route::get('/login', [LoginController::class, 'Login'])->name('login');
Route::get('/subscriber/logout', [ HomeController::class, 'SubscriberLogout']);
Route::get('/subscribe/paid/{user_id}', [HomeController::class, 'PaidSubscribe']);
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
    Route::post('/change/password', [AdminDashboardController::class, 'AdminChangePassword']);

    Route::get('/', [AdminDashboardController::class, 'Dashboard']);
    Route::get('/dashboard', [AdminDashboardController::class, 'Dashboard']);
    Route::post('/user/add', [UserController::class, 'AddUser']);
    Route::post('/user/add/verify/email', [UserController::class, 'AddUserVerifyDuplication']);
    Route::get('/users', [UserController::class, 'Users']);
    Route::get('/user/delete/{id}', [UserController::class, 'DeleteUser']);
    Route::get('/user/detail/{id}', [UserController::class, 'UserDetail']);
    Route::get('/users/search', [UserController::class, 'SearchUser']);
    Route::get('/user/inactive/{id}', [UserController::class, 'InactiveUser']);
    Route::get('/user/active/{id}', [UserController::class, 'ActiveUser']);

    Route::post('/user/edit/memory', [UserController::class, 'UserEditMemory']);

    Route::get('/users/export', [UserController::class, 'ExportUsers']);

    Route::get('/podcast/new', [AdminPodcastController::class, 'NewPodcast']);
    Route::get('/podcast/new/revert/{id}', [AdminPodcastController::class, 'RevertPodcast']);
    Route::post('/podcast/new/upload', [AdminPodcastController::class, 'UploadPodcast']);
    Route::post('/podcast/save', [AdminPodcastController::class, 'SavePodcast']);

    Route::get('/podcast/inactive/{id}', [AdminPodcastController::class, 'InactivePodcast']);
    Route::get('/podcast/active/{id}', [AdminPodcastController::class, 'ActivePodcast']);
    Route::get('/podcast/detail/{id}', [AdminPodcastController::class, 'AdminPodcastDetail']);
    Route::post('/podcast/update', [AdminPodcastController::class, 'UpdatePodcast']);
    Route::get('/podcast/delete/{id}', [AdminPodcastController::class, 'DeletePodcast']);

    Route::get('/podcasts', [AdminPodcastController::class, 'AdminPodcasts']);
    Route::get('/users/podcasts', [AdminPodcastController::class, 'UsersPodcasts']);
    Route::get('/users/podcasts/search', [AdminPodcastController::class, 'UsersPodcastsSearch']);
    Route::get('/user/podcast/detail/{id}', [AdminPodcastController::class, 'PodcastDetail']);

    Route::get('/user/podcast/inactive/{id}', [UserController::class, 'InactivePodcast']);
    Route::get('/user/podcast/active/{id}', [UserController::class, 'ActivePodcast']);

    Route::get('/user_podcasts/export/{id}', [AdminPodcastController::class, 'ExportUserPodcasts']);
    Route::get('/podcasts/export', [AdminPodcastController::class, 'ExportPodcasts']);

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

    Route::get('/profile', [AdminProfileController::class, 'Profile']);
    Route::post('/profile', [AdminProfileController::class, 'SaveProfile']);

    Route::get('/pages/home', [AdminPageController::class, 'HomePage']);
    Route::post('/pages/home', [AdminPageController::class, 'HomePageSave']);

    Route::get('/pages/store', [AdminPageController::class, 'StorePage']);
    Route::post('/pages/store', [AdminPageController::class, 'StorePageSave']);

    Route::get('/pages/contact', [AdminPageController::class, 'ContactPage']);
    Route::post('/pages/contact', [AdminPageController::class, 'ContactPageSave']);

    Route::get('/pages/about', [AdminPageController::class, 'AboutPage']);
    Route::post('/pages/about', [AdminPageController::class, 'AboutPageSave']);

    Route::get('/default/pages/home', [AdminDefaultPageController::class, 'HomePage']);
    Route::post('/default/pages/home', [AdminDefaultPageController::class, 'HomePageSave']);

    Route::get('/default/pages/contact', [AdminDefaultPageController::class, 'ContactPage']);
    Route::post('/default/pages/contact', [AdminDefaultPageController::class, 'ContactPageSave']);

    Route::get('/default/pages/about', [AdminDefaultPageController::class, 'AboutPage']);
    Route::post('/default/pages/about', [AdminDefaultPageController::class, 'AboutPageSave']);

    Route::get('/messages/unread', [AdminMessagesController::class, 'UnreadMessages']);
    Route::get('/messages/read', [AdminMessagesController::class, 'ReadMessages']);
    Route::get('/message/detail/{id}', [AdminMessagesController::class, 'MessageDetail']);
    Route::post('/message/reply', [AdminMessagesController::class, 'MessageReply']);

    Route::get('/store/add_product', [StoreProductController::class, 'AddProduct']);
    Route::post('/store/add_product', [StoreProductController::class, 'SaveProduct']);
    Route::get('/store/all_products', [StoreProductController::class, 'AllProducts']);
    Route::get('/store/product/inactive/{id}', [StoreProductController::class, 'InactiveProduct']);
    Route::get('/store/product/active/{id}', [StoreProductController::class, 'ActiveProduct']);
    Route::get('/store/product/detail/{id}', [StoreProductController::class, 'ProductDetail']);
    Route::get('/store/product/delete/{id}', [StoreProductController::class, 'ProductDelete']);
    Route::post('/store/product/update', [StoreProductController::class, 'UpdateProduct']);
    Route::get('/store/product/other_image/delete/{image_id}', [StoreProductController::class, 'DeleteOtherImage']);

    Route::get('/store/categories', [StoreCategoriesController::class, 'Categories']);
    Route::post('/store/category/add', [StoreCategoriesController::class, 'AddCategory']);
    Route::get('/store/category/inactive/{id}', [StoreCategoriesController::class, 'InactiveCategory']);
    Route::get('/store/category/active/{id}', [StoreCategoriesController::class, 'ActiveCategory']);
    Route::post('/store/category/edit', [StoreCategoriesController::class, 'EditCategory']);
    Route::get('/store/category/delete/{id}', [StoreCategoriesController::class, 'DeleteCategory']);

    Route::get('/store/sizes', [StoreSizesController::class, 'Sizes']);
    Route::post('/store/size/add', [StoreSizesController::class, 'AddSize']);
    Route::get('/store/size/inactive/{id}', [StoreSizesController::class, 'InactiveSize']);
    Route::get('/store/size/active/{id}', [StoreSizesController::class, 'ActiveSize']);
    Route::post('/store/size/edit', [StoreSizesController::class, 'EditSize']);
    Route::get('/store/size/delete/{id}', [StoreSizesController::class, 'DeleteSize']);

    Route::get('/store/colors', [StoreColorsController::class, 'Colors']);
    Route::post('/store/color/add', [StoreColorsController::class, 'AddColor']);
    Route::get('/store/color/inactive/{id}', [StoreColorsController::class, 'InactiveColor']);
    Route::get('/store/color/active/{id}', [StoreColorsController::class, 'ActiveColor']);
    Route::post('/store/color/edit', [StoreColorsController::class, 'EditColor']);
    Route::get('/store/color/delete/{id}', [StoreColorsController::class, 'DeleteColor']);

    Route::get('/store/orders', [StoreOrdersController::class, 'Orders']);
    Route::get('/store/order/detail/{id}', [StoreOrdersController::class, 'OrderDetail']);
    Route::post('/store/order/detail/save', [StoreOrdersController::class, 'OrderDetailSave']);
    
    Route::get('/store/payout', [StorePaymentController::class, 'Payout']);
    Route::get('/store/stripe/create', [StorePaymentController::class, 'CreatePayout']);

    Route::get('/subscription/payout', [StorePaymentController::class, 'SubscriptionPayout']);

    
    
});

Route::group(['prefix' => 'users', 'middleware' => 'user_auth'], function () {
    Route::get('/dashboard', [DashboardController::class, 'Dashboard']);
    Route::post('/change/password', [DashboardController::class, 'UserChangePassword']);


    Route::get('/podcast/new', [PodcastController::class, 'NewPodcast']);
    Route::get('/podcast/new/revert/{id}', [PodcastController::class, 'RevertPodcast']);
    Route::post('/podcast/new/upload', [PodcastController::class, 'UploadPodcast']);
    Route::post('/podcast/save', [PodcastController::class, 'SavePodcast']);

    Route::get('/podcasts/export', [PodcastController::class, 'ExportPodcasts']);
    Route::get('/podcasts', [PodcastController::class, 'UserPodcasts']);
    Route::get('/podcast/inactive/{id}', [PodcastController::class, 'InactivePodcast']);
    Route::get('/podcast/active/{id}', [PodcastController::class, 'ActivePodcast']);
    Route::get('/podcast/detail/{id}', [PodcastController::class, 'PodcastDetail']);
    Route::post('/podcast/update', [PodcastController::class, 'UpdatePodcast']);
    Route::get('/podcast/delete/{id}', [PodcastController::class, 'DeletePodcast']);

    Route::get('/podcasts/distribution', [PodcastController::class, 'PodcastsDistribution']);
    Route::get('/podcasts/distribution/google_podcasts', [PodcastController::class, 'GooglePodcastsDistribution']);
    Route::post('/podcasts/distribution/google_podcasts/save', [PodcastController::class, 'GooglePodcastsDistributionSave']);

    Route::get('/podcasts/distribution/spotify', [PodcastController::class, 'SpotifyDistribution']);

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

    Route::get('/store/add_product', [UserStoreProductController::class, 'AddProduct']);
    Route::post('/store/add_product', [UserStoreProductController::class, 'SaveProduct']);
    Route::get('/store/all_products', [UserStoreProductController::class, 'AllProducts']);
    Route::get('/store/product/inactive/{id}', [UserStoreProductController::class, 'InactiveProduct']);
    Route::get('/store/product/active/{id}', [UserStoreProductController::class, 'ActiveProduct']);
    Route::get('/store/product/detail/{id}', [UserStoreProductController::class, 'ProductDetail']);
    Route::get('/store/product/delete/{id}', [UserStoreProductController::class, 'ProductDelete']);
    Route::post('/store/product/update', [UserStoreProductController::class, 'UpdateProduct']);
    Route::get('/store/product/other_image/delete/{image_id}', [UserStoreProductController::class, 'DeleteOtherImage']);

    Route::get('/store/categories', [UserStoreCategoriesController::class, 'Categories']);
    Route::post('/store/category/add', [UserStoreCategoriesController::class, 'AddCategory']);
    Route::get('/store/category/inactive/{id}', [UserStoreCategoriesController::class, 'InactiveCategory']);
    Route::get('/store/category/active/{id}', [UserStoreCategoriesController::class, 'ActiveCategory']);
    Route::post('/store/category/edit', [UserStoreCategoriesController::class, 'EditCategory']);
    Route::get('/store/category/delete/{id}', [UserStoreCategoriesController::class, 'DeleteCategory']);

    Route::get('/store/sizes', [UserStoreSizesController::class, 'Sizes']);
    Route::post('/store/size/add', [UserStoreSizesController::class, 'AddSize']);
    Route::get('/store/size/inactive/{id}', [UserStoreSizesController::class, 'InactiveSize']);
    Route::get('/store/size/active/{id}', [UserStoreSizesController::class, 'ActiveSize']);
    Route::post('/store/size/edit', [UserStoreSizesController::class, 'EditSize']);
    Route::get('/store/size/delete/{id}', [UserStoreSizesController::class, 'DeleteSize']);

    Route::get('/store/colors', [UserStoreColorsController::class, 'Colors']);
    Route::post('/store/color/add', [UserStoreColorsController::class, 'AddColor']);
    Route::get('/store/color/inactive/{id}', [UserStoreColorsController::class, 'InactiveColor']);
    Route::get('/store/color/active/{id}', [UserStoreColorsController::class, 'ActiveColor']);
    Route::post('/store/color/edit', [UserStoreColorsController::class, 'EditColor']);
    Route::get('/store/color/delete/{id}', [UserStoreColorsController::class, 'DeleteColor']);

    Route::get('/store/orders', [UserStoreOrdersController::class, 'Orders']);
    Route::get('/store/order/detail/{id}', [UserStoreOrdersController::class, 'OrderDetail']);
    Route::post('/store/order/detail/save', [UserStoreOrdersController::class, 'OrderDetailSave']);

    Route::get('/store/payout', [UserStorePaymentController::class, 'Payout']);
    Route::get('/store/stripe/create', [UserStorePaymentController::class, 'CreatePayout']);

    Route::get('/subscription/payout', [UserStorePaymentController::class, 'SubscriptionPayout']);

});
 
Route::get('/superAdmin/login', [SuperDashboardController::class, 'Login']);
Route::post('/superAdmin/login', [SuperDashboardController::class, 'TryLogin']);
Route::group(['prefix' =>'superAdmin', 'middleware' => 'super_auth'], function () {
    Route::get('/', [SuperDashboardController::class, 'Dashboard']);

    Route::get('/admin/login/{id}', [SuperDashboardController::class, 'AdminLogin']);
    Route::get('/admin/delete/{id}', [SuperDashboardController::class, 'AdminDelete']);
    Route::post('/admin/add', [SuperDashboardController::class, 'AdminAdd']);
    Route::post('/admin/add/verify/email', [SuperDashboardController::class, 'AddAdminVerifyDuplication']);
    Route::get('/admins/search', [SuperDashboardController::class, 'SearchAdmin']);
    Route::get('/admin/inactive/{id}', [SuperDashboardController::class, 'InactiveAdmin']);
    Route::get('/admin/active/{id}', [SuperDashboardController::class, 'ActiveAdmin']);

    Route::post('/admin/edit/memory', [SuperDashboardController::class, 'AdminEditMemory']);

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

Route::group(['middleware' => 'subscriber_auth'], function () {
    Route::get('/{username}/subscriber/profile', [SubscriberController::class, 'Orders']);
    Route::get('/{username}/subscriber/orders', [SubscriberController::class, 'Orders']);
    Route::post('/subscriber/order/detail', [SubscriberController::class, 'OrderDetail']);
    Route::get('/{username}/subscriber/users_subscribed', [SubscriberController::class, 'UsersSubscribed']);
    
    Route::get('/{username}/cart', [HomeController::class, 'UserCartPage']);
    Route::get('/{username}/checkout', [ StorePaymentController::class, 'UserCheckoutPage']);
    Route::post('/{username}/checkout/done', [StorePaymentController::class, 'CheckoutDone']);
});

Route::get('/superAdmin/logout', [SuperDashboardController::class, 'SuperLogout']);

Route::get('/rss/{username}', [HomeController::class, 'UserRSS']);
Route::post('/store/update_cart', [ HomeController::class, 'UpdateCart']);
Route::post( '/store/update_cart/quantity', [HomeController::class, 'UpdateCartQuantity']);
Route::post('/store/update_cart/remove', [HomeController::class, 'RemoveCartProduct']);


Route::get('/{username}', [ HomeController::class, 'UserHomePage']);
Route::get('/{username}/login', [LoginController::class, 'LoginUsername']);
Route::get('/{username}/store', [ HomeController::class, 'UserStorePage']);
Route::get('/{username}/store/search', [HomeController::class, 'UserStoreSearch']);
Route::get('/{username}/store/category/{category_id}', [HomeController::class, 'UserStorePageWithCategory']);
Route::get('/{username}/store/{product_id}', [HomeController::class, 'UserStoreProductPage']);
Route::get('/{username}/about', [HomeController::class, 'UserAboutPage']);
Route::get('/{username}/contact', [HomeController::class, 'UserContactPage']);
Route::get('/{username}/category/{category_id}', [HomeController::class, 'UserCategoryPage']);