<?php
namespace App\Statistic\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class ClubJoin extends Model{

    protected $table = 'club_join';

    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;


    /**
     *
     * @param integer $time 开始时间
     * @return array|number 返回该时段内的社长/社员的数量
     */
    public static function getClubData($time){

       $result = DB::table('club_join as a')->select(
            'a.user_id','b.user_id as masterId','a.created_at'
        )
        ->leftJoin('club as b','a.club_id','=','b.id')
        ->where(['a.status' => 1])
        ->where('a.created_at','>=',$time)
        ->get()
        ->toArray();
        $rows = [];
        if(!empty($result)){
            foreach ($result as $v){
                if(!isset($rows[date('Y-m-d',$v->created_at)])){
                    $rows[date('Y-m-d',$v->created_at)]['master'] = 0;//社长
                    $rows[date('Y-m-d',$v->created_at)]['staff'] = 0;//社员
                }
                if($v->masterId == $v->user_id){//社长
                    $rows[date('Y-m-d',$v->created_at)]['master'] += 1;
                }else{
                    $rows[date('Y-m-d',$v->created_at)]['staff'] += 1;

                }

            }
        }
        return $rows;
    }

}
