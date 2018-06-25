<?php

namespace App\Statistic\Controllers;

use Illuminate\Http\Request;
use App\Statistic\Models\Order;

class OrderController extends Controller{

    public function index(Request $request){

        $where = [];
        if($request->status){
            $where[] = ['a.status','=',trim($request->status)];
        }
        if($request->model_name){
            $where[] = ['a.model_name','=',trim($request->model_name)];
        }
        if($request->username){
            $where[] = ['b.name','like','%'.trim($request->username).'%'];
        }

        if($request->mobile){
            $where[] = ['c.mobile','like','%'.trim($request->mobile).'%'];

        }
        if($request->recommend_name){
            $where[] = ['f.name','=',trim($request->recommend_name)];
        }
        if($request->recommend_mobile){
            $where[] = ['h.mobile','like','%'.trim($request->recommend_mobile).'%'];
        }
        if($request->sn){
            $where[] = ['a.sn','=',trim($request->sn)];

        }
        if($request->club_id){
            $where[] = ['i.club_id','=',trim($request->club_id)];

        }
        if($request->order_begin_time){
            $where[] = ['a.begin_time','>=',strtotime($request->order_begin_time)];
        }
        if($request->order_end_time){
            $where[] = ['a.begin_time','<',strtotime($request->order_end_time) + 86400];

        }
        if($request->stop_begin_time){
            $where[] = ['a.stop_time','>=',strtotime($request->stop_begin_time)];

        }
        if($request->stop_end_time){
            $where[] = ['a.stop_time','<',strtotime($request->stop_end_time) + 86400];

        }
        if($request->name){
            $where[] = ['d.name','=',trim($request->name)];
        }else if($request->name1){
            $where[] = ['d.name1','=',trim($request->name1)];
        }else if($request->name2){
            $where[] = ['d.name2','=',trim($request->name2)];
        }else if($request->name3){
            $where[] = ['d.name3','=',trim($request->name3)];
        }
        $request->flash();
        $rows = Order::getRows($where,TRUE,20);
        $rows->appends($_REQUEST);

        return view('/statistic/order/index',['rows' => $rows,'orderStatus' => Order::$getStatus,'productType' => Order::$getModelName]);
    }


}