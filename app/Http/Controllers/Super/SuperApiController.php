<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\DefaultAboutPage;
use App\Models\DefaultContactPage;
use App\Models\DefaultHomePage;
use App\Models\Downloads;
use App\Models\Podcast;
use App\Models\User;
use App\Models\UserAboutPage;
use App\Models\UserContact;
use App\Models\UserContactPage;
use App\Models\UserHomePage;
use App\Models\UserMessagesReply;
use App\Models\UserSubscribers;
use App\Models\Views;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class SuperApiController extends Controller
{
    public function getUsername($string)
    {
        $slug = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($string)));
        $exists = User::where('username', 'LIKE', '%'.$slug.'%')->get();
        if(count($exists) > 0) {
            foreach ($exists as $user) {
                $data[] = $user->username;
            }
            if(in_array($slug, $data)) {
                $count = 0;
                while(in_array(($slug . '-' . ++$count), $data));
                $slug = $slug . '-' . $count;
            }
        }
        return $slug;
    } 

    public function CreateAdmin(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required',
                'name' => 'required',
                'memory_limit' => 'required'
            ]);

        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $request->post()]);
        }

        $users = User::where(['username' => $request->username])->get();
        if (count($users) > 0) {
            return response()->json(['status' => 'error', 'message' => 'Username already exists.']);
        }

        try {
            $random_password = rand(11111111, 99999999);
            $hashed_password = Hash::make($random_password);
            $admin = new User();
            $admin->name = $request->name;
            $admin->username = $this->getUsername($request->name);
            $admin->email = $request->email;
            $admin->memory_limit = $request->memory_limit;
            $admin->role = 1;
            $admin->status = 1;
            $admin->password = $hashed_password;
            $admin->save();

            $default_home_page = new DefaultHomePage();
            $default_home_page->image = null;
            $file_path = public_path('project_assets/images/default_home.jpg');
            if (file_exists($file_path)) {
                $extension = pathinfo(public_path('project_assets/images/default_home.jpg'), PATHINFO_EXTENSION);
                $image_name = time() . uniqid() . '.' . $extension;
                File::copy(public_path('project_assets/images/default_home.jpg'), public_path('project_assets/images/' . $image_name));
                $default_home_page->image = $image_name;
            }
            $default_home_page->admin_id = $admin->id;
            $default_home_page->save();

            $default_contact_page = new DefaultContactPage();
            $default_contact_page->image = null;
            $file_path = public_path('project_assets/images/default_contact.jpg');
            if (file_exists($file_path)) {
                $extension = pathinfo(public_path('project_assets/images/default_contact.jpg'), PATHINFO_EXTENSION);
                $image_name = time() . uniqid() . '.' . $extension;
                File::copy(public_path('project_assets/images/default_contact.jpg'), public_path('project_assets/images/' . $image_name));
                $default_contact_page->image = $image_name;
            }
            $default_contact_page->heading = "Contact";
            $default_contact_page->text = "Contact Description";
            $default_contact_page->admin_id = $admin->id;
            $default_contact_page->save();

            $default_about_page = new DefaultAboutPage();
            $default_about_page->cover_image = null;
            $file_path = public_path('project_assets/images/default_about.jpg');
            if (file_exists($file_path)) {
                $extension = pathinfo(public_path('project_assets/images/default_about.jpg'), PATHINFO_EXTENSION);
                $image_name = time() . uniqid() . '.' . $extension;
                File::copy(public_path('project_assets/images/default_about.jpg'), public_path('project_assets/images/' . $image_name));
                $default_about_page->cover_image = $image_name;
            }
            $default_about_page->profile_image = null;
            $file_path = public_path('project_assets/images/default_about_profile.jpg');
            if (file_exists($file_path)) {
                $extension = pathinfo(public_path('project_assets/images/default_about_profile.jpg'), PATHINFO_EXTENSION);
                $image_name = time() . uniqid("", true) . '.' . $extension;
                File::copy(public_path('project_assets/images/default_about_profile.jpg'), public_path('project_assets/images/' . $image_name));
                $default_about_page->profile_image = $image_name;
            }
            $default_about_page->heading = "About Me";
            $default_about_page->text = "About Me Description";
            $default_about_page->admin_id = $admin->id;
            $default_about_page->save();

            $default_about_page = DefaultAboutPage::where(['admin_id' => $admin->id])->first();
            $user_about_page = new UserAboutPage();
            $user_about_page->user_id = $admin->id;
            $user_about_page->cover_image = null;
            $file_path = public_path('project_assets/images/' . $default_about_page->cover_image);
            if (file_exists($file_path) && $default_about_page->cover_image != null) {
                $extension = pathinfo(public_path('project_assets/images/' . $default_about_page->cover_image), PATHINFO_EXTENSION);
                $image_name = time() . uniqid() . '.' . $extension;
                File::copy(public_path('project_assets/images/' . $default_about_page->cover_image), public_path('project_assets/images/' . $image_name));
                $user_about_page->cover_image = $image_name;
            }
            $user_about_page->profile_image = null;
            $file_path = public_path('project_assets/images/' . $default_about_page->profile_image);
            if (file_exists($file_path) && $default_about_page->profile_image != null) {
                $extension = pathinfo(public_path('project_assets/images/' . $default_about_page->profile_image), PATHINFO_EXTENSION);
                $image_name = time() . uniqid() . '.' . $extension;
                File::copy(public_path('project_assets/images/' . $default_about_page->profile_image), public_path('project_assets/images/' . $image_name));
                $user_about_page->profile_image = $image_name;
            }
            $user_about_page->heading = $default_about_page->heading;
            $user_about_page->text = $default_about_page->text;
            $user_about_page->save();

            $default_contact_page = DefaultContactPage::where(['admin_id' => $admin->id])->first();
            $user_contact_page = new UserContactPage();
            $user_contact_page->user_id = $admin->id;
            $user_contact_page->image = null;
            $file_path = public_path('project_assets/images/' . $default_contact_page->image);
            if (file_exists($file_path) && $default_contact_page->image != null) {
                $extension = pathinfo(public_path('project_assets/images/' . $default_contact_page->image), PATHINFO_EXTENSION);
                $image_name = time() . uniqid() . '.' . $extension;
                File::copy(public_path('project_assets/images/' . $default_contact_page->image), public_path('project_assets/images/' . $image_name));
                $user_contact_page->image = $image_name;
            }
            $user_contact_page->heading = $default_contact_page->heading;
            $user_contact_page->text = $default_contact_page->text;
            $user_contact_page->save();

            $default_home_page = DefaultHomePage::where(['admin_id' => $admin->id])->first();
            $user_home_page = new UserHomePage();
            $user_home_page->user_id = $admin->id;
            $user_home_page->image = null;
            $file_path = public_path('project_assets/images/' . $default_home_page->image);
            if (file_exists($file_path) && $default_home_page->image != null) {
                $extension = pathinfo(public_path('project_assets/images/' . $default_home_page->image), PATHINFO_EXTENSION);
                $image_name = time() . uniqid() . '.' . $extension;
                File::copy(public_path('project_assets/images/' . $default_home_page->image), public_path('project_assets/images/' . $image_name));
                $user_home_page->image = $image_name;
            }
            $user_home_page->save();
            return response()->json(['status' => 'success', 'message' => 'Admin successfully created.']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong.']);
        }
    }

    public function SuspendAdmin(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required'
            ]);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => "Please provide all fields."]);
        }

        $admin = User::where(['id' => $request->user_id, 'role' => 1])->first();
        if ($admin) {
            $admin->status = 0;
            $admin->save();
            return response()->json(['status' => 'success', 'message' => "User suspended successfully."]);
        } else {
            return response()->json(['status' => 'error', 'message' => "User doesn't exist."]);
        }
    }

    public function UnsuspendAdmin(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required'
            ]);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => "Please provide all fields."]);
        }

        $admin = User::where(['id' => $request->user_id, 'role' => 1])->first();
        if ($admin) {
            $admin->status = 1;
            $admin->save();
            return response()->json(['status' => 'success', 'message' => "User unsuspended successfully."]);
        } else {
            return response()->json(['status' => 'error', 'message' => "User doesn't exist."]);
        }
    }

    public function DeleteAdmin(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required'
            ]);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => "Please provide all fields."]);
        }


        try {
            $admin = User::where(['id' => $request->user_id, 'role' => 1])->with(['podcasts'])->first();
            if ($admin) {
                $users = User::where(['belongs_to' => $admin->id])->with(['podcasts'])->get();
                foreach ($users as $user) {
                    $podcasts = $user->podcasts;
                    foreach ($podcasts as $podcast) {
                        $file_path = storage_path('app/public/podcast/' . $podcast->id);
                        if (file_exists($file_path)) {
                            $this->delTree($file_path);
                        }
                        Views::where(['podcast_id' => $podcast->id])->delete();
                        Downloads::where(['podcast_id' => $podcast->id])->delete();
                    }
                    Podcast::where(['user_id' => $user->id])->delete();

                    UserSubscribers::where(['user_id' => $user->id])->delete();
                    $user_contact = UserContact::where(['user_id' => $user->id])->get();
                    foreach ($user_contact as $contact) {
                        UserMessagesReply::where(['message_id' => $contact->id])->delete();
                    }
                    UserContact::where(['user_id' => $user->id])->delete();

                    $user_home_page = UserHomePage::where(['user_id' => $user->id])->first();
                    if ($user_home_page && $user_home_page->image !== null) {
                        $file_path = public_path('project_assets/images/' . $user_home_page->image);
                        if (file_exists($file_path)) {
                            unlink($file_path);
                        }
                    }
                    UserHomePage::where(['user_id' => $user->id])->delete();

                    $user_contact_page = UserContactPage::where(['user_id' => $user->id])->first();
                    if ($user_contact_page && $user_contact_page->image !== null) {
                        $file_path = public_path('project_assets/images/' . $user_contact_page->image);
                        if (file_exists($file_path)) {
                            unlink($file_path);
                        }
                    }
                    UserContactPage::where(['user_id' => $user->id])->delete();

                    $user_about_page = UserAboutPage::where(['user_id' => $user->id])->first();
                    if ($user_about_page && $user_about_page->profile_image !== null) {
                        $file_path = public_path('project_assets/images/' . $user_about_page->profile_image);
                        if (file_exists($file_path)) {
                            unlink($file_path);
                        }
                    }
                    if ($user_about_page && $user_about_page->cover_image !== null) {
                        $file_path = public_path('project_assets/images/' . $user_about_page->cover_image);
                        if (file_exists($file_path)) {
                            unlink($file_path);
                        }
                    }
                    UserAboutPage::where(['user_id' => $user->id])->delete();
                }
                User::where(['belongs_to' => $admin->id])->delete();

                $podcasts = $admin->podcasts;
                foreach ($podcasts as $podcast) {
                    $file_path = storage_path('app/public/podcast/' . $podcast->id);
                    if (file_exists($file_path)) {
                        $this->delTree($file_path);
                    }
                    Views::where(['podcast_id' => $podcast->id])->delete();
                    Downloads::where(['podcast_id' => $podcast->id])->delete();
                }
                Podcast::where(['user_id' => $request->user_id])->delete();

                UserSubscribers::where(['user_id' => $request->user_id])->delete();
                $user_contact = UserContact::where(['user_id' => $request->user_id])->get();
                foreach ($user_contact as $contact) {
                    UserMessagesReply::where(['message_id' => $contact->id])->delete();
                }
                UserContact::where(['user_id' => $request->user_id])->delete();

                $user_home_page = UserHomePage::where(['user_id' => $request->user_id])->first();
                if ($user_home_page && $user_home_page->image !== null) {
                    $file_path = public_path('project_assets/images/' . $user_home_page->image);
                    if (file_exists($file_path)) {
                        unlink($file_path);
                    }
                }
                UserHomePage::where(['user_id' => $request->user_id])->delete();

                $user_contact_page = UserContactPage::where(['user_id' => $request->user_id])->first();
                if ($user_contact_page && $user_contact_page->image !== null) {
                    $file_path = public_path('project_assets/images/' . $user_contact_page->image);
                    if (file_exists($file_path)) {
                        unlink($file_path);
                    }
                }
                UserContactPage::where(['user_id' => $request->user_id])->delete();

                $user_about_page = UserAboutPage::where(['user_id' => $request->user_id])->first();
                if ($user_about_page && $user_about_page->profile_image !== null) {
                    $file_path = public_path('project_assets/images/' . $user_about_page->profile_image);
                    if (file_exists($file_path)) {
                        unlink($file_path);
                    }
                }
                if ($user_about_page && $user_about_page->cover_image !== null) {
                    $file_path = public_path('project_assets/images/' . $user_about_page->cover_image);
                    if (file_exists($file_path)) {
                        unlink($file_path);
                    }
                }
                UserAboutPage::where(['user_id' => $request->user_id])->delete();

                $default_home_page = DefaultHomePage::where(['admin_id' => $request->user_id])->first();
                if ($default_home_page && $default_home_page->image !== null) {
                    $file_path = public_path('project_assets/images/' . $default_home_page->image);
                    if (file_exists($file_path)) {
                        unlink($file_path);
                    }
                }
                DefaultHomePage::where(['admin_id' => $request->user_id])->delete();

                $default_contact_page = DefaultContactPage::where(['admin_id' => $request->user_id])->first();
                if ($default_contact_page && $default_contact_page->image !== null) {
                    $file_path = public_path('project_assets/images/' . $default_contact_page->image);
                    if (file_exists($file_path)) {
                        unlink($file_path);
                    }
                }
                DefaultContactPage::where(['admin_id' => $request->user_id])->delete();

                $default_about_page = DefaultAboutPage::where(['admin_id' => $request->user_id])->first();
                if ($default_about_page && $default_about_page->profile_image !== null) {
                    $file_path = public_path('project_assets/images/' . $default_about_page->profile_image);
                    if (file_exists($file_path)) {
                        unlink($file_path);
                    }
                }
                if ($default_about_page && $default_about_page->cover_image !== null) {
                    $file_path = public_path('project_assets/images/' . $default_about_page->cover_image);
                    if (file_exists($file_path)) {
                        unlink($file_path);
                    }
                }
                DefaultAboutPage::where(['admin_id' => $request->user_id])->delete();

                Categories::where(['admin_id' => $request->user_id])->delete();

                User::where(['id' => $request->user_id, 'role' => 1])->delete();
                return response()->json(['status' => 'success', 'message' => "User deleted successfully."]);
            } else {
                return response()->json(['status' => 'error', 'message' => "User doesn't exist."]);
            }
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => "Something went wrong."]);
        }
    }
}
