<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index(){
        $pageTitle = "Orders List";
        $orders = Order::with(['products', 'orderGroup', 'user'])->orderBy('created_at','desc')->paginate(getPaginate());
        return view('admin.orders.index',compact('orders','pageTitle'));
    }

    public function orderDetail($id){
        $pageTitle = "Order Details";
        $orderDetails = Order::with(['products', 'products.productImages', 'orderGroup', 'user'])->find($id);
        return view('admin.orders.order_details',compact('orderDetails','pageTitle'));

    }

    public function orderApprove(Request $request, $id){

        $order = Order::find($id);
        $order->status = $request->status;
        $order->status = $request->status;
        $order->save();

        $customer = $order->user_id != 0 ? User::find($order->user_id) : (object)[
            'email' => @$order->orderGroup->email,
            'fullname' => 'Valued Customer',
            'username' => 'Customer',
            'firstname' => 'Valued Customer',
            'lastname' => '',
        ];

        if (!empty($customer->email)) {
            notify($customer, 'ORDER_ON_PROCESSING_CONFIRMATION', [
                'order_number' => $order->order_number ?? optional($order->orderGroup)->order_code ?? 'N/A',
                'amount' => showAmount($order->total_amount ?? $order->product_price ?? 0),
            ]);
        }

        if($order->status == 2){

            $notify[] = ['success', 'Product has been  Shipped successfully'];
            return to_route('admin.orders.index')->withNotify($notify);

        }else{
            $notify[] = ['success', 'Product has been  Delivered successfully'];
            return to_route('admin.orders.index')->withNotify($notify);
        }

    }
}
