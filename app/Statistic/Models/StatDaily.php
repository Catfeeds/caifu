<?php

namespace App\Statistic\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class StatDaily extends Model{

    protected $table = 'stat_daily';

    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * @desc 返回日报-kpi完成情况统计表数据
     */
    public static function getRows(){


        $query = self::select([
            'date','property_fee','parking_fee','offset_fee','offset_num','investment_amounts',

            'investment_num','assets_amounts','assets_num','manager_num','member_num'

        ]);

        $result = $query->get()->toArray();
        $defaultData = [
            'property_fee' => 0,
            'parking_fee' => 0,
            'offset_fee' => 0,
            'offset_num' => 0,
            'investment_amounts' => 0,
            'investment_num' => 0,
            'assets_amounts' => 0,
            'assets_num' => 0,
            'manager_num' => 0,
            'member_num' => 0,

        ];
        $data['yesterday'] = $defaultData;//昨天
        $data['currentMonth'] = $defaultData;//本月
        $data['currentYear'] = $defaultData;//年度
        $data['all'] = $defaultData;//历史
        $yesterday = date('Y-m-d',time() - 86400);
        $currentMonth = date('Y-m',time());
        $currentYear = date('Y',time());
        if(!empty($result)){

            foreach ($result as $v){
                $day = date('Y-m-d',$v['date']);
                $month = date('Y-m',$v['date']);
                $year = date('Y',$v['date']);

                if($yesterday == $day){//若是昨天的数据

                    $data['yesterday']['property_fee'] += $v['property_fee']?$v['property_fee']:0;
                    $data['yesterday']['parking_fee'] += $v['parking_fee']?$v['parking_fee']:0;
                    $data['yesterday']['offset_fee'] += $v['offset_fee']?$v['offset_fee']:0;
                    $data['yesterday']['offset_num'] += $v['offset_num']?$v['offset_num']:0;
                    $data['yesterday']['investment_amounts'] += $v['investment_amounts']?$v['investment_amounts']:0;
                    $data['yesterday']['investment_num'] += $v['investment_num']?$v['investment_num']:0;
                    $data['yesterday']['assets_amounts'] += $v['assets_amounts']?$v['assets_amounts']:0;
                    $data['yesterday']['assets_num'] += $v['assets_num']?$v['assets_num']:0;
                    $data['yesterday']['manager_num'] += $v['manager_num']?$v['manager_num']:0;
                    $data['yesterday']['member_num'] += $v['member_num']?$v['member_num']:0;

                }
                if($currentMonth == $month){//若是昨天的数据
                    $data['currentMonth']['property_fee'] += $v['property_fee']?$v['property_fee']:0;
                    $data['currentMonth']['parking_fee'] += $v['parking_fee']?$v['parking_fee']:0;
                    $data['currentMonth']['offset_fee'] += $v['offset_fee']?$v['offset_fee']:0;
                    $data['currentMonth']['offset_num'] += $v['offset_num']?$v['offset_num']:0;
                    $data['currentMonth']['investment_amounts'] += $v['investment_amounts']?$v['investment_amounts']:0;
                    $data['currentMonth']['investment_num'] += $v['investment_num']?$v['investment_num']:0;
                    $data['currentMonth']['assets_amounts'] += $v['assets_amounts']?$v['assets_amounts']:0;
                    $data['currentMonth']['assets_num'] += $v['assets_num']?$v['assets_num']:0;
                    $data['currentMonth']['manager_num'] += $v['manager_num']?$v['manager_num']:0;
                    $data['currentMonth']['member_num'] += $v['member_num']?$v['member_num']:0;

                }
                if($currentYear == $year){//若是昨天的数据
                    $data['currentYear']['property_fee'] += $v['property_fee']?$v['property_fee']:0;
                    $data['currentYear']['parking_fee'] += $v['parking_fee']?$v['parking_fee']:0;
                    $data['currentYear']['offset_fee'] += $v['offset_fee']?$v['offset_fee']:0;
                    $data['currentYear']['offset_num'] += $v['offset_num']?$v['offset_num']:0;
                    $data['currentYear']['investment_amounts'] += $v['investment_amounts']?$v['investment_amounts']:0;
                    $data['currentYear']['investment_num'] += $v['investment_num']?$v['investment_num']:0;
                    $data['currentYear']['assets_amounts'] += $v['assets_amounts']?$v['assets_amounts']:0;
                    $data['currentYear']['assets_num'] += $v['assets_num']?$v['assets_num']:0;
                    $data['currentYear']['manager_num'] += $v['manager_num']?$v['manager_num']:0;
                    $data['currentYear']['member_num'] += $v['member_num']?$v['member_num']:0;


                }

                $data['all']['property_fee'] += $v['property_fee']?$v['property_fee']:0;
                $data['all']['parking_fee'] += $v['parking_fee']?$v['parking_fee']:0;
                $data['all']['offset_fee'] += $v['offset_fee']?$v['offset_fee']:0;
                $data['all']['offset_num'] += $v['offset_num']?$v['offset_num']:0;
                $data['all']['investment_amounts'] += $v['investment_amounts']?$v['investment_amounts']:0;
                $data['all']['investment_num'] += $v['investment_num']?$v['investment_num']:0;
                $data['all']['assets_amounts'] += $v['assets_amounts']?$v['assets_amounts']:0;
                $data['all']['assets_num'] += $v['assets_num']?$v['assets_num']:0;
                $data['all']['manager_num'] += $v['manager_num']?$v['manager_num']:0;
                $data['all']['member_num'] += $v['member_num']?$v['member_num']:0;



            }

        }
        return $data;
    }
    /**
     * @desc 返回某个时间段下的日报数据,默认为所有
     * @param integer $beginTime 开始时间
     * @param integer 结束时间
     */
    public static function getListByDate($beginTime = null,$endTime = null,$field = '*'){

        $query = self::select($field);
        if($beginTime){
            $query->where('date','>=',$beginTime);
        }
        if($endTime){
            $query->where('date','<',$endTime);

        }
        $query->orderBy('date','asc');
        return $query->get()->toArray();
    }
}