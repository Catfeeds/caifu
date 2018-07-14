<?php

namespace App\Statistic\Controllers;

use Illuminate\Http\Request;
use App\Statistic\Models\Order;
use App\Statistic\Models\StatDaily;
use App\Statistic\Models\Common;
use App\Statistic\Models\ClubJoin;
use Illuminate\Support\Facades\DB;
use App\Statistic\Models\AreaUser;
use App\Statistic\Models\Organize;
use Illuminate\Support\Facades\Log;

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
            'flushing' => isset($probabilityData['flushing'])?json_encode($probabilityData['flushing'],true):'',
            'president' => isset($probabilityData['president'])?json_encode($probabilityData['president'],true):''
            ]);
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
        $organizeList = Organize::getAreaUserInfo();
        $orderRows = Order::getAreaUserOrder($time);//冲抵，资金交易数据
        $insertData = [];
        // 1. 初始化
        $ch = curl_init();

        if(!empty($organizeList)){
            foreach ($organizeList as $v){
                $investment_num = 0;
                $flushing_num =  0;
                $recast_num = 0;
                $president_num = 0;
                $referee_num = 0;
                $staff_num = 0;
                if(isset($orderRows[$v['uuid']])){
                    $investment_num = $orderRows[$v['uuid']]['all'];
                    $flushing_num =  $orderRows[$v['uuid']]['flushing'];
                    $recast_num = $orderRows[$v['uuid']]['recast'];
                    $president_num = $orderRows[$v['uuid']]['master'];
                    $referee_num = $orderRows[$v['uuid']]['recommend'];
                }
                $jobList = $this->curlGet($ch, Organize::getJobCount($v['uuid']));
                $owner_num = count($jobList['content']);
                $staffList = $this->curlGet($ch, Organize::getHouseHolds($v['uuid']));
                if($staffList['code'] == 0){
                    $staff_num = $staffList['content']['vdef5'];
                }
                $insertData[] = [
                    'o_group' => $v['name4'],
                    'large_area' => $v['name3'],
                    'department' => $v['name2'],
                    'area' => $v['name1'],
                    'project' => $v['name'],
//                     'owner_num' => Organize::getJobCount($v['uuid']),
//                     'staff_num' => Organize::getHouseHolds($v['uuid']),
                    'owner_num' => $owner_num,
                    'staff_num' => $staff_num,
                    'investment_num' => $investment_num,
                    'flushing_num' => $flushing_num,
                    'recast_num' => $recast_num,
                    'referee_num' => $referee_num,
                    'president_num' => $president_num,

                ];
            }

        }
        // 4. 释放curl句柄
        curl_close($ch);
        DB::beginTransaction();
        DB::table('stat_area_user')->delete();
        if(!empty($insertData)){
            $result = DB::table('stat_area_user')->insert($insertData);

        }
        DB::commit();

        return Common::jsonResponse(0,'');

    }

    public function curlGet($ch,$url){
        // 2. 设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0); //设置header

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        // curl_setopt($ch, CURLOPT_TIMEOUT, 100);
        //    curl_setopt($ch, CURLOPT_TIMEOUT_MS, 1); //设置不用等待
        // 3. 执行并获取HTML文档内容
        $output = curl_exec($ch);
        //var_dump($output);exit;
        if ($output === FALSE) {
            //echo "cURL Error: " . curl_error($ch);
            Log::error('get curl error:' . curl_error($ch));
        }
        return json_decode($output,true);

    }



}