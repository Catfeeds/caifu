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
use Maatwebsite\Excel\Facades\Excel;

class AreaUserController extends Controller{

    public function index(Request $request){
        $where = $this->getWhere($request);
        $request->flash();

        $field = ['o_group','large_area','department','area','project','owner_num','staff_num','investment_num','flushing_num','recast_num','referee_num','president_num'];
        $rows = AreaUser::getRows($field,$where,true);
        $rows->appends($_REQUEST);
        $probabilityData = AreaUser::getLargeArea();
        return view('/statistic/area-user/index',[
            'rows' => $rows,
            'flushing' => json_encode(isset($probabilityData['flushing'])?$probabilityData['flushing']:[],true),
            'president' => json_encode(isset($probabilityData['president'])?$probabilityData['president']:[],true)
            ]);
    }
    private function getWhere($request){
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
        return $where;
    }

    public function reset(Request $request){

        set_time_limit(0);
        ob_end_clean();
//         header("Connection: close");
//         header("HTTP/1.1 200 OK");
        header("Content-Type: application/json;charset=utf-8");// 如果前端要的是json则添加，默认是返回的html/text
        ob_start();
        echo Common::jsonResponse(0,'');// 输出结果到前端
        $size = ob_get_length();
        header("Content-Length: $size");
        ob_end_flush();
        flush();

        if (function_exists("fastcgi_finish_request")) {
            fastcgi_finish_request(); // 响应完成, 立即返回到前端,关闭连接
        }
        sleep(2);
        ignore_user_abort(true);// 在关闭连接后，继续运行php脚本
        set_time_limit(0);

        $time = $request->time;
        if(!$time){
            $time = strtotime("-1 day");
        }else{
            $time = strtotime($time);
        }
        if($time >= time()){
            return Common::jsonResponse(-1,'统计时间不能大于当前时间');
        }
        Log::info('aaaaaaaaaa');
        exit();
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

    private function curlGet($ch,$url){
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

    public function export(Request $request){
        $where = $this->getWhere($request);

        $result[] = [
            '地区','','','','',
            '用户信息','','','','','','','','',''

        ];
        $result[] = [
            '集团','大区','事业部','片区','项目',
            '业主数','员工数','投资户数','冲抵户数','冲抵覆盖率','复投户数','复投率	','推荐人数','社长数','社长覆盖率'
        ];
        $field = ['o_group','large_area','department','area','project','owner_num','staff_num','investment_num','flushing_num','recast_num','referee_num','president_num'];
        $rows = AreaUser::getRows($field,$where,false);
        $rows = $rows->toArray();
        if(!empty($rows)){
            foreach ($rows as $v){
                $flushingPercent = '';
                $recastPercent = '';
                $staffPercent = '';
                if(!$v['owner_num']){
                    $flushingPercent = (sprintf("%.2f",$v['flushing_num'])*100).'%';
                }else if($v['flushing_num'] && $v['owner_num']){
                    $flushingPercent = (sprintf("%.2f",$v['flushing_num']/$v['owner_num'])*100).'%';
                }
                if(!$v['investment_num']){
                    $recastPercent = (sprintf("%.2f",$v['recast_num'])*100).'%';
                }else if($v['recast_num'] && $v['investment_num']){
                    $recastPercent = (sprintf("%.2f",$v['recast_num']/$v['investment_num'])*100).'%';
                }
                if(!$v['staff_num']){
                    $staffPercent = (sprintf("%.2f",$v['president_num'])*100).'%';
                }else if($v['president_num'] && $v['staff_num']){
                    $staffPercent = (sprintf("%.2f",$v['president_num']/$v['staff_num'])*100).'%';
                }
                $result[] = [
                    $v['o_group'],$v['large_area'],$v['department'],$v['area'],$v['project'],
                    $v['owner_num'],$v['staff_num'],$v['investment_num'],$v['flushing_num'],$flushingPercent,
                    $v['recast_num'],$recastPercent,$v['referee_num'],$v['president_num'],$staffPercent


                ];
            }
        }
        Excel::create('地区用户数据',function($excel) use ($result){

            $excel->sheet('score', function($sheet) use ($result){
                $sheet->mergeCells('A1:E1');
                $sheet->mergeCells('F1:O1');
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
                    'L'     =>  14,
                    'M'     =>  14,
                    'N'     =>  14,
                    'O'     =>  14,

                ));
                $sheet->rows($result)->setFontSize(12);

            });

        })->export('xls');
    }



}