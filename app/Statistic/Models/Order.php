<?php

namespace App\Statistic\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Foreach_;
class Order extends Model{

    protected $table = 'order_master';

    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     *
     * @param array $where 查询条件
     * @param string $isPage 是否分页 true 分页，false不分页
     * @param number $pageSize 每页条数
     * @return 获取订单列表信息
     */
    public static function getRows($where = [],$isPage = false,$pageSize = 20){

//            $query = self::select('*');
        $query = DB::table('order_master as a')->select(
            'a.id','a.sn','a.trade_no','a.user_id','a.investment_amount','a.model_name',
            'a.begin_time','a.stop_time','a.offset_fees','a.status','a.months',
            'b.name as username','b.idcard_number','c.mobile',
            'd.name4', 'd.name3', 'd.name2', 'd.name1', 'd.name as project_name',
            'e.profit_amount','e.user_id as recommend_id',
            'f.name as recommend_name',
            'h.mobile as recommend_mobile',
            'i.club_id','i.created_at'
            )
                 ->leftJoin('user_idcard as b','a.user_id','=','b.user_id')
                 ->leftJoin('user_master as c','a.user_id','=','c.id')
                 ->leftJoin('organize_xls as d','a.community_code','=','d.uuid')
                 ->leftJoin('user_recommend_log as e','a.sn','=','e.sn')

                 ->leftJoin('user_idcard as f','e.user_id','=','f.user_id')
                 ->leftJoin('user_master as h','e.user_id','=','h.id')
                 ->leftJoin('club_join as i','a.user_id','=','i.user_id');

        if(!empty($where)){
            $query->where($where);
        }
        $query->groupBy('a.id');
        if($isPage){
            return $query->paginate($pageSize);
        }
        return $query->get();
    }
    /**
     *
     * @var array 订单状态
     */
    public static $getStatus = [
        0 => '待付款',
        500 => '已取消',
        100 => '支付成功',
        101 => '冷静期取消',
        200 => '投资中',
        210 => '复投未生效',
        211 => '用户取消复投',
        212 => '系统取消复投',
        213 => '复投生效中',
        214 => '已复投',
        220 => '已到期（已回款）',
        230 => '已赎回',
    ];
    /**
     *
     * @var array 产品类型
     */
    public static $getModelName = [
        'Appreciation' => '增值计划',
        'AdvanceProperty' => '冲抵物业费',
        'Parking' => '冲抵停车费',
        'Property' => '冲抵往期欠费',
        'ParkingSpace' => '彩车位',
        'Pension' => '养老宝',
        'Company' => '企盈宝',
        'Ydb' => '优抵宝'

    ];

    /**
     *
     * @param string $modelName
     * @return string 通过订单类型获取对应的订单费用表名
     */
    public static function getFeeTableName($modelName){

        $tableName = '';
        if(in_array($modelName, ['AdvanceProperty','Company','Pension'])){

            $tableName = 'order_advance_fees';
        }else if($modelName == 'Appreciation'){
            $tableName = 'order_appreciation_fees';
        }else if($modelName == 'Parking'){
            $tableName = 'order_parking_fees';
        }else if($modelName == 'ParkingSpace'){
            $tableName = 'order_parking_space_fees';
        }else if($modelName == 'Property'){
            $tableName = 'order_property_fees';
        }else if($modelName == 'Ydb'){
            $tableName = 'order_ydb_fees';
        }
        return $tableName;


    }
    /**
     *
     * @param string $modelName 订单类型
     * @param string $sn 订单号
     * @return string 返回对应的地址
     */
    public static function getAddress($modelName,$sn){
        $tableName = self::getFeeTableName($modelName);
        if(!$tableName){
            return '';
        }

        $result = DB::select('select address from '.$tableName.' where order_sn = ? limit 1',[$sn]);
        if(empty($result)){
            return '';
        }
        $address = json_decode($result[0]->address,true);
        if(empty($address)){
            return '';
        }
        $province = $address['province']['name'];
        $city = $address['city']['name'];
        $area = $address['area']['name'];
        $community = $address['community']['name'];
        $build = $address['build']['name'];
        $room = $address['room']['name'];
        return $province.$city.$area.$community.$build.$room;
    }

    /**
     *
     * @param integer $time 开始时间
     * @return array|number 返回日报里的订单冲抵相关信息
     */
    public static function getOrderList($time){
        $result = self::select(['created_at','investment_amount','model_name'])->where('created_at','>=',$time)->whereNotIn('status',[0,500,101])->get()->toArray();
        $rows = [];
        if(!empty($result)){

            foreach ($result as $v){
                if(!isset($rows[date('Y-m-d',$v['created_at'])])){
                    $rows[date('Y-m-d',$v['created_at'])]['allAmount'] = 0;
                    $rows[date('Y-m-d',$v['created_at'])]['allCount'] = 0;

                    $rows[date('Y-m-d',$v['created_at'])]['advancePropertyAmount'] = 0;
                    $rows[date('Y-m-d',$v['created_at'])]['advancePropertyCount'] = 0;
                    $rows[date('Y-m-d',$v['created_at'])]['parkingAmount'] = 0;
                    $rows[date('Y-m-d',$v['created_at'])]['parkingCount'] = 0;

                }
                $rows[date('Y-m-d',$v['created_at'])]['allAmount'] += $v['investment_amount'];//所有的资金端交易额集合
                $rows[date('Y-m-d',$v['created_at'])]['allCount'] += 1;//所有单数

                if($v['model_name'] == 'AdvanceProperty'){//冲抵物业宝
                    $rows[date('Y-m-d',$v['created_at'])]['advancePropertyAmount'] += $v['investment_amount'];
                    $rows[date('Y-m-d',$v['created_at'])]['advancePropertyCount'] += 1;

                }else if($v['model_name'] == 'Parking'){//冲抵停车宝
                    $rows[date('Y-m-d',$v['created_at'])]['parkingAmount'] += $v['investment_amount'];//投资金额
                    $rows[date('Y-m-d',$v['created_at'])]['parkingCount'] += 1;

                }


            }
        }
        return $rows;
    }
    /**
     *
     * @param integer $time 开始时间
     * @return number[] 返回每天新增用户人数
     */
    public static function getUserAdd($time = null,$endTime = null)
    {
        $query = self::select('user_id', 'created_at');


        if($endTime){
            $query->where('created_at','<',$endTime);
        }
        $query->whereNotIn('status',[0,500,101]);
        $query->groupBy('user_id');
        $query->orderBy('created_at','asc');
        $result = $query->get()->toArray();
        $rows = [];
        if(!empty($result)){

            foreach ($result as $v){
                $date = date('Y-m-d',$v['created_at']);
                if($time && $v['created_at'] < $time){
                    continue;
                }
                if(!isset($rows[$date])){
                    $rows[$date] = 0;
                }
                $rows[$date] += 1;
            }
        }
        return $rows ;

    }

    public static function updateInfoById($data){
        DB::table('order_master')->update($data);
    }


    public static function getAreaUserOrder($time){
        $query = DB::table('order_master as a')->select('a.user_id','a.created_at','a.investment_amount','a.model_name','a.community_code','b.recommend_id');
        $query->leftJoin('user_recommend_log as b','a.sn','=','b.sn');

        $result = $query->where('a.created_at','>=',$time)->whereNotIn('a.status',[0,500,101])->orderBy('a.id','asc')->get()->toArray();
        $rows = [];
        $recastRows = [];
        $userIdList = array_column($result,'user_id');
        array_unique($userIdList);
        $clubUserList = Club::select(['user_id'])->where(['status' => 0])->whereIn('user_id',$userIdList)->get()->toArray();//社长数集合
        $clubUserList = array_column($clubUserList, NULL,'user_id');

        if(!empty($result)){

           foreach ($result as $v){
               $rows[$v->community_code]['all'][$v->user_id] = 1;//投资户数
               if(in_array($v->model_name,['AdvanceProperty','Parking','Property'])){
                   $rows[$v->community_code]['flushing'][$v->user_id] = 1;//冲抵户数

               }
               if(!isset($recastRows[$v->community_code]['count'][$v->user_id])){
                   $recastRows[$v->community_code]['count'][$v->user_id] = 1;
                   $recastRows[$v->community_code]['time'][$v->user_id] = $v->created_at;
               }else{
                   $date1 = date('Y-m-d',$recastRows[$v->community_code]['time'][$v->user_id]);
                   $date2 = date('Y-m-d',$v->created_at);
                   $res = self::getMonthNum($date1, $date2);
                   if($res){
                       $rows[$v->community_code]['recast'][$v->user_id] = 1;//复投户数
                   }else{
                       $recastRows[$v->community_code]['time'][$v->user_id] = $v->created_at;
                   }
               }
               if(isset($clubUserList[$v->user_id])){
                   $rows[$v->community_code]['master'][$v->user_id] = 1;//社长数
                   unset($clubUserList[$v->user_id]);
               }
               //推荐人数
               if($v->recommend_id){
                   $rows[$v->community_code]['recommend'][$v->recommend_id] = 1;//投资户数

               }



           }
           foreach ($rows as $k => $v){
               $rows[$k]['all'] = count($rows[$k]['all']);
               $rows[$k]['flushing'] = isset($rows[$k]['flushing'])?count($rows[$k]['flushing']):0;
               $rows[$k]['recast'] = isset($rows[$k]['recast'])?count($rows[$k]['recast']):0;
               $rows[$k]['master'] = isset($rows[$k]['master'])?count($rows[$k]['master']):0;
               $rows[$k]['recommend'] = isset($rows[$k]['recommend'])?count($rows[$k]['recommend']):0;
           }
        }

        return $rows;
    }

    /**
     * @var date1日期1
     * @var date2 日期2
     * @var tags 年月日之间的分隔符标记,默认为'-'
     * @return 相差的月份数量
     * @example:
     $date1 = "2003-08-11";
     $date2 = "2008-11-06";
     $monthNum = getMonthNum( $date1 , $date2 );
     * 判断是否是6个月内，是则返回true
     */
    public static function getMonthNum( $date1, $date2, $tags='-' ){
        $date1 = explode($tags,$date1);
        $date2 = explode($tags,$date2);
        $day = abs($date1[2] - $date2[2]);
        $month = ($date2[0] - $date1[0]) * 12 + ($date2[1] - $date1[1]);
        if($month > 6){
            return false;
        }
        if($month == 6 && $day > 0){
            return  false;
        }
        return true;
    }


}