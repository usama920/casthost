<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductColors;
use App\Models\StoreColors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreOrdersController extends Controller
{
    public function Orders()
    {
        $orders = Order::where('status', '!=', 0)->with(['order_items', 'subscriber'])->whereRelation('order_items', 'user_id', '=', Auth::user()->id)->get();
        return view('admin.store_orders', compact('orders'));
    }

    public function OrderDetail($id)
    {
        $order = Order::where(['id' => $id])->where('status', '!=', 0)->with(['order_items', 'subscriber'])->whereRelation('order_items', 'user_id', '=', Auth::user()->id)->first();
        return view('admin.store_order_detail', compact('order'));
    }

    public function OrderDetailSave(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'status' => 'required'
        ]);

        OrderItem::where(['order_id' => $request->id, 'user_id' => Auth::user()->id])->update([
            'status' => $request->status
        ]);
        $order = Order::where(['id' => $request->id])->where('status', '!=', 0)->with(['order_items'])->first();
        $status_average = 0;
        foreach($order->order_items as $item) {
            $status_average += $item->status;
        }
        $status_average = $status_average/count($order->order_items);
        if ($status_average < 3) {
            $order->status = 2;
            $order->save();
        } else if ($status_average >= 3) {
            $order->status = 3;
            $order->save();
        }
        return redirect('/admin/store/orders');
    }

    

}
