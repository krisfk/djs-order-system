<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{

    public function deleteOrder(Request $request)
    {

        $order_id=$request['order_id'];
        $order = Order::find($order_id);    
        
        if($order->delete())
        {
            return response()->json(['code'=>'200','msg'=>'Order has been deleted']);
        }
        else{
            return response()->json(['code'=>'500','msg'=>'Query error']);
        }
        

    }

    public function allOrders()
    {
        $orders = Order::orderBy('id', 'DESC')->get();
        //->sortByDesc("id");//('admin', '1')->get();
        return response()->json($orders);
        
        // dd(55);
        
    }

    public function editOrder(Request $request)
    {

        // dd(88);
            $order_id = $request['order_id'];
            $order = Order::find($order_id);    
            $order->order_code = isset($request['order_code']) ? $request['order_code'] : '';
            $order->order_type = isset($request['order_type']) ? $request['order_type'] : '';
            $order->tel = isset($request['tel']) ? $request['tel'] : '';
            $order->order_detail = isset($request['order_detail']) ? $request['order_detail'] : '';
            $order->order_date = isset($request['order_date']) ? $request['order_date'] : '';
       
            

            // if(isset($request['password']))
            // {
            //     $user->password= Hash::make($request['password']);
            // }
            
            if($order->save())
            {
                return response()->json(['code'=>'201','msg'=>'Order information has been updated']);
            }
            else
            {
                return response()->json(['code'=>'500','msg'=>'Query error']);
            }
    }

    
    // public function editOrder(Request $request)
    // {
    //     dd('edit');
    //     // order_id
    // }

    public function createOrder(Request $request)
    {
        
        $order = new Order();
      
        $order->order_code = isset($request['order_code']) ? $request['order_code'] : '';
        $order->order_type = isset($request['order_type']) ? $request['order_type'] : '';
        $order->tel = isset($request['tel']) ? $request['tel'] : '';
        $order->order_detail = isset($request['order_detail']) ? $request['order_detail'] : '';
        $order->order_date = isset($request['order_date']) ? $request['order_date'] : '';
        
        if($order->save())
        {
            return response()->json(['code'=>'201','msg'=>'User has been created','last_insert_id' => $order->id]);
        }
        else
        {
            return response()->json(['code'=>'500','msg'=>'Query error']);
        }
        // }

    }
    

    
}