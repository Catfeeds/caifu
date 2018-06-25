<?php

namespace App\Statistic\Controllers;


use App\Statistic\Models\Organize;
use Illuminate\Http\Request;
use App\Statistic\Models\Common;

class ApiController extends Controller{

    public function getOrganize(Request $request){

        $parentField = $request->input('parent_field');
        $parentValue = $request->input('parent_value');
        $childField = $request->input('child_field');

        if(empty($childField)){
            return Common::jsonResponse(1001,'参数缺失');
        }
        $parent = [];
        if($parentField && $parentValue){
            $parent = [
                'field' => $parentField,
                'value' => $parentValue
            ];
        }
        $result = Organize::getChildByParent($parent, $childField);
        return Common::jsonResponse(0,'',$result);
    }




}