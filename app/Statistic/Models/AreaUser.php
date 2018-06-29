<?php

namespace App\Statistic\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class AreaUser extends Model{

    protected $table = 'stat_area_user';

    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;


    public static function getRows($fields = '*',$where = [],$isPage = false,$pageSize = 20){


        $query = self::select($fields);
        if(!empty($where)){
            $query->where($where);
        }
        if($isPage){
            return $query->paginate($pageSize);
        }
        return $query->get();
    }
    /**
     *
     * @param string $fields
     * @param array $where
     * @return 返回各大区冲抵覆盖率，社长覆盖率
     */
    public static function getLargeArea(){
        $query = self::select(['large_area','flushing_num','owner_num','president_num','staff_num']);


        $result = $query->get()->toArray();
        $data = [];
        if(!empty($result)){
            $rows = [];
            foreach ($result  as $k => $v){
                if(!isset($rows[$v['large_area']])){
                    $rows[$v['large_area']]['flushing_num'] = 0;
                    $rows[$v['large_area']]['owner_num'] = 0;
                    $rows[$v['large_area']]['president_num'] = 0;
                    $rows[$v['large_area']]['staff_num'] = 0;

                }
                $rows[$v['large_area']]['flushing_num'] += $v['flushing_num'];
                $rows[$v['large_area']]['owner_num'] += $v['owner_num'];
                $rows[$v['large_area']]['president_num'] += $v['president_num'];
                $rows[$v['large_area']]['staff_num'] += $v['staff_num'];

            }

            foreach ($rows as $key => $v){
                $data['flushing'][] = [
                  'area' => $key,
                    'percent' => sprintf("%.2f",($v['flushing_num']/$v['owner_num'])*100)
                ];
                $data['president'][] = [
                    'area' => $key,
                    'percent' => sprintf("%.2f",($v['president_num']/$v['staff_num'])*100)
                ];
            }
        }
        return $data;
    }
}