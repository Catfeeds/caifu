<?php
namespace App\Statistic\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Club extends Model{

    protected $table = 'club';

    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     *
     * @param integer $time 开始时间
     * @return number[] 返回合作社各时间的数量
     */
    public static function getClubCount($time = null){

            $query = self::select(['id','created_at'])->where(['status' => 0]);
            if($time){
                $query->where('created_at','>=',$time);
            }
            $result = $query->get()->toArray();
            $rows = [];
            if(!empty($result)){

                foreach ($result as $v){
                    $date = date('Y-m-d',$v['created_at']);
                    if(!isset($rows[$date])){
                        $rows[$date] = 0;
                    }
                    $rows[$date] += 1;
                }
            }
            return $rows ;
    }




}
