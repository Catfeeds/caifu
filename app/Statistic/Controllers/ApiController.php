<?php

namespace App\Statistic\Controllers;


use App\Statistic\Models\Organize;
use Illuminate\Http\Request;
use App\Statistic\Models\Common;
use App\Statistic\Models\StatDaily;

class ApiController extends Controller{

    public function getOrganize(Request $request){

        $parentField = $request->input('parent_field');
        $parentValue = $request->input('parent_value');
        $childField = $request->input('child_field');

        if(empty($childField)){
            return Common::jsonResponse(1001,'参数缺失');
        }
        $parent = [];
        if($parentField && $parentValue){
            $parent = [
                'field' => $parentField,
                'value' => $parentValue
            ];
        }
        $result = Organize::getChildByParent($parent, $childField);
        return Common::jsonResponse(0,'',$result);
    }

    /**
     * @desc 日报-平台投资金额折线图接口
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStatDaily(Request $request){

        $beginTime = $request->input('begin_time');
        $endTime = $request->input('end_time');
        if(!$beginTime){
            $beginTime = strtotime("-1 month");
            $endTime = strtotime("-1 day");
        }else{
            $beginTime = strtotime($beginTime);
            $endTime = strtotime($endTime) + 86400;
        }

        if($endTime - $beginTime > 90 * 86400 ){
            return Common::jsonResponse(-1,'只能选择90天内的时间段');
        }

        $result = StatDaily::getListByDate($beginTime,$endTime,["date as time","investment_amounts as money"]);
        if(!empty($result)){
            foreach ($result as $k => $v){
                $result[$k]['time'] = date('Y-m-d',$v['time']);
                $result[$k]['money'] = sprintf("%.2f",$v['money']/10000);
            }
        }
        return Common::jsonResponse(0,'',$result);

    }



}