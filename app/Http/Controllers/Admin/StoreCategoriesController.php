<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StoreCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreCategoriesController extends Controller
{
    public function Categories()
    {
        $categories = StoreCategories::where(['user_id' => Auth::user()->id])->get();
        return view('admin.store_categories', compact('categories'));
    }

    public function AddCategory(Request $request)
    {
        $request->validate([
            'title' =>  'required'
        ]);
        $category = new StoreCategories();
        $category->title = $request->title;
        $category->user_id = Auth::user()->id;
        $category->status = 1;
        $category->save();
        return redirect()->back();
    }

    public function EditCategory(Request $request)
    {
        $request->validate([
            'title' =>  'required',
            'id'    =>  'required'
        ]);
        StoreCategories::where(['id' =>  $request->id, 'user_id' => Auth::user()->id])->update([ 'title'    =>  $request->title]);
        return redirect()->back();
    }

    public function InactiveCategory($id)
    {
        StoreCategories::where(['id' => $id, 'user_id' => Auth::user()->id])->update(['status'   =>  0]);
        return redirect()->back();
    }

    public function ActiveCategory($id)
    {
        StoreCategories::where(['id' => $id, 'user_id' => Auth::user()->id])->update(['status'   =>1, 'user_id' => Auth::user()->id]);
        return redirect()->back();
    }

    public function DeleteCategory($id)
    {
        StoreCategories::where(['id' =>$id, 'user_id' => Auth::user()->id])->delete();
        return redirect()->back();
    }
}
