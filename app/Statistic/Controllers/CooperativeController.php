<?php

namespace App\Statistic\Controllers;

use Illuminate\Http\Request;
use App\Statistic\Models\Order;
use App\Statistic\Models\StatDaily;
use App\Statistic\Models\Common;
use App\Statistic\Models\ClubJoin;
use Illuminate\Support\Facades\DB;
use App\Statistic\Models\StatClub;
use Maatwebsite\Excel\Facades\Excel;

class CooperativeController extends Controller{

    public function index(Request $request){

        $where = $this->getWhere($request);
        $field = [
            'club_id','name','created_at','username','mobile','member','investment_person','investment_fee','annualized_fee','offset_fee',
            'o_group','large_area','department','area','project'
        ];
        $request->flash();
        $rows = StatClub::getRows($field,$where,true);
        $rows->appends($_REQUEST);
        return view('/statistic/cooperative/index',['rows' => $rows]);
    }


    public function reset(){



        $result = StatClub::reset();
        if($result){
            return Common::jsonResponse(0,'');

        }
        return Common::jsonResponse(-1,'系统错误');

    }

    public function export(Request $request){
        $where = $this->getWhere($request);
        $field = [
            'club_id','name','created_at','username','mobile','member','investment_person','investment_fee','annualized_fee','offset_fee',
            'o_group','large_area','department','area','project'
        ];
        $rows = StatClub::getRows($field,$where,false);
        $rows = $rows->toArray();
        $result[] = ['排名','合作社ID','社名','合作社成立时间','社长姓名','社长手机号','社员人数','在投人数','在投金额（万元）','年化金额（万元）','冲抵订单金额（万元）','所属项目','社长所属事业部','社长所属大区','社长所属集团'];
        if(!empty($rows)){
            foreach ($rows as $k => $v){
                $result[] = [
                    $k+1,$v['club_id'],$v['name'],date('Y年-m月-d日',$v['created_at']),
                    $v['username'],' '.$v['mobile'],$v['member'],$v['investment_person'],
                    sprintf("%.2f",$v['investment_fee']/10000,2),sprintf("%.2f",$v['annualized_fee']/10000,2),
                    sprintf("%.2f",$v['offset_fee']/10000,2),
                    $v['project'],$v['department'],$v['large_area'],$v['o_group']
                ];
            }
        }
        Excel::create('合作社数据',function($excel) use ($result){

            $excel->sheet('score', function($sheet) use ($result){

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
                    'K'     =>  14,
                    'L'     =>  14,
                    'M'     =>  14,
                    'N'     =>  14,
                    'O'     =>  14,

                ));
                $sheet->rows($result)->setFontSize(12);

            });

        })->export('xls');
    }

    private function getWhere($request){
        $where = [];

        if($request->name){
            $where[] = ['o_group','=',trim($request->name4)];
            $where[] = ['large_area','=',trim($request->name3)];
            $where[] = ['department','=',trim($request->name2)];
            $where[] = ['area','=',trim($request->name1)];
            $where[] = ['project','=',trim($request->name)];
        }else if($request->name1){
            $where[] = ['o_group','=',trim($request->name4)];

            $where[] = ['large_area','=',trim($request->name3)];
            $where[] = ['department','=',trim($request->name2)];
            $where[] = ['area','=',trim($request->name1)];
        }else if($request->name2){
            $where[] = ['o_group','=',trim($request->name4)];

            $where[] = ['large_area','=',trim($request->name3)];
            $where[] = ['department','=',trim($request->name2)];
        }else if($request->name3){
            $where[] = ['o_group','=',trim($request->name4)];

            $where[] = ['large_area','=',trim($request->name3)];
        }
        if($request->begin_time){
            $where[] = ['created_at','>=',strtotime($request->begin_time)];
        }
        if($request->end_time){
            $where[] = ['created_at','<',strtotime($request->end_time) + 86400];

        }
        if($request->member_begin){
            $where[] = ['member','>=',$request->member_begin];
        }
        if($request->member_end){
            $where[] = ['member','<=',$request->member_end];

        }
        if($request->investment_fee_begin){
            $where[] = ['investment_fee','>=',$request->investment_fee_begin];
        }
        if($request->investment_fee_end){
            $where[] = ['investment_fee','<=',$request->investment_fee_end];

        }
        if($request->username){
            $where[] = ['username','like','%'.trim($request->username).'%'];

        }
        if($request->club_name){
            $where[] = ['name','like','%'.trim($request->club_name).'%'];

        }
        if($request->mobile){
            $where[] = ['mobile','=',trim($request->mobile)];

        }
        if($request->club_id){
            $where[] = ['club_id','=',trim($request->club_id)];

        }
        return $where;
    }

}