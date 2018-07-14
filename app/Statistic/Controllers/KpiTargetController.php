<?php

namespace App\Statistic\Controllers;

use App\Statistic\Models\OrganizeKpiTarget;
use Illuminate\Http\Request;
use App\Statistic\Models\Common;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class KpiTargetController extends Controller{

    public function index(Request $request){
        $where = $this->getWhere($request);
        $request->flash();
        $rows = OrganizeKpiTarget::getRows('*',$where,TRUE,20);
        $rows->appends($_REQUEST);
        return view('/statistic/kpi-target/index',['rows' => $rows,'year' => OrganizeKpiTarget::$getYear]);
    }

    private function getWhere($request){
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
        return $where;
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

    public function import(Request $request){

        if(!$request->hasFile('file')){
            exit('上传文件为空！');
        }
        $file = $_FILES;
        $excel_file_path = $file['file']['tmp_name'];
        $res = [];
        Excel::load($excel_file_path, function($reader) use( &$res ) {
            $reader = $reader->getSheet(0);
            $res = $reader->toArray();
        });
        $insertData = [];
        for($i = 1;$i<count($res);$i++){
             $insertData[] = [
                 'o_group' => $res[$i][0],
                 'large_area' => $res[$i][1],
                 'department' => $res[$i][2],
                 'area' => $res[$i][3],
                 'project' => $res[$i][4],
                 'year' => $res[$i][5],
                 'month01' => $res[$i][6],
                 'month02' => $res[$i][7],
                 'month03' => $res[$i][8],
                 'month04' => $res[$i][9],
                 'month05' => $res[$i][10],
                 'month06' => $res[$i][11],
                 'month07' => $res[$i][12],
                 'month08' => $res[$i][13],
                 'month09' => $res[$i][14],
                 'month10' => $res[$i][15],
                 'month11' => $res[$i][16],
                 'month12' => $res[$i][17],
                 'annual' => $res[$i][18],

             ];
        }
        if(!empty($insertData)){
            DB::table('organize_kpi_target')->insert($insertData);
            return Common::jsonResponse();
        }else{
            return Common::jsonResponse(-1,'表格数据为空');
        }

    }

    public function export(Request $request){
        $where = $this->getWhere($request);
        $result = OrganizeKpiTarget::getRows('*',$where,false);
        $result = $result->toArray();
        $rows[] = ['序号','集团','大区','事业部','片区','项目','年份','1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月','全年'];
        if(!empty($result)){
            foreach ($result as $v){
                $rows[] = [
                    $v['id'],$v['o_group'],$v['large_area'],$v['department'],$v['area'],$v['project'],
                    $v['year'],$v['month01'],$v['month02'],$v['month03'],$v['month04'],$v['month05'],$v['month06'],
                    $v['month07'],$v['month08'],$v['month09'],$v['month10'],$v['month11'],$v['month12'],$v['annual']

                ];
            }
        }
        Excel::create('kpi目标数据',function($excel) use ($rows){

            $excel->sheet('score', function($sheet) use ($rows){

                $sheet->rows($rows);

            });

        })->export('xls');

    }

}