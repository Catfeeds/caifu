<?php

namespace App\Statistic\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Organize extends Model{

    protected $table = 'organize_xls';

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
     * @param array $parent 父级字段和值
     * @param string $field 查询的字段
     * @return 返回子类的值
     */
    public static function getChildByParent($parent = [],$field){

        $query = self::select($field);
        if(!empty($parent)){
            $query->where([$parent['field'] => $parent['value']]);
        }
        $result = $query->distinct()->get()->toArray();
        return $result;

    }
    /**
     *
     * @param string $fields 查询字段
     * @param array $where 查询条件
     * @param string $groupField 组合字段
     * @param string $isPage
     * @param number $pageSize
     * @return 返回kpi完成表的列表信息
     */
    public static function getRowsKpiComplete($fields = '*',$where = [],$groupField = 'name3',$gmvWhere = [],$isPage = true,$pageSize = 20){


        $query = self::select($fields);
        if(!empty($where)){
            $query->where($where);
        }
        if(!empty($gmvWhere)){
            $query->whereIn($gmvWhere[0],$gmvWhere[1]);
        }
        $query->groupBy($groupField);
        if($isPage){
            return $query->paginate($pageSize);
        }
        return $query->get();
    }




}