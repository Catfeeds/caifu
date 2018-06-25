<?php

namespace App\Statistic\Models;
class Common{

    /**
     *
     * @param number $errcode 状态码
     * @param string $msg 错误信息
     * @param array $data 数据集合
     * @return \Illuminate\Http\JsonResponse 返回json格式的数据
     */
     public static function jsonResponse($errcode = 0,$msg = '',$data = []){

         $result = [
             'errcode' => $errcode,
             'msg' => $msg,
             'data' => $data
         ];
        return response()->json($result);
     }

     /**
      *  根据身份证号码获取性别
      *  author:xiaochuan
      *  @param string $idcard    身份证号码
      *  @return int $sex 性别 1男 2女 0未知
      */
     public static function getSex($idcard) {
         if(empty($idcard)) return null;
         $sexint = (int) substr($idcard, 16, 1);
         return $sexint % 2 === 0 ? '女' : '男';
     }

     /**
      *  根据身份证号码计算年龄
      *  author:xiaochuan
      *  @param string $idcard    身份证号码
      *  @return int $age
      */
     public static function getAge($idcard){
         if(empty($idcard)) return null;
         #  获得出生年月日的时间戳
         $date = strtotime(substr($idcard,6,8));
         #  获得今日的时间戳
         $today = strtotime('today');
         #  得到两个日期相差的大体年数
         $diff = floor(($today-$date)/86400/365);
         #  strtotime加上这个年数后得到那日的时间戳后与今日的时间戳相比
         $age = strtotime(substr($idcard,6,8).' +'.$diff.'years')>$today?($diff+1):$diff;
         return $age;
     }
}