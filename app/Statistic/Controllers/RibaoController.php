<?php

namespace App\Statistic\Controllers;

use Illuminate\Http\Request;
use App\Statistic\Models\Order;
use App\Statistic\Models\StatDaily;
use App\Statistic\Models\Common;
use App\Statistic\Models\ClubJoin;
use Illuminate\Support\Facades\DB;

class RibaoController extends Controller{

    public function index(Request $request){


        $rows = StatDaily::getRows();
        return view('/statistic/ribao/index',['rows' => $rows]);
    }

    /**
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse 重新统计日报数据
     */
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
        $insertData = $this->getInsertData($time);
        DB::beginTransaction();
        DB::table('stat_daily')->delete();
        if(!empty($insertData)){
            $insertData = array_values($insertData);
            $result = DB::table('stat_daily')->insert($insertData);

        }
        DB::commit();

        return Common::jsonResponse(0,'');

    }
    /**
     *
     * @param integer $time 统计时间
     * @return \Illuminate\Http\JsonResponse 定时统计上一天的日报数据
     */
    public function addLastDay($time){
        $insertData = $this->getInsertData($time);
        DB::beginTransaction();
        if(!empty($insertData)){
            $insertData = array_values($insertData);
            $result = DB::table('stat_daily')->insert($insertData);

        }
        DB::commit();

        return Common::jsonResponse(0,'');
    }

    private function getInsertData($time){

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
        return $insertData;
    }

}