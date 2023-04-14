<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductColors;
use App\Models\StoreColors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreColorsController extends Controller
{
    public function Colors()
    {
        $colors = StoreColors::where(['user_id' => Auth::user()->id])->get();
        return view('admin.store_colors', compact('colors'));
    }

    public function AddColor(Request $request)
    {
        $request->validate([
            'title' =>  'required'
        ]);
        $color = new StoreColors();
        $color->title = $request->title;
        $color->user_id = Auth::user()->id;
        $color->status = 1;
        $color->save();
        return redirect()->back();
    }

    public function EditColor(Request $request)
    {
        $request->validate([
            'title' =>  'required',
            'id'    =>  'required'
        ]);
        StoreColors::where(['id' =>  $request->id, 'user_id' => Auth::user()->id])->update([ 'title'    =>  $request->title]);
        return redirect()->back();
    }

    public function InactiveColor($id)
    {
        StoreColors::where('id', $id)->update(['status'   =>  0, 'user_id' => Auth::user()->id]);
        return redirect()->back();
    }

    public function ActiveColor($id)
    {
        StoreColors::where('id', $id)->update(['status'   =>1, 'user_id' => Auth::user()->id]);
        return redirect()->back();
    }

    public function DeleteColor($id)
    {
        $store_colors = StoreColors::where(['id' =>$id, 'user_id' => Auth::user()->id])->get();
        $color_ids = [];
        foreach($store_colors as $colors) {
            array_push($color_ids, $colors->id);
        }
        ProductColors::whereIn('color_id', $color_ids)->delete();
        StoreColors::where(['id' => $id, 'user_id' => Auth::user()->id])->delete();
        return redirect()->back();
    }

}
