<?php

namespace App\Statistic\Models;
use Illuminate\Support\Facades\Log;

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

     public static function curlPost($url, $data, $dataType = 'array') {
         // 1. 初始化
         $ch = curl_init();
         // 2. 设置选项，包括URL
         curl_setopt($ch, CURLOPT_URL, $url);
         curl_setopt($ch, CURLOPT_HEADER, 0); //设置header

         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
         //curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
         curl_setopt($ch, CURLOPT_TIMEOUT, 20);
         //curl_setopt($ch, CURLOPT_TIMEOUT_MS, 1); //设置不用等待

         curl_setopt($ch, CURLOPT_POST, 1);
         //            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
         if ($dataType != 'json') {
             $data = http_build_query($data);
         }
         curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
         // 3. 执行并获取HTML文档内容
         $output = curl_exec($ch);
         //            var_dump($output);exit;
         if ($output === FALSE) {
             Log::error('post curl error:' . curl_error($ch));
             Log::error('post curl errno:' . curl_errno($ch));

             //                echo "cURL Error: " . curl_error($ch);
         }
         // 4. 释放curl句柄
         curl_close($ch);
         return $output;
     }

     public static function curlGet($url, $data) {

         $url = $url . http_build_query($data);
         // 1. 初始化
         $ch = curl_init();
         // 2. 设置选项，包括URL
         curl_setopt($ch, CURLOPT_URL, $url);
         curl_setopt($ch, CURLOPT_HEADER, 0); //设置header

         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
         //curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
         // curl_setopt($ch, CURLOPT_TIMEOUT, 100);
         //    curl_setopt($ch, CURLOPT_TIMEOUT_MS, 1); //设置不用等待
         // 3. 执行并获取HTML文档内容
         $output = curl_exec($ch);
         //var_dump($output);exit;
         if ($output === FALSE) {
             //echo "cURL Error: " . curl_error($ch);
             Log::error('get curl error:' . curl_error($ch));
         }
         // 4. 释放curl句柄
         curl_close($ch);
         return $output;
     }
}