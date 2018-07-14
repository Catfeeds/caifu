<?php

namespace App\Statistic\Controllers;

use Illuminate\Http\Request;
use App\Statistic\Models\Order;
use App\Statistic\Models\Common;
use App\Statistic\Models\Organize;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller{

    public function index(Request $request){

        $where = $this->getWhere($request);
        $request->flash();
        $rows = Order::getRows($where,TRUE,20);
        $rows->appends($_REQUEST);

        return view('/statistic/order/index',['rows' => $rows,'orderStatus' => Order::$getStatus,'productType' => Order::$getModelName]);
    }
    private function getWhere($request){
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
        return $where;
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

    public function export(Request $request){
        $where = $this->getWhere($request);
        $rows = Order::getRows($where,false);
        $rows = $rows->toArray();
        $result[] = [
            '订单状态','','','','','','','','','','',
            '投资人信息','','','',
            '订单所属架构','','','','','',
            '订单推荐人信息','','',
            '订单所属合作社',''

        ];
        $result[] = [
            '序号','产品类型','订单号','第三方订单编号','订单生效日期','预期到期时间','冲抵费用（元）','订单状态','期数（月）','投资金额（元）','年化金额（元）',
            '投资用户姓名	','手机号	','性别','年龄',
            '集团','大区','事业部','片区','项目','地址',
            '推荐人姓名','推荐人电话','推荐人提成奖励（元）',
            '所属合作社ID','合作社成立时间'

        ];
        if(!empty($rows)){
            foreach ($rows as $v){
                $result[] = [
                    $v->id,Order::$getModelName[$v->model_name],' '.$v->sn,' '.$v->trade_no,
                    date('Y-m-d H:i',$v->begin_time),date('Y-m-d H:i',$v->stop_time),$v->offset_fees,
                    Order::$getStatus[$v->status],$v->months.'个月',$v->investment_amount,sprintf("%.2f",($v->investment_amount/12) * $v->months),
                    $v->username,$v->mobile,Common::getSex($v->idcard_number),Common::getAge($v->idcard_number),
                    $v->name4,$v->name3,$v->name2,$v->name1,$v->project_name,
                    Order::getAddress($v->model_name,$v->sn),
                    $v->recommend_name,$v->recommend_mobile,$v->profit_amount,
                    $v->club_id,$v->created_at?date('Y-m-d H:i',$v->created_at):''

                ];
            }
        }
        Excel::create('订单数据',function($excel) use ($result){

            $excel->sheet('score', function($sheet) use ($result){
                $sheet->mergeCells('A1:K1');
                $sheet->mergeCells('L1:O1');
                $sheet->mergeCells('P1:U1');
                $sheet->mergeCells('V1:X1');
                $sheet->mergeCells('Y1:Z1');
                $sheet->rows($result);

            });

        })->export('xls');
    }

}