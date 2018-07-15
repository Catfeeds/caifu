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
use Maatwebsite\Excel\Facades\Excel;

class KpiContributionController extends Controller{

    public function index(Request $request){

        $whereResult = $this->getWhere($request);
        $where = $whereResult['where'];
        $groupField = $whereResult['groupField'];
        $gmvWhere = $whereResult['gmvWhere'];
        $complete_begin = $whereResult['complete_begin'];
        $complete_end = $whereResult['complete_end'];
        $orderInfo = $whereResult['orderInfo'];
        $organizeKpi = $whereResult['organizeKpi'];
        $kpiGroupField = $whereResult['kpiGroupField'];
        $beginTime = $whereResult['beginTime'];
        $endTime = $whereResult['endTime'];
        $chartTitle = $whereResult['chartTitle'];

        $field = ['uuid','name4','name3','name2','name1','name'];
        $request->flash();
        $rows = Organize::getRowsKpiComplete($field,$where,$groupField,$gmvWhere);
        $total = $rows->total();
        if($complete_begin || $complete_end){
            foreach ($rows as $k => $v){
                if(isset($orderInfo[$v->$groupField]) && isset($organizeKpi[$v->$kpiGroupField])){
                    $kpiCompletePercent = ($orderInfo[$v->$groupField]/$organizeKpi[$v->$kpiGroupField])*100;
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

        $chartkpiData = $this->getChartKpiData($orderInfo);

        return view('/statistic/kpi-contribution/index',[
            'rows' => $rows,
            'total' => $total,
            'currentPage' => $request->page?$request->page:1,
            'groupField' => $groupField,
            'beginTime' => $beginTime,
            'endTime' => $endTime,
            'orderInfo' => $orderInfo,
            'organizeKpi' => $organizeKpi,
            'kpiGroupField' => $kpiGroupField,
            'chartkpiData' => $chartkpiData,
            'chartTitle' => $chartTitle
        ]);
    }


    public function export(Request $request){
        $whereResult = $this->getWhere($request);
        $where = $whereResult['where'];
        $groupField = $whereResult['groupField'];
        $gmvWhere = $whereResult['gmvWhere'];
        $complete_begin = $whereResult['complete_begin'];
        $complete_end = $whereResult['complete_end'];
        $orderInfo = $whereResult['orderInfo'];
        $organizeKpi = $whereResult['organizeKpi'];
        $kpiGroupField = $whereResult['kpiGroupField'];
        $beginTime = $whereResult['beginTime'];
        $endTime = $whereResult['endTime'];
        $chartTitle = $whereResult['chartTitle'];

        $field = ['uuid','name4','name3','name2','name1','name'];
        $rows = Organize::getRowsKpiComplete($field,$where,$groupField,$gmvWhere,false);
        $rows = $rows->toArray();

        $excelResult[] = [
            '地区选择','','','','','',
            'KPI贡献情况统计','','',''
        ];
        $excelResult[] = [
            '序号','集团','大区','事业部','片区','项目',
            '时间（年/月/日）','KPI（万元）','GMV（万元）','贡献率'
        ];
        foreach ($rows as $k => $v){
            if(isset($orderInfo[$v[$groupField]]) && isset($organizeKpi[$v[$kpiGroupField]])){
                $kpiCompletePercent = ($orderInfo[$v[$groupField]]/$organizeKpi[$v[$kpiGroupField]])*100;
                if($complete_begin && $kpiCompletePercent < $complete_begin){
                    continue;
                }else if($complete_end && $kpiCompletePercent > $complete_end){
                    continue;
                }

            }

            $name2 = '';
            $name1 = '';
            $name = '';
            $kpiData = '';
            $gmvData = '';
            $kpiPercent = '';
            if(in_array($groupField,['name2','name1','name'])){
                $name2 = $v['name2'];
            }
            if($groupField == 'name1' || $groupField == 'name'){
                $name1 = $v['name1'];
            }
            if($groupField == 'name'){
                $name = $v['name'];
            }
            if($request->unit == 'year'){
                $date = date('Y',$beginTime);
            }else if($request->unit == 'day') {
                $date = date('Y-m',$beginTime) .'--'.date('Y-m',$endTime);
            }else{
                $searchEndTime = date('Y-m-01',$endTime);
                $date = date('Y-m',$beginTime) .'--'. date('Y-m',strtotime("$searchEndTime -1 month"));//月末;

            }
            if(isset($organizeKpi[$v[$kpiGroupField]])){
                $kpiData = sprintf("%.2f",$organizeKpi[$v[$kpiGroupField]],2);
            }
            if(isset($orderInfo[$v[$groupField]])){
                $gmvData = $orderInfo[$v[$groupField]];
            }
            if(isset($orderInfo[$v[$groupField]]) && isset($organizeKpi[$v[$kpiGroupField]])){
                if($organizeKpi[$v[$kpiGroupField]] == 0){
                    $kpiPercent = sprintf("%.2f",$orderInfo[$v[$groupField]]*100,2).'%';
                }else{
                    $kpiPercent = sprintf("%.2f",($orderInfo[$v[$groupField]]/$organizeKpi[$v[$kpiGroupField]])*100,2).'%';
                }
            }
            $excelResult[] = [
                $k+1,$v['name4'],$v['name3'],$name2,$name1,$name,
                $date,$kpiData,$gmvData,$kpiPercent
            ];


        }

        Excel::create('地区KPI贡献率数据',function($excel) use ($excelResult){

            $excel->sheet('score', function($sheet) use ($excelResult){
                $sheet->mergeCells('A1:F1');
                $sheet->mergeCells('G1:J1');
                $sheet->setWidth(array(
                    'A'     =>  14,
                    'B'     =>  14,
                    'C'     =>  14,
                    'D'     =>  14,
                    'E'     =>  14,
                    'F'     =>  14,
                    'G'     =>  14,
                    'H'     =>  14,
                    'I'     =>  14,
                    'J'     =>  14,


                ));
                $sheet->rows($excelResult)->setFontSize(12);

            });

        })->export('xls');


    }

    private function getWhere($request){
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
            $kpiGroupField = 'name1';
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
            $kpiGroupField = 'name1';
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
            $kpiGroupField = 'name2';
            $chartTitle = $request->name2;



        }else if($request->name3){
            $groupField = 'name2';

            $where[] = ['name4','=',trim($request->name4)];
            $where[] = ['name3','=',trim($request->name3)];
            $orderWhere .= " and name4 = '".trim($request->name4)."'";
            $orderWhere .= " and name3= '".trim($request->name3)."'";
            $kpiWhere[] =  ['large_area' ,'=', $request->name3];
            $kpiGroupField = 'name3';
            $chartTitle = $request->name3;

        }else{
            $groupField = 'name3';
            $kpiGroupField = 'name4';
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
        $organizeKpi = $this->getOrderList($orderWhere,$kpiGroupField);//上级的gmv
        $orderInfo = $this->getOrderList($orderWhere,$groupField,$beginGmv,$endGmv);//当前级的gmv

        $gmvWhere = [];
        if($beginGmv || $endGmv){
            $gmvWhere = [$groupField,array_keys($orderInfo)];
        }
        return [
            'kpiGroupField' => $kpiGroupField,
            'orderInfo' => $orderInfo,
            'organizeKpi' => $organizeKpi,
            'complete_begin' => $complete_begin,
            'complete_end' => $complete_end,
            'where' => $where,
            'groupField' => $groupField,
            'gmvWhere' => $gmvWhere,
            'beginTime' => $beginTime,
            'endTime' => $endTime,
            'chartTitle' => $chartTitle,

        ];
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

    private function getChartKpiData($orderInfo){
        $rows = [];
        if(!empty($orderInfo)){
            foreach ($orderInfo as $k => $v){
                $rows[] = [
                    'area' => $k,
                    'num' => $v
                ];
            }
        }

        return json_encode($rows,true);
    }


}