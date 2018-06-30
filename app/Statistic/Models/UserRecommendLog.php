<?php

namespace App\Statistic\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class UserRecommendLog extends Model{

    protected $table = 'user_recommend_log';

    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     *
     * @return number[] 返回每天的推荐人数
     */
    public static function getRecommendData($time = null,$endTime = null){


        $query = self::select(['created_at','user_id']);


        if($endTime){
            $query->where('created_at','<',$endTime);
        }
        $query->groupBy('user_id');
        $query->orderBy('created_at','asc');
        $result = $query->get()->toArray();
        $rows = [];

        if(!empty($result)){

            foreach ($result as $v){
                $date = date('Y-m-d',$v['created_at']);
                if($time && $v['created_at'] < $time){
                    continue;
                }
                if(!isset($rows[$date])){
                    $rows[$date] = 0;
                }
                $rows[$date] += 1;
            }
        }
        return $rows ;
    }

}