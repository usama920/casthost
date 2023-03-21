<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoriesController extends Controller
{
    public function Categories()
    {
        $categories = Categories::where(['admin_id' => Auth::user()->id])->get();
        return view('admin.categories', compact('categories'));
    }

    public function AddCategory(Request $request)
    {
        $request->validate([
            'title' =>  'required'
        ]);
        $category = new Categories();
        $category->title = $request->title;
        $category->admin_id = Auth::user()->id;
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
        Categories::where(['id' =>  $request->id, 'admin_id' => Auth::user()->id])->update([ 'title'    =>  $request->title]);
        return redirect()->back();
    }

    public function InactiveCategory($id)
    {
        Categories::where('id', $id)->update(['status'   =>  0, 'admin_id' => Auth::user()->id]);
        return redirect()->back();
    }

    public function ActiveCategory($id)
    {
        Categories::where('id', $id)->update(['status'   =>1, 'admin_id' => Auth::user()->id]);
        return redirect()->back();
    }

    public function DeleteCategory($id)
    {
        Categories::where(['id' =>$id, 'admin_id' => Auth::user()->id])->delete();
        return redirect()->back();
    }
}
