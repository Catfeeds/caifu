<?php

namespace App\Statistic\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class StatClub extends Model{

    protected $table = 'stat_club';

    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * @desc 返回用户新增-表数据
     */
    public static function getRows($fields = '*',$where = [],$isPage = false,$pageSize = 20){


        $query = self::select($fields);
        if(!empty($where)){
            $query->where($where);
        }
        $query->orderBy('investment_fee','desc');
        if($isPage){
            return $query->paginate($pageSize);
        }
        return $query->get();
    }

    public static function reset(){

        $result = DB::select('select a.id,a.name,a.user_id as club_user_id,a.member,a.investment,a.created_at,c.mobile,d.name as username from club as a left join user_master as c on a.user_id = c.id left join user_idcard as d on a.user_id = d.user_id where a.status = 0');
        $orderData = DB::select('SELECT a.user_id,a.club_id ,b.model_name,b.investment_amount,b.months,b.community_code ,b.stop_time,c.name4 as o_group,c.name3,c.name2,c.name1,c.name from club_join as a left join order_master as b on a.user_id = b.user_id LEFT JOIN organize_xls as c on b.community_code = c.uuid where a.status = 1 and b.status not in (0,500,101)');
        $orderRows = [];
        if(!empty($orderData)){
            foreach ($orderData as $v){
                if(!isset($orderRows[$v->club_id])){
                    $orderRows[$v->club_id]['investment_fee'] = 0;//年化金额
                    $orderRows[$v->club_id]['offset_fee'] = 0;//冲抵订单金额
                }
                if($v->stop_time > time()){//计算在投人数
                    $orderRows[$v->club_id]['investment_person'][$v->user_id] = 1;//在投人数,去重
                }
                $orderRows[$v->club_id]['investment_fee'] += ($v->investment_amount/12)*$v->months;
                if(in_array($v->model_name, ['AdvanceProperty','Parking','Property'])){
                    $orderRows[$v->club_id]['offset_fee'] += $v->investment_amount;//冲抵订单金额
                }
                if(!isset($orderRows[$v->club_id]['address'][$v->user_id])){
                    $orderRows[$v->club_id]['address'][$v->user_id]['o_group'] = $v->o_group;
                    $orderRows[$v->club_id]['address'][$v->user_id]['large_area'] = $v->name3;
                    $orderRows[$v->club_id]['address'][$v->user_id]['department'] = $v->name2;
                    $orderRows[$v->club_id]['address'][$v->user_id]['area'] = $v->name1;
                    $orderRows[$v->club_id]['address'][$v->user_id]['project'] = $v->name;

                }

            }

        }
        $insertData = [];
        if(!empty($result)){
            foreach ($result as $v){
                $investment_person = 0;
                $annualized_fee = 0;
                $offset_fee = 0;
                $o_group = '';
                $large_area = '';
                $department = '';
                $area = '';
                $project = '';

                if(isset($orderRows[$v->id]['investment_person'])){
                    $investment_person = count($orderRows[$v->id]['investment_person']);
                }
                if(isset($orderRows[$v->id]['investment_fee'])){
                    $annualized_fee = $orderRows[$v->id]['investment_fee'];
                }
                if(isset($orderRows[$v->id]['offset_fee'])){
                    $offset_fee = $orderRows[$v->id]['offset_fee'];
                }
                if(isset($orderRows[$v->id]['address'][$v->club_user_id])){
                    $address = $orderRows[$v->id]['address'][$v->club_user_id];
                    $o_group = $address['o_group'];
                    $large_area = $address['large_area'];
                    $department = $address['department'];
                    $area = $address['area'];
                    $project = $address['project'];

                }
                $insertData[] = [
                    'club_id' => $v->id,
                    'name' => $v->name,
                    'created_at' => $v->created_at,
                    'username' => $v->username,
                    'mobile' => $v->mobile,
                    'member' => $v->member,
                    'investment_fee' => $v->investment,
                    'investment_person' => $investment_person,
                    'annualized_fee' => $annualized_fee,
                    'offset_fee' => $offset_fee,
                    'o_group' => $o_group,
                    'large_area' => $large_area,
                    'department' => $department,
                    'area' => $area,
                    'project' => $project,
                    'created_time' => time()


                ];
            }
        }

        DB::beginTransaction();
        DB::table('stat_club')->delete();
        if(!empty($insertData)){
            $result = DB::table('stat_club')->insert($insertData);
            if($result){
                DB::commit();
                return true;
            }else{
                DB::rollback();
                return false;
            }

        }
        DB::commit();
        return true;

    }
}