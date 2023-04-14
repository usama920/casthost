<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ProductSizes;
use App\Models\StoreSizes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserStoreSizesController extends Controller
{
    public function Sizes()
    {
        $sizes = StoreSizes::where(['user_id' => Auth::user()->id])->get();
        return view('dashboard.store_sizes', compact('sizes'));
    }

    public function AddSize(Request $request)
    {
        $request->validate([
            'title' =>  'required'
        ]);
        $size = new StoreSizes();
        $size->title = $request->title;
        $size->user_id = Auth::user()->id;
        $size->status = 1;
        $size->save();
        return redirect()->back();
    }

    public function EditSize(Request $request)
    {
        $request->validate([
            'title' =>  'required',
            'id'    =>  'required'
        ]);
        StoreSizes::where(['id' =>  $request->id, 'user_id' => Auth::user()->id])->update([ 'title'    =>  $request->title]);
        return redirect()->back();
    }

    public function InactiveSize($id)
    {
        StoreSizes::where('id', $id)->update(['status'   =>  0, 'user_id' => Auth::user()->id]);
        return redirect()->back();
    }

    public function ActiveSize($id)
    {
        StoreSizes::where('id', $id)->update(['status'   =>1, 'user_id' => Auth::user()->id]);
        return redirect()->back();
    }

    public function DeleteSize($id)
    {
        $store_colors = StoreSizes::where(['id' => $id, 'user_id' => Auth::user()->id])->get();
        $size_ids = [];
        foreach ($store_colors as $colors) {
            array_push($size_ids, $colors->id);
        }
        ProductSizes::whereIn('size_id', $size_ids)->delete();
        StoreSizes::where(['id' => $id, 'user_id' => Auth::user()->id])->delete();
        return redirect()->back();
    }
}
