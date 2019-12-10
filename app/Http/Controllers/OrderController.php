<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\OrderRequest;
use App\Order;
use Illuminate\Http\Request;

use Carbon\Carbon;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = new Order();

        if($request->type == 1){
            $orders = DB::table('orders')
                ->select('orders.id','users.full_name','products.name','product_price','product_count','order_sum','orders.created_at')
                ->leftJoin('users', 'orders.user_id', '=', 'users.id')
                ->leftJoin('products', 'orders.product_id', '=', 'products.id')
                ->Where('orders.deleted_at', '=', null)
                ->orderBy('orders.created_at','DESC')
                ->get();
        }

        if($request->type == 2) {
            $fromDate = new Carbon('last week');
            $toDate = new Carbon('now');
            $orders = DB::table('orders')
                ->select('orders.id','users.full_name','products.name','product_price','product_count','order_sum','orders.created_at')
                ->leftJoin('users', 'orders.user_id', '=', 'users.id')
                ->leftJoin('products', 'orders.product_id', '=', 'products.id')
                ->whereBetween('orders.created_at', array($fromDate->toDateTimeString(), $toDate->toDateTimeString()) )
                ->Where('orders.deleted_at', '=', null)
                ->orderBy('orders.created_at','DESC')
                ->get();
        }

        if($request->type == 3) {

            $orders = DB::table('orders')
                ->select('orders.id','users.full_name','products.name','product_price','product_count','order_sum','orders.created_at')
                ->leftJoin('users', 'orders.user_id', '=', 'users.id')
                ->leftJoin('products', 'orders.product_id', '=', 'products.id')
                ->whereDate('orders.created_at', Carbon::today())
                ->Where('orders.deleted_at', '=', null)
                ->orderBy('orders.created_at','DESC')
                ->get();
        }

        return response()->json($orders);
    }

    public function search(Request $request)
    {
        $orders = new Order();

        if($request->type == 1){
            $orders = DB::table('orders')
                ->select('orders.id','users.full_name','products.name','product_price','product_count','order_sum','orders.created_at')
                ->leftJoin('users', 'orders.user_id', '=', 'users.id')
                ->leftJoin('products', 'orders.product_id', '=', 'products.id')
                ->Where('products.name', 'like', '%' . $request->search . '%')
                ->Where('orders.deleted_at', '=', null)
                ->orderBy('orders.created_at','DESC')
                ->get();
        }

        if($request->type == 2) {
            $fromDate = new Carbon('last week');
            $toDate = new Carbon('now');
            $orders = DB::table('orders')
                ->select('orders.id','users.full_name','products.name','product_price','product_count','order_sum','orders.created_at')
                ->leftJoin('users', 'orders.user_id', '=', 'users.id')
                ->leftJoin('products', 'orders.product_id', '=', 'products.id')
                ->whereBetween('orders.created_at', array($fromDate->toDateTimeString(), $toDate->toDateTimeString()) )
                ->Where('products.name', 'like', '%' . $request->search . '%')
                ->Where('orders.deleted_at', '=', null)
                ->orderBy('orders.created_at','DESC')
                ->get();
        }

        if($request->type == 3) {

            $orders = DB::table('orders')
                ->select('orders.id','users.full_name','products.name','product_price','product_count','order_sum','orders.created_at')
                ->leftJoin('users', 'orders.user_id', '=', 'users.id')
                ->leftJoin('products', 'orders.product_id', '=', 'products.id')
                ->whereDate('orders.created_at', Carbon::today())
                ->Where('products.name', 'like', '%' . $request->search . '%')
                ->Where('orders.deleted_at', '=', null)
                ->orderBy('orders.created_at','DESC')
                ->get();
        }

        return response()->json($orders);
    }

    public function show(Request $request)
    {
        $order = Order::find($request->order);

        return response()->json($order->load('orderUser', 'orderProduct'));
    }

    public function store(OrderRequest $request)
    {

        $order = new Order;
        $order->user_id = $request->user_id;
        $order->product_id = $request->product_id;
        $order->product_price = $request->product_price;
        $order->product_count = $request->product_count;
        $order->order_sum = $request->order_sum;
        $order->save();

        info("Order id=$order->id created");

        return response()->json(true);
    }


    public function update(OrderRequest $request)
    {

        $order = Order::find($request->order);
        $order->user_id = $request->user_id;
        $order->product_id = $request->product_id;
        $order->product_price = $request->product_price;
        $order->product_count = $request->product_count;
        $order->order_sum = $request->order_sum;

        $order->update();

        info("Order updated");

        return response()->json(true);
    }

    public function destroy(Request $request)
    {
        $order = Order::find($request->order);

        info("Order id=$order->id deleted");

        $order->delete();

        return response()->json(true);
    }
}
