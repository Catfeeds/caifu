<?php

namespace App\Statistic\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class UserMaster extends Model{

    protected $table = 'user_master';

    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;


    public static function getRows($where = [],$isPage = false,$pageSize = 20){

        $query = DB::table('user_master as a')->select(
                'a.id','a.mobile','a.created_at',
                'b.name as username','b.idcard_number',
                'c.club_id','c.created_at as join_club_time','c.status',
                'd.name as club_name','d.user_id as president_id',
                'e.community_code',
                'f.name4', 'f.name3', 'f.name2', 'f.name1', 'f.name as project_name'
            )
            ->leftJoin('user_idcard as b','a.id','=','b.user_id')
            ->leftJoin('club_join as c','a.id','=','c.user_id')
            ->leftJoin('club as d','c.club_id','=','d.id')
            ->join('order_master as e','a.id','=','e.user_id')
            ->join('organize_xls as f','e.community_code','=','f.uuid');
            $query->where(['a.deleted' => 0]);
            if(!empty($where)){
                $query->where($where);
            }
            $query->groupBy('a.id');
            if($isPage){
                return $query->paginate($pageSize);
            }
            return $query->get();
    }





}