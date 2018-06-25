<?php

namespace App\Statistic\Controllers;

use Illuminate\Http\Request;
use App\Statistic\Models\Order;
use App\Statistic\Models\UserMaster;

class UserCooperativeController extends Controller{

    public function index(Request $request){
//         $request = request()->all();
        $where = [];
        if($request->user_id){
            $where[] = ['a.id','=',trim($request->user_id)];
        }
        if($request->username){
            $where[] = ['b.name','like','%'.trim($request->username).'%'];
        }

        if($request->mobile){
            $where[] = ['a.mobile','like','%'.trim($request->mobile).'%'];

        }

        if($request->club_name){
            $where[] = ['d.name','like','%'.trim($request->club_name).'%'];

        }
        if($request->club_id){
            $where[] = ['d.id','=',trim($request->club_id)];

        }
        if($request->user_create_time){
            $where[] = ['a.created_at','>=',strtotime($request->user_create_time)];
        }
        if($request->user_end_time){
            $where[] = ['a.created_at','<',strtotime($request->user_end_time) + 86400];

        }
        if($request->club_create_time){
            $where[] = ['c.created_at','>=',strtotime($request->club_create_time)];

        }
        if($request->club_end_time){
            $where[] = ['c.created_at','<',strtotime($request->club_end_time) + 86400];

        }
        if($request->name){
            $where[] = ['f.name','=',trim($request->name)];
        }else if($request->name1){
            $where[] = ['f.name1','=',trim($request->name1)];
        }else if($request->name2){
            $where[] = ['f.name2','=',trim($request->name2)];
        }else if($request->name3){
            $where[] = ['f.name3','=',trim($request->name3)];
        }
        $request->flash();
        $rows = UserMaster::getRows($where,true,20);
        $rows->appends($_REQUEST);
        return view('/statistic/user-cooperative/index',['rows' => $rows]);
    }


}