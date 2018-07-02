<?php

namespace App\Statistic\Controllers;

use Illuminate\Http\Request;
use App\Statistic\Models\Order;
use App\Statistic\Models\StatDaily;
use App\Statistic\Models\Common;
use App\Statistic\Models\ClubJoin;
use Illuminate\Support\Facades\DB;
use App\Statistic\Models\StatClub;

class CooperativeController extends Controller{

    public function index(Request $request){

        $where = [];

        if($request->name){
            $where[] = ['o_group','=',trim($request->name4)];
            $where[] = ['large_area','=',trim($request->name3)];
            $where[] = ['department','=',trim($request->name2)];
            $where[] = ['area','=',trim($request->name1)];
            $where[] = ['project','=',trim($request->name)];
        }else if($request->name1){
            $where[] = ['o_group','=',trim($request->name4)];

            $where[] = ['large_area','=',trim($request->name3)];
            $where[] = ['department','=',trim($request->name2)];
            $where[] = ['area','=',trim($request->name1)];
        }else if($request->name2){
            $where[] = ['o_group','=',trim($request->name4)];

            $where[] = ['large_area','=',trim($request->name3)];
            $where[] = ['department','=',trim($request->name2)];
        }else if($request->name3){
            $where[] = ['o_group','=',trim($request->name4)];

            $where[] = ['large_area','=',trim($request->name3)];
        }
        if($request->begin_time){
            $where[] = ['created_at','>=',strtotime($request->begin_time)];
        }
        if($request->end_time){
            $where[] = ['created_at','<',strtotime($request->end_time) + 86400];

        }
        if($request->member_begin){
            $where[] = ['member','>=',$request->member_begin];
        }
        if($request->member_end){
            $where[] = ['member','<=',$request->member_end];

        }
        if($request->investment_fee_begin){
            $where[] = ['investment_fee','>=',$request->investment_fee_begin];
        }
        if($request->investment_fee_end){
            $where[] = ['investment_fee','<=',$request->investment_fee_end];

        }
        if($request->username){
            $where[] = ['username','like','%'.trim($request->username).'%'];

        }
        if($request->club_name){
            $where[] = ['name','like','%'.trim($request->club_name).'%'];

        }
        if($request->mobile){
            $where[] = ['mobile','like','%'.trim($request->mobile).'%'];

        }
        if($request->club_id){
            $where[] = ['club_id','=',trim($request->club_id)];

        }
        $field = [
            'club_id','name','created_at','username','mobile','member','investment_person','investment_fee','annualized_fee','offset_fee',
            'o_group','large_area','department','area','project'
        ];
        $request->flash();
        $rows = StatClub::getRows('*',$where,true);
        $rows->appends($_REQUEST);
        return view('/statistic/cooperative/index',['rows' => $rows]);
    }


    public function reset(){



        $result = StatClub::reset();
        if($result){
            return Common::jsonResponse(0,'');

        }
        return Common::jsonResponse(-1,'系统错误');

    }


}