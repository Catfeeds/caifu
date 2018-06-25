<?php

namespace App\Statistic\Controllers;

use App\Statistic\Models\OrganizeKpiTarget;
use Illuminate\Http\Request;
use App\Statistic\Models\Common;

class KpiTargetController extends Controller{

    public function index(Request $request){
        $where = [];

        if($request->year){
            $where[] = ['year','=',$request->year];
        }
        if($request->name){
            $where[] = ['project','=',trim($request->name)];
        }else if($request->name1){
            $where[] = ['area','=',trim($request->name1)];
        }else if($request->name2){
            $where[] = ['department','=',trim($request->name2)];
        }else if($request->name3){
            $where[] = ['large_area','=',trim($request->name3)];
        }
        $request->flash();
        $rows = OrganizeKpiTarget::getRows('*',$where,TRUE,1);
        $rows->appends($_REQUEST);
        return view('/statistic/kpi-target/index',['rows' => $rows,'year' => OrganizeKpiTarget::$getYear]);
    }


    public function edit(){
//         $this->validate(request(), [
//             'id' => 'required',
//             'month12' => 'required'
//         ]);
        $data = request()->all();

        if(!$data['id']){
            return Common::jsonResponse(1001,'参数错误');
        }
        $model = OrganizeKpiTarget::find($data['id']);
        if(empty($model)){
            return Common::jsonResponse(1404,'该记录不存在');
        }
        $model->month01 = $data['month01'];
        $model->month02 = $data['month02'];
        $model->month03 = $data['month03'];
        $model->month04 = $data['month04'];
        $model->month05 = $data['month05'];
        $model->month06 = $data['month06'];
        $model->month07 = $data['month07'];
        $model->month08 = $data['month08'];
        $model->month09 = $data['month09'];
        $model->month10 = $data['month10'];
        $model->month11 = $data['month11'];
        $model->month12 = $data['month12']?$data['month12']:0;
        $model->annual = $data['annual'];
        $res = $model->save();
        return Common::jsonResponse();
    }
}