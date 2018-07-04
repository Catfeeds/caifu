<?php

namespace App\Statistic\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class OrganizeKpiTarget extends Model{

    protected $table = 'organize_kpi_target';

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

    public static $getYear = [
        2018 => '2018',
        2017 => '2017',
        2016 => '2016',
        2015 => '2015',
        2014 => '2014',
        2013 => '2013',
    ];

    public static function getListKpi($where){

       $result = self::select([
            'large_area','department','area','project',
            'month01','month02','month03','month04','month05','month06',
            'month07','month08','month09','month10','month11','month12',
            'annual'

        ])->where($where)->get()->toArray();
       return $result;
    }
}