<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Podcast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserCategoriesController extends Controller
{
    public function Categories()
    {
        $categories = Categories::where(['admin_id' => Auth::user()->id])->get();
        return view('dashboard.categories', compact('categories'));
    }
}
