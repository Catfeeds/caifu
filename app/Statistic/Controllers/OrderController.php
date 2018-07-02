<?php

namespace App\Statistic\Controllers;

use Illuminate\Http\Request;
use App\Statistic\Models\Order;
use App\Statistic\Models\Common;
use App\Statistic\Models\Organize;

class OrderController extends Controller{

    public function index(Request $request){

        $where = [];
        if($request->status){
            $where[] = ['a.status','=',trim($request->status)];
        }
        if($request->model_name){
            $where[] = ['a.model_name','=',trim($request->model_name)];
        }
        if($request->username){
            $where[] = ['b.name','like','%'.trim($request->username).'%'];
        }

        if($request->mobile){
            $where[] = ['c.mobile','like','%'.trim($request->mobile).'%'];

        }
        if($request->recommend_name){
            $where[] = ['f.name','=',trim($request->recommend_name)];
        }
        if($request->recommend_mobile){
            $where[] = ['h.mobile','like','%'.trim($request->recommend_mobile).'%'];
        }
        if($request->sn){
            $where[] = ['a.sn','=',trim($request->sn)];

        }
        if($request->club_id){
            $where[] = ['i.club_id','=',trim($request->club_id)];

        }
        if($request->order_begin_time){
            $where[] = ['a.begin_time','>=',strtotime($request->order_begin_time)];
        }
        if($request->order_end_time){
            $where[] = ['a.begin_time','<',strtotime($request->order_end_time) + 86400];

        }
        if($request->stop_begin_time){
            $where[] = ['a.stop_time','>=',strtotime($request->stop_begin_time)];

        }
        if($request->stop_end_time){
            $where[] = ['a.stop_time','<',strtotime($request->stop_end_time) + 86400];

        }
        if($request->name){
            $where[] = ['d.name','=',trim($request->name)];
        }else if($request->name1){
            $where[] = ['d.name1','=',trim($request->name1)];
        }else if($request->name2){
            $where[] = ['d.name2','=',trim($request->name2)];
        }else if($request->name3){
            $where[] = ['d.name3','=',trim($request->name3)];
        }
        $request->flash();
        $rows = Order::getRows($where,TRUE,20);
        $rows->appends($_REQUEST);

        return view('/statistic/order/index',['rows' => $rows,'orderStatus' => Order::$getStatus,'productType' => Order::$getModelName]);
    }


    public function editOrganize(Request $request){

        $o_group = $request->o_group;
        $large_area = $request->large_area;
        $department = $request->department;
        $area = $request->area;
        $project = $request->project;
        $id = $request->id;
        if(!$o_group || !$large_area || !$department || !$area || !$project || !$id){
            return Common::jsonResponse(-1,'参数缺失');
        }
        $model = Order::find($id);
        if(empty($model)){
            return Common::jsonResponse(1404,'该记录不存在');
        }
        $result = Organize::select(['uuid'])->where(['name3' => $large_area,'name2' => $department,'name1' => $area,'name' => $project])->get()->toArray();
        if(empty($result)){
            return Common::jsonResponse(-1,'该组织架构不存在');
        }
        $model->community_code = $result[0]['uuid'];
        $res = $model->save();
        if($res){
            return Common::jsonResponse();
        }
        return Common::jsonResponse(-1,'系统错误');
    }

}