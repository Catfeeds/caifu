<?php

namespace App\Statistic\Controllers;

use Illuminate\Http\Request;
use App\Statistic\Models\Order;
use App\Statistic\Models\StatDaily;
use App\Statistic\Models\Common;
use App\Statistic\Models\ClubJoin;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

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

    public function export(Request $request){
        $rows = StatDaily::getRows();
        $result[] = ['','冲抵','','','','资金端','','资产端','','新增状况',''];
        $result[] = ['数据\时间','物业宝（万元）','停车宝（万元）','冲抵总金额（万元）','冲抵总单数	','交易额（万元）','单数','交易额（万元）','单数','社长人数','社员人数'];
        $result[] = [
            '昨日数据',
            sprintf("%.2f",$rows['yesterday']['property_fee']/10000),
            sprintf("%.2f",$rows['yesterday']['parking_fee']/10000),
            sprintf("%.2f",$rows['yesterday']['offset_fee']/10000),
            $rows['yesterday']['offset_num'],
            sprintf("%.2f",$rows['yesterday']['investment_amounts']/10000),
            $rows['yesterday']['investment_num'],
            sprintf("%.2f",$rows['yesterday']['assets_amounts']/10000),
            $rows['yesterday']['assets_num'],
            $rows['yesterday']['manager_num'],
            $rows['yesterday']['member_num']
        ];
        $result[] = [
            '本月累计',
            sprintf("%.2f",$rows['currentMonth']['property_fee']/10000),
            sprintf("%.2f",$rows['currentMonth']['parking_fee']/10000),
            sprintf("%.2f",$rows['currentMonth']['offset_fee']/10000),
            $rows['currentMonth']['offset_num'],
            sprintf("%.2f",$rows['currentMonth']['investment_amounts']/10000),
            $rows['currentMonth']['investment_num'],
            sprintf("%.2f",$rows['currentMonth']['assets_amounts']/10000),
            $rows['currentMonth']['assets_num'],
            $rows['currentMonth']['manager_num'],
            $rows['currentMonth']['member_num']
        ];
        $result[] = [
            '年度累计',
            sprintf("%.2f",$rows['currentYear']['property_fee']/10000),
            sprintf("%.2f",$rows['currentYear']['parking_fee']/10000),
            sprintf("%.2f",$rows['currentYear']['offset_fee']/10000),
            $rows['currentYear']['offset_num'],
            sprintf("%.2f",$rows['currentYear']['investment_amounts']/10000),
            $rows['currentYear']['investment_num'],
            sprintf("%.2f",$rows['currentYear']['assets_amounts']/10000),
            $rows['currentYear']['assets_num'],
            $rows['currentYear']['manager_num'],
            $rows['currentYear']['member_num']
        ];
        $result[] = [
            '历史累计',
            sprintf("%.2f",$rows['all']['property_fee']/10000),
            sprintf("%.2f",$rows['all']['parking_fee']/10000),
            sprintf("%.2f",$rows['all']['offset_fee']/10000),
            $rows['all']['offset_num'],
            sprintf("%.2f",$rows['all']['investment_amounts']/10000),
            $rows['all']['investment_num'],
            sprintf("%.2f",$rows['all']['assets_amounts']/10000),
            $rows['all']['assets_num'],
            $rows['all']['manager_num'],
            $rows['all']['member_num']
        ];
        Excel::create('日报数据',function($excel) use ($result){

            $excel->sheet('score', function($sheet) use ($result){
                $sheet->setWidth(array(
                    'A'     =>  14,
                    'B'     =>  14,
                    'C'     =>  14,
                    'D'     =>  14,
                    'E'     =>  14,
                    'F'     =>  14,
                    'G'     =>  14,
                    'H'     =>  14,
                    'I'     =>  14,
                    'J'     =>  14,
                    'K'     =>  14,
                ));
                $sheet->mergeCells('B1:E1');
                $sheet->mergeCells('F1:G1');
                $sheet->mergeCells('H1:I1');
                $sheet->mergeCells('J1:K1');


                $sheet->rows($result)->setFontSize(12);

            });

        })->export('xls');
    }

}