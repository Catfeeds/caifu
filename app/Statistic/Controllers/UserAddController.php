<?php

namespace App\Statistic\Controllers;

use Illuminate\Http\Request;
use App\Statistic\Models\Order;
use App\Statistic\Models\StatDaily;
use App\Statistic\Models\Common;
use App\Statistic\Models\ClubJoin;
use Illuminate\Support\Facades\DB;
use App\Statistic\Models\AreaUser;
use App\Statistic\Models\StatUsers;
use App\Statistic\Models\UserRecommendLog;
use App\Statistic\Models\Club;
use Maatwebsite\Excel\Facades\Excel;

class UserAddController extends Controller{

    public function index(Request $request){



            $rows = StatUsers::getRows();
        return view('/statistic/user-add/index',[
            'rows' => $rows,
            ]);
    }

    public function searchUserChart(Request $request){

        $field = $request->field;//类型--哪个字段数据
        $unit = $request->unit;//单位，日，月，年
        $beginTime = $request->begin_time;//开始时间
        $endTime = $request->end_time;//结束时间
        if(!$field || !$unit ||!$beginTime || !$endTime){
            return Common::jsonResponse(-1,'参数缺失');
        }
        if(!in_array($field, ['user_num','recommend_num','club_num','member_num'])){
            return Common::jsonResponse(-1,'参数错误');

        }
        if($endTime < $beginTime){
            return Common::jsonResponse(-1,'结束时间不能小于开始时间');

        }
        if(strtotime($endTime.'-01-01') > time()){
            return Common::jsonResponse(-1,'结束时间不能大于当前时间');

        }
        switch ($unit){
            case 'month':
                $month =  StatUsers::getMonthNum($beginTime, $endTime);
                if($month + 1 > 24){
                    return Common::jsonResponse(-1,'只能选择24个月内的时间段');

                }
                $beginTime = strtotime($beginTime);//开始时间
                $endTime = strtotime($endTime.'+1 month');

            break;
            case 'year':
                $beginTime = strtotime($beginTime.'-01-01');
                $endTime = strtotime($endTime.'-01-01'.'+1 year');


            break;
            default:
                $beginTime = strtotime($beginTime);//开始时间
                $endTime = strtotime($endTime) + 86400;
                if($endTime - $beginTime > 90 * 86400 ){
                    return Common::jsonResponse(-1,'只能选择90天内的时间段');
                }
            break;
        }

        $result = StatUsers::getChartData($field, $unit, $beginTime, $endTime);
        return Common::jsonResponse(0,'',$result);
    }


    public function reset(Request $request){

        $time = $request->time;
        if($time){

            $time = strtotime($time);
            if($time >= time()){
                return Common::jsonResponse(-1,'统计时间不能大于当前时间');
            }

        }
        $endTime = strtotime(date('Y-m-d',time()));
        $recommendData = UserRecommendLog::getRecommendData($time,$endTime);//每天的推荐人数
        $userAddData = Order::getUserAdd($time,$endTime);//新增用户
        $clubUserData = ClubJoin::getClubData($time,$endTime);
        $recommendMinDate = key($recommendData);//最小时间
        $userAddDataMinDate = key($userAddData);
        $clubUserDataMinDate = key($clubUserData);
        if(!$time){
            $minTimeArray = [$userAddDataMinDate,$recommendMinDate,$clubUserDataMinDate];
            sort($minTimeArray);
            $time = strtotime($minTimeArray[0]);
        }
        $insertData = [];
        for ($i = $time;$i < $endTime;){
            $key = date('Y-m-d',$i);
            $insertData[$i]['date'] = $i;
            $insertData[$i]['user_num'] = 0;
            $insertData[$i]['recommend_num'] = 0;
            $insertData[$i]['club_num'] = 0;
            $insertData[$i]['member_num'] = 0;
            $insertData[$i]['created_at'] = time();

            if(isset($userAddData[$key])){
                $insertData[$i]['user_num'] += $userAddData[$key];

            }
            if(isset($recommendData[$key])){

                $insertData[$i]['recommend_num'] += $recommendData[$key];


            }
            if(isset($clubUserData[$key])){
                $insertData[$i]['club_num'] = $clubUserData[$key]['master'];
                $insertData[$i]['member_num'] = $clubUserData[$key]['staff'];
            }




            $i += 86400;
        }
        DB::beginTransaction();
        DB::table('stat_users')->delete();
        if(!empty($insertData)){
            $insertData = array_values($insertData);
            $result = DB::table('stat_users')->insert($insertData);

        }
        DB::commit();

        return Common::jsonResponse(0,'');

    }


    public function export(){
        $rows = StatUsers::getRows();
        $result[] = ['','用户数','推荐人数','合作社数','社员人数'];
        $result[] = [
            '昨日新增',
            $rows['yesterday']['user_num'],
            $rows['yesterday']['recommend_num'],
            $rows['yesterday']['club_num'],
            $rows['yesterday']['member_num']

        ];
        $result[] = [
            '本周累计',
            $rows['currentWeek']['user_num'],
            $rows['currentWeek']['recommend_num'],
            $rows['currentWeek']['club_num'],
            $rows['currentWeek']['member_num']

        ];
        $result[] = [
            '年度累计',
            $rows['currentYear']['user_num'],
            $rows['currentYear']['recommend_num'],
            $rows['currentYear']['club_num'],
            $rows['currentYear']['member_num']

        ];
        $result[] = [
            '历史累计',
            $rows['all']['user_num'],
            $rows['all']['recommend_num'],
            $rows['all']['club_num'],
            $rows['all']['member_num']

        ];

        Excel::create('用户新增数据',function($excel) use ($result){

            $excel->sheet('score', function($sheet) use ($result){
                $sheet->setWidth(array(
                    'A'     =>  14,
                    'B'     =>  14,
                    'C'     =>  14,
                    'D'     =>  14,
                    'E'     =>  14,

                ));
                $sheet->rows($result);

            });

        })->export('xls');
    }


}