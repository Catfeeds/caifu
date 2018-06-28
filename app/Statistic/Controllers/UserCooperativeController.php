<?php

namespace App\Statistic\Controllers;

use Illuminate\Http\Request;
use App\Statistic\Models\Order;
use App\Statistic\Models\UserMaster;
use Illuminate\Support\Facades\DB;
use App\Statistic\Models\Common;

class UserCooperativeController extends Controller{

    public function index(Request $request){
//         $request = request()->all();
        $where = [];
        if($request->user_id){
            $where[] = ['user_id','=',trim($request->user_id)];
        }
        if($request->username){
            $where[] = ['username','like','%'.trim($request->username).'%'];
        }

        if($request->mobile){
            $where[] = ['phone','like','%'.trim($request->mobile).'%'];

        }

        if($request->club_name){

            $where[] = ['club_name','like','%'.trim($request->club_name).'%'];

        }
        if($request->club_id){
            $where[] = ['club_id','=',trim($request->club_id)];

        }
        if($request->user_create_time){
            $where[] = ['created_at','>=',strtotime($request->user_create_time)];
        }
        if($request->user_end_time){
            $where[] = ['created_at','<',strtotime($request->user_end_time) + 86400];

        }
        if($request->club_create_time){
            $where[] = ['join_club_time','>=',strtotime($request->club_create_time)];

        }
        if($request->club_end_time){
            $where[] = ['join_club_time','<',strtotime($request->club_end_time) + 86400];

        }
        if($request->name){
            $where[] = ['large_area','=',trim($request->name3)];
            $where[] = ['department','=',trim($request->name2)];
            $where[] = ['area','=',trim($request->name1)];
            $where[] = ['project','=',trim($request->name)];
        }else if($request->name1){
            $where[] = ['large_area','=',trim($request->name3)];
            $where[] = ['department','=',trim($request->name2)];
            $where[] = ['area','=',trim($request->name1)];
        }else if($request->name2){
            $where[] = ['large_area','=',trim($request->name3)];
            $where[] = ['department','=',trim($request->name2)];
        }else if($request->name3){
            $where[] = ['large_area','=',trim($request->name3)];
        }
        $request->flash();
        $rows = UserMaster::getRows($where,true,20);
        $rows->appends($_REQUEST);


        return view('/statistic/user-cooperative/index',[
            'rows' => $rows,

        ]);
    }
    /**
     * @desc 重新统计
     */
    public function reset(Request $request){
//         set_time_limit(0);         //取消脚本执行延时上限
//         ignore_user_abort(TRUE); //如果客户端断开连接，不会引起脚本abort
        $time = $request->time;

        $userData = UserMaster::getUserList($time);//用户列表
        $idList = [];
        $insertData = [];
        $clubData = UserMaster::getClubList();//合作社
        $organizeData = UserMaster::getOrganizeList();//组织架构
        $begin = time();
        DB::beginTransaction();

        DB::table('stat_user_club')->delete();
        foreach ($userData as $k => $v){

            $club_id = 0;
            $club_user_id = 0;
            $club_name = '';
            $join_club_time = 0;
            $o_group = '';
            $large_area = '';
            $department = '';
            $area = '';
            $project = '';

            if(isset($clubData[$v->id])){
                $club_id = $clubData[$v->id]['club_id'];
                $club_user_id = $clubData[$v->id]['president_id'];
                $club_name = $clubData[$v->id]['club_name'];
                $join_club_time = $clubData[$v->id]['join_club_time'];
            }

            if(isset($organizeData[$v->id])){
                $o_group = $organizeData[$v->id]['name4'];
                $large_area = $organizeData[$v->id]['name3'];
                $department = $organizeData[$v->id]['name2'];
                $area = $organizeData[$v->id]['name1'];
                $project = $organizeData[$v->id]['name'];

            }

            $insertData[] = [
                'user_id' => $v->id,'username' => $v->name?$v->name:'','phone' => $v->mobile?$v->mobile:'',
                'idcard_number' => $v->idcard_number?$v->idcard_number:'','created_at' => $v->created_at,
                'club_id' => $club_id,'club_user_id' => $club_user_id,
                'club_name' => $club_name,'join_club_time' => $join_club_time,
                'o_group' => $o_group,'large_area' => $large_area,'department' => $department,
                'area' => $area,'project' => $project
            ];
            if($k%200 == 0 || $k == count($userData)-1){
                DB::table('stat_user_club')->insert($insertData);
                $insertData = [];
            }


        }
        DB::commit();
        return Common::jsonResponse(0,'');
    }
}