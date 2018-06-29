<?php

namespace App\Statistic\Controllers;

use Illuminate\Http\Request;
use App\Statistic\Models\Order;
use App\Statistic\Models\StatDaily;
use App\Statistic\Models\Common;
use App\Statistic\Models\ClubJoin;
use Illuminate\Support\Facades\DB;
use App\Statistic\Models\AreaUser;

class AreaUserController extends Controller{

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
        $request->flash();

        $field = ['o_group','large_area','department','area','project','owner_num','staff_num','investment_num','flushing_num','recast_num','referee_num','president_num'];
        $rows = AreaUser::getRows($field,$where,true);
        $rows->appends($_REQUEST);
        $probabilityData = AreaUser::getLargeArea();
        return view('/statistic/area-user/index',[
            'rows' => $rows,
            'flushing' => json_encode($probabilityData['flushing'],true),
            'president' => json_encode($probabilityData['president'],true)]);
    }


    public function reset(Request $request){

        $time = $request->time;
        if(!$time){
            $time = strtotime("-1 day");
        }else{
            $time = strtotime($time);
        }
        if($time >= time()){
            return Common::jsonResponse(-1,'统计时间不能大于当前时间');
        }
        $orderRows = Order::getOrderList($time);//冲抵，资金交易数据
        $clubData = ClubJoin::getClubData($time);//社长/社员数量信息
        $endTime = strtotime(date('Y-m-d',time()));
        $insertData = [];
        for ($i = $time;$i < $endTime;){
            $key = date('Y-m-d',$i);
            $insertData[$i]['date'] = $i;
            $insertData[$i]['property_fee'] = 0;
            $insertData[$i]['parking_fee'] = 0;
            $insertData[$i]['offset_fee'] = 0;
            $insertData[$i]['offset_num'] = 0;
            $insertData[$i]['investment_amounts'] = 0;
            $insertData[$i]['investment_num'] = 0;
            $insertData[$i]['manager_num'] = 0;
            $insertData[$i]['member_num'] = 0;
            if(isset($orderRows[$key])){

                    $insertData[$i]['property_fee'] = $orderRows[$key]['advancePropertyAmount'];
                    $insertData[$i]['parking_fee'] = $orderRows[$key]['parkingAmount'];
                    $insertData[$i]['offset_fee'] = $insertData[$i]['property_fee']+$insertData[$i]['parking_fee'];
                    $insertData[$i]['offset_num'] = $orderRows[$key]['advancePropertyCount'] + $orderRows[$key]['parkingCount'];
                    $insertData[$i]['investment_amounts'] = $orderRows[$key]['allAmount'];
                    $insertData[$i]['investment_num'] = $orderRows[$key]['allCount'];



            }
            if(isset($clubData[$key])){
                $insertData[$i]['manager_num'] = $clubData[$key]['master'];
                $insertData[$i]['member_num'] = $clubData[$key]['staff'];
            }


            $i += 86400;
        }
        DB::beginTransaction();
        DB::table('stat_daily')->delete();
        if(!empty($insertData)){
            $insertData = array_values($insertData);
            $result = DB::table('stat_daily')->insert($insertData);

        }
        DB::commit();

        return Common::jsonResponse(0,'');

    }


}