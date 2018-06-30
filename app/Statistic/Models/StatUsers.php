<?php

namespace App\Statistic\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class StatUsers extends Model{

    protected $table = 'stat_users';

    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * @desc 返回用户新增-表数据
     */
    public static function getRows(){


        $query = self::select([
            'date','user_num','recommend_num','club_num','member_num'

        ]);

        $result = $query->get()->toArray();
        $defaultData = [
            'user_num' => 0,
            'recommend_num' => 0,
            'club_num' => 0,
            'member_num' => 0,


        ];
        $data['yesterday'] = $defaultData;//昨天
        $data['currentWeek'] = $defaultData;//本周
        $data['currentYear'] = $defaultData;//年度
        $data['all'] = $defaultData;//历史
        $yesterday = date('Y-m-d',time() - 86400);
        //得到本周开始的时间
        $weekBeginTime = ('1' == date('w')) ? strtotime('Sunday', time()) : strtotime('last Sunday', time());

        //得到本周末最后的时间
        $weekEndTime = strtotime('Saturday', time());
        $currentMonth = date('Y-m',time());
        $currentYear = date('Y',time());
        if(!empty($result)){

            foreach ($result as $v){
                $day = date('Y-m-d',$v['date']);
                $year = date('Y',$v['date']);

                if($yesterday == $day){//若是昨天的数据

                    $data['yesterday']['user_num'] += $v['user_num']?$v['user_num']:0;
                    $data['yesterday']['recommend_num'] += $v['recommend_num']?$v['recommend_num']:0;
                    $data['yesterday']['club_num'] += $v['club_num']?$v['club_num']:0;
                    $data['yesterday']['member_num'] += $v['member_num']?$v['member_num']:0;


                }
                if($v['date'] >= $weekBeginTime && $v['date'] < $weekEndTime){//若是本周的数据
                    $data['currentWeek']['user_num'] += $v['user_num']?$v['user_num']:0;
                    $data['currentWeek']['recommend_num'] += $v['recommend_num']?$v['recommend_num']:0;
                    $data['currentWeek']['club_num'] += $v['club_num']?$v['club_num']:0;
                    $data['currentWeek']['member_num'] += $v['member_num']?$v['member_num']:0;

                }
                if($currentYear == $year){//若是年度的数据
                    $data['currentYear']['user_num'] += $v['user_num']?$v['user_num']:0;
                    $data['currentYear']['recommend_num'] += $v['recommend_num']?$v['recommend_num']:0;
                    $data['currentYear']['club_num'] += $v['club_num']?$v['club_num']:0;
                    $data['currentYear']['member_num'] += $v['member_num']?$v['member_num']:0;


                }

                $data['all']['user_num'] += $v['user_num']?$v['user_num']:0;
                $data['all']['recommend_num'] += $v['recommend_num']?$v['recommend_num']:0;
                $data['all']['club_num'] += $v['club_num']?$v['club_num']:0;
                $data['all']['member_num'] += $v['member_num']?$v['member_num']:0;



            }

        }
        return $data;
    }
    /**
     *
     * @param string $field 查询字段
     * @param string $unit 单位
     * @param integer $beginTime 开始时间
     * @param integer $endTime 结束时间
     * @return array 返回对应的用户新增-对应字段的数据的报表
     */
    public static function getChartData($field,$unit,$beginTime,$endTime){
        $query = self::select(['date']);
        $query->addSelect($field);
        $query->whereBetween('date',[$beginTime,$endTime]);
        $result = $query->get()->toArray();
        $rows = [];
        if(!empty($result)){

            foreach ($result as $v){
                switch ($unit){
                    case 'day':
                        $key = date('Y-m-d',$v['date']);
                    break;
                    case 'month':
                        $key = date('Y-m',$v['date']);
                    break;
                    case 'year':
                        $key = date('Y',$v['date']);
                    break;
                }
                if(!isset($rows[$key])){
                    $rows[$key]['time'] = $key;
                    $rows[$key]['num'] = 0;
                }
                $rows[$key]['num'] += $v[$field];


            }
        }
        if(!empty($rows)){
            $rows = array_values($rows);
        }
        return $rows;

    }

    /**
     *
     * @param date $beginTime 开始时间
     * @param date $endTime 结束时间
     * @param string $tags 切割线
     * @return number 返回 相差的月份数量
     */
    public static function getMonthNum($beginTime,$endTime,$tags = '-'){
        $beginTime = explode($tags,$beginTime);
        $endTime = explode($tags,$endTime);
        return abs($endTime[0] - $beginTime[0]) * 12 + abs($endTime[1] - $beginTime[1]);
    }
}