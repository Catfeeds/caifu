<?php

namespace App\Statistic\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
class Organize extends Model{

    protected $table = 'organize_xls';


    public static $apiUrl;
    public static $appId;
    public static $token;


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
    /**
     *
     */
    public static function getAreaUserInfo(){
        $result = self::select(['uuid','name','name1','name2','name3','name4'])->get()->toArray();
        return $result;
    }

    public static function getApiInfo(){

        if(config('app.env') == 'production'){//生产环境
            self::$apiUrl = 'http://tp.openapi.colourlife.com';

            self::$appId = 'ICESJHT0-X429-SOM5-C14M-L83I7N77TNXV';
            self::$token = 'u8XYMezzO1kbxFT5kwyR';
        }else{
            self::$apiUrl = 'https://openapi-test.colourlife.com';

            self::$appId = 'ICESJHT0-5J1A-ZMVS-DWBU-51KCV559BICH';
            self::$token = '7oqLMj8FOEdjmzAyzdB9';
        }

    }

    /**
     * @return 返回该uuid下的在职员工人数
     * @param string $uuid 组织架构uuid
     */
    public static function getJobCount($uuid){
        self::getApiInfo();
        $url = self::$apiUrl.'/v1/jobv2/org';//测试环境的在职员工数地址
        $appId = self::$appId;
        $time = time();
        $token = self::$token;
        $sign = md5($appId.$time.$token.'false');
        $params = "?ts=".$time;
        $params .= "&sign=".$sign;
        $params .= "&appID=".$appId;
        $params .= "&org_uuid=".$uuid;
        $url .= $params;
        return $url;
//         $result = Common::curlGet($url, []);
//         $result = json_decode($result,true);
//         return count($result['content']);
    }

    /**
     * @return 返回该uuid下的在职员工人数
     * @param string $uuid 组织架构uuid
     */
    public static function getHouseHolds($uuid){
        self::getApiInfo();
        $url = self::$apiUrl.'/v1/community/household';//测试环境的在职员工数地址
        $appId = self::$appId;
        $time = time();
        $token = self::$token;
        $sign = md5($appId.$time.$token.'false');
        $params = "?ts=".$time;
        $params .= "&sign=".$sign;
        $params .= "&appID=".$appId;
        $params .= "&uuid=".$uuid;
        $url .= $params;
        return $url;
//         $result = Common::curlGet($url, []);
//         $result = json_decode($result,true);
//         if(isset($result['content']['vdef5'])){
//             return $result['content']['vdef5'];
//         }
//         return 0;
    }




}