<?php

namespace App\Statistic\Controllers;

use Illuminate\Http\Request;
use App\Statistic\Models\Order;
use App\Statistic\Models\StatDaily;
use App\Statistic\Models\Common;
use App\Statistic\Models\ClubJoin;
use Illuminate\Support\Facades\DB;
use App\Statistic\Models\StatClub;
use App\Statistic\Models\Organize;
use App\Statistic\Models\OrganizeKpiTarget;

class KpiCompleteController extends Controller{

    public function index(Request $request){

        $where = [];
        $unit = $request->unit;//单位，日，月，年
        $beginTime = $request->begin_time;//开始时间
        $endTime = $request->end_time;//结束时间
        $orderWhere = '';
        $kpiWhere = [];
        if($request->name){
            $groupField = 'name';
            $where[] = ['name4','=',trim($request->name4)];
            $where[] = ['name3','=',trim($request->name3)];
            $where[] = ['name2','=',trim($request->name2)];
            $where[] = ['name1','=',trim($request->name1)];
            $where[] = ['name','=',trim($request->name)];
            $orderWhere .= " and name4 = '".trim($request->name4)."'";
            $orderWhere .= " and name3= '".trim($request->name3)."'";
            $orderWhere .= " and name2= '".trim($request->name2)."'";
            $orderWhere .= " and name1= '".trim($request->name1)."'";
            $orderWhere .= " and name= '".trim($request->name)."'";
            $kpiWhere[] =  ['project' ,'=', $request->name];
            $kpiGroupField = 'project';
            $chartTitle = $request->name;

        }else if($request->name1){
            $groupField = 'name';

            $where[] = ['name4','=',trim($request->name4)];
            $where[] = ['name3','=',trim($request->name3)];
            $where[] = ['name2','=',trim($request->name2)];
            $where[] = ['name1','=',trim($request->name1)];
            $orderWhere .= " and name4 = '".trim($request->name4)."'";
            $orderWhere .= " and name3= '".trim($request->name3)."'";
            $orderWhere .= " and name2= '".trim($request->name2)."'";
            $orderWhere .= " and name1= '".trim($request->name1)."'";
            $kpiWhere[] =  ['area' ,'=', $request->name1];
            $kpiGroupField = 'project';
            $chartTitle = $request->name1;

        }else if($request->name2){
            $groupField = 'name1';

            $where[] = ['name4','=',trim($request->name4)];
            $where[] = ['name3','=',trim($request->name3)];
            $where[] = ['name2','=',trim($request->name2)];
            $orderWhere .= " and name4 = '".trim($request->name4)."'";
            $orderWhere .= " and name3= '".trim($request->name3)."'";
            $orderWhere .= " and name2= '".trim($request->name2)."'";
            $kpiWhere[] =  ['department' ,'=', $request->name2];
            $kpiGroupField = 'area';
            $chartTitle = $request->name2;



        }else if($request->name3){
            $groupField = 'name2';

            $where[] = ['name4','=',trim($request->name4)];
            $where[] = ['name3','=',trim($request->name3)];
            $orderWhere .= " and name4 = '".trim($request->name4)."'";
            $orderWhere .= " and name3= '".trim($request->name3)."'";
            $kpiWhere[] =  ['large_area' ,'=', $request->name3];
            $kpiGroupField = 'department';
            $chartTitle = $request->name3;

        }else{
            $groupField = 'name3';
            $kpiGroupField = 'large_area';
            $chartTitle = '彩生活服务集团';
        }

        if($unit == 'month'){

            $beginTime = strtotime($beginTime);//开始时间
            $endTime = strtotime($endTime.'+1 month');

        }else if($unit == 'year'){
            $endTime = strtotime($beginTime.'-01-01'.'+1 year');
            $beginTime = strtotime($beginTime.'-01-01');
        }else if($unit == 'day'){
            $beginTime = strtotime($beginTime);//开始时间
            $endTime = strtotime($endTime) + 86400;
        }else{
            $firstDay = date('Y-m-01',time());
            $beginTime = strtotime($firstDay);
            $endTime = strtotime("$firstDay +1 month");//月末
            $unit = 'month';

        }
        $chartGmvWhere = $orderWhere;//图标的订单gmv的搜索条件
        $chartGmvWhere .= ' and b.created_at >= '.strtotime(date('Y',time()).'-01-01');
        $chartGmvWhere .= ' and b.created_at <'.strtotime(date('Y',time()).'-01-01'.'+1 year');

        $orderWhere .= " and b.created_at >= ".$beginTime;

        $orderWhere .= " and b.created_at < ".$endTime;
        $beginGmv = $request->kpi_begin;
        $endGmv = $request->kpi_end;

        $complete_begin = $request->complete_begin;
        $complete_end = $request->complete_end;

        $year = date('Y',$beginTime);
        $kpiWhere[] = ['year','=', $year];
        $kpiTargetList = OrganizeKpiTarget::getListKpi($kpiWhere);
        $organizeKpi = $this->getKpiTarget($kpiTargetList, $kpiGroupField, $unit, $beginTime, $endTime);


        $orderInfo = $this->getOrderList($orderWhere,$groupField,$beginGmv,$endGmv);
        $gmvWhere = [];
        if($beginGmv || $endGmv){
            $gmvWhere = [$groupField,array_keys($orderInfo)];
        }
        $field = ['uuid','name4','name3','name2','name1','name'];
        $request->flash();
        $rows = Organize::getRowsKpiComplete($field,$where,$groupField,$gmvWhere);
        $total = $rows->total();
        if($complete_begin || $complete_end){
            foreach ($rows as $k => $v){
                if(isset($orderInfo[$v->$groupField]) && isset($organizeKpi[$v->$groupField])){
                    $kpiCompletePercent = ($orderInfo[$v->$groupField]/$organizeKpi[$v->$groupField])*100;
                    if($complete_begin && $kpiCompletePercent < $complete_begin){
                        unset($rows[$k]);
                    }else if($complete_end && $kpiCompletePercent > $complete_end){
                        unset($rows[$k]);
                    }

                }else{
                    unset($rows[$k]);
                }

            }
            $total = count($rows);
        }
        $rows->appends($_REQUEST);

        $orderInfoToCharts = $this->getOrderByMonth($chartGmvWhere);
        $chartkpiData = $this->getChartKpiData($kpiTargetList,$orderInfoToCharts);

        return view('/statistic/kpi-complete/index',[
            'rows' => $rows,
            'total' => $total,
            'currentPage' => $request->page?$request->page:1,
            'groupField' => $groupField,
            'beginTime' => $beginTime,
            'endTime' => $endTime,
            'orderInfo' => $orderInfo,
            'organizeKpi' => $organizeKpi,
            'chartkpiData' => $chartkpiData,
            'chartTitle' => $chartTitle
        ]);
    }


    public function reset(){



        $result = StatClub::reset();
        if($result){
            return Common::jsonResponse(0,'');

        }
        return Common::jsonResponse(-1,'系统错误');

    }


    private function getOrderList($where = '',$groupField = 'name3',$beginGmv = '',$endGmv = ''){

        $sql = "SELECT `a`.`name4`,`a`.`name3`,`a`.`name2`,`a`.`name1`,`a`.`name`,SUM(`b`.`investment_amount`) as `investment_amount` FROM `organize_xls` as a LEFT JOIN order_master as b on a.uuid = b.community_code where b.status not in (0,500,101) ". $where ." GROUP BY ".$groupField;
        $result = DB::select($sql);
        $rows = [];
        if(!empty($result)){
            foreach ($result as $v){

                $rows[$v->$groupField] = $v->investment_amount/10000;
            }
            if($beginGmv || $endGmv){
                foreach ($rows as $k => $v){
                    if($beginGmv && $v < $beginGmv){
                        unset($rows[$k]);
                        continue;
                    }
                    if($endGmv && $v > $endGmv){
                        unset($rows[$k]);
                        continue;
                    }

                }
            }
        }
        return $rows;
    }


    private function getKpiTarget($data,$groupField,$unit,$beginTime,$endTime){

        $row = [];
        $month = date('m',$beginTime);

        if($unit == 'day'){
            $beginDay = date('d',$beginTime);
            $endDay = date('d',$endTime - 86400);
            $diffDay = $endDay - $beginDay+1;
            if(!empty($data)){
                foreach ($data as $v){
                    if (!isset($row[$v[$groupField]])){
                        $row[$v[$groupField]] = 0;
                    }
                    $dayCount = date('t',$beginTime);
                    $row[$v[$groupField]] += ($v['month'.$month]/$dayCount)*$diffDay;
                }
            }

        }else if($unit == 'year'){
            if(!empty($data)){
                foreach ($data as $v){
                    if (!isset($row[$v[$groupField]])){
                        $row[$v[$groupField]] = 0;
                    }
                    $row[$v[$groupField]] += $v['annual'];

                }
            }
        }else{
            $endMonth = date('m',$endTime);
            if(!empty($data)){
                foreach ($data as $v){
                    if (!isset($row[$v[$groupField]])){
                        $row[$v[$groupField]] = 0;
                    }
                    for ($i = intval($month);$i < $endMonth;$i++){
                        $monthKey = $i;
                        if($i < 10){
                            $monthKey = '0'.$i;
                        }

                        $row[$v[$groupField]] += $v['month'.$monthKey];
                    }
                }
            }
        }
        return $row;

    }

    private function getOrderByMonth($where = ''){

        $sql = "SELECT `a`.`name4`,`a`.`name3`,`a`.`name2`,`a`.`name1`,`a`.`name`,`b`.`investment_amount`,`b`.`created_at` FROM `organize_xls` as a LEFT JOIN order_master as b on a.uuid = b.community_code where b.status not in (0,500,101) ". $where;
        $result = DB::select($sql);
        $rows = [];
        if(!empty($result)){
            foreach ($result as $v){
                if(!isset($rows[date('Y-m',$v->created_at)])){
                    $rows[date('Y-m',$v->created_at)] = 0;
                }
                $rows[date('Y-m',$v->created_at)] += ($v->investment_amount/10000);
            }

        }
        return $rows;
    }

    private function getChartKpiData($kpiTargetList,$orderInfoToCharts){
        $rows = [];
        for ($i = 1;$i <= 12;$i++){
            $keyMonth = $i;
            if($i < 10){
                $keyMonth = '0'.$i;
            }
            $kpi = 0;
            $sum = 0;
            if(!empty($kpiTargetList)){
                foreach ($kpiTargetList as $v){
                    $kpi += $v['month'.$keyMonth];

                }
            }

            $orderKey = date('Y',time()).'-'.$keyMonth;
            if(isset($orderInfoToCharts[$orderKey])){
                $sum = $orderInfoToCharts[$orderKey];
            }
            $rows[] = [
              'time' => $i.'月',
              'kpi' => $kpi,
              'sum' =>$sum
            ];
        }

        return json_encode($rows,true);
    }


}