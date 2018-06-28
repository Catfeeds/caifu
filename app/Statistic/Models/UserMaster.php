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

        $query = DB::table('stat_user_club')->select(
                'id','user_id','phone as mobile','created_at',
                'username','idcard_number',
                'club_id','join_club_time',
                'club_name','club_user_id',
                'o_group', 'large_area', 'department', 'area', 'project'
            );
            if(!empty($where)){
                $query->where($where);
            }
            if($isPage){
                return $query->paginate($pageSize);

            }
            return $query->get();
    }

    public static function getUserList($time = []){

        $query = DB::table('user_master as a')->select(
                'a.id','a.mobile','a.created_at',
                'b.name','b.idcard_number'
            )
            ->leftJoin('user_idcard as b','a.id','=','b.user_id');
        $query->where(['a.deleted' => 0]);
        if($time){
            $query->where([['a.created_at','>=',strtotime($time)]]);
        }
        return $query->get()->toArray();
    }
    /**
     *
     * @param array|string $userId 用户ID
     * @return 返回用户对应的合作社信息
     */
    public static function getClubList($userId = []){
        $query = DB::table('club_join as c')->select(
            'c.user_id','c.club_id','c.created_at as join_club_time','c.status',
            'd.name as club_name','d.user_id as president_id'
        )
        ->leftJoin('club as d','c.club_id','=','d.id');
        if(!empty($userId)){
            $query->whereIn('c.user_id',$userId);
        }
        $query->where(['c.status' => 1]);
        $result = $query->get()->toArray();
        if(!empty($result)){
            foreach ($result as $k => $v){
                $rows[$v->user_id]['user_id'] = $v->user_id;
                $rows[$v->user_id]['club_id'] = $v->club_id?$v->club_id:0;
                $rows[$v->user_id]['join_club_time'] = $v->join_club_time?$v->join_club_time:0;
                $rows[$v->user_id]['status'] = $v->status;
                $rows[$v->user_id]['club_name'] = $v->club_name?$v->club_name:'';
                $rows[$v->user_id]['president_id'] = $v->president_id?$v->president_id:0;

            }
            return $rows;
        }
        return [];
    }
    /**
     *
     * @param array|string $userId 用户ID
     * @return 返回用户对应的订单组织架构信息
     */
    public static function getOrganizeList($userId = []){
        $query = DB::table('order_master as e')->select(
            'e.user_id','e.community_code',
            'f.name4', 'f.name3', 'f.name2', 'f.name1', 'f.name as project_name'
          )
          ->leftJoin('organize_xls as f','e.community_code','=','f.uuid');
        if(!empty($userId)){
            $query->whereIn('e.user_id',$userId);
        }
        $query->whereNotIn('e.status',[0,500]);
        $query->groupBy('e.user_id');
        $result = $query->get()->toArray();
        if(!empty($result)){
            foreach ($result as $k => $v){
                $rows[$v->user_id]['user_id'] = $v->user_id;
                $rows[$v->user_id]['community_code'] = $v->community_code?$v->community_code:'';
                $rows[$v->user_id]['name4'] = $v->name4?$v->name4:'';
                $rows[$v->user_id]['name3'] = $v->name3?$v->name3:'';
                $rows[$v->user_id]['name2'] = $v->name2?$v->name2:'';
                $rows[$v->user_id]['name1'] = $v->name1?$v->name1:'';
                $rows[$v->user_id]['name'] = $v->project_name?$v->project_name:'';


            }
            return $rows;
        }
        return [];

    }




}