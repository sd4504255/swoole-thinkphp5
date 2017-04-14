<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

/**
 * 随机数生成器
 * @author wenzhidong
 * @date   2017-01-16
 * @param  [type] $len [description]
 * @return [type]      [description]
 */
function randString($len=6)
{
    $str    = '';
    $len    = intval($len);
    if($len > 0){
        $codeSet = '23456789acdefghjklmnpqrstuvwxyz';
        $codeLen = strlen($codeSet);
        if($codeLen > 1){
            for ($i = 0; $i < $len; $i++) {
                $str .= $codeSet[mt_rand(0, $codeLen - 1)];            
            }
            $str = strtoupper($str);
        }
        
    }    
    return $str;
}