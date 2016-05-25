<?php

/**
 * Created by PhpStorm.
 * User: apple
 * Date: 16/5/25
 * Time: 下午8:56
 */
class StringHelper
{

    /**
     *    作用：产生随机字符串，不长于32位
     */
    static function createNoncestr($length = 32)
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    /**
     *    作用：格式化参数，签名过程需要使用
     */
    static function formatQueryParamMap($para_map, $urlencode = false)
    {
        $buff = "";
        ksort($para_map);
        foreach ($para_map as $k => $v) {
            if ($urlencode) {
                $v = urlencode($v);
            }

            $buff .= $k . "=" . $v . "&";
        }

        $req_par = '';
        if (strlen($buff) > 0) {
            $req_par = substr($buff, 0, strlen($buff) - 1);
        }

        return $req_par;
    }


    /**
     *    作用：生成签名
     */
    static function getSign($opts, $secret_key)
    {
        $parameters = [];
        foreach ($opts as $k => $v) {
            if ('' === $v || null === $v || $k === 'sign') {
                continue;
            }

            $parameters[$k] = $v;
        }

        // 签名步骤一：按字典序排序参数
        ksort($parameters);
        $string = StringHelper::formatQueryParamMap($parameters, false);

        //签名步骤二：在string后加入KEY
        $string = $string . "&key=" . $secret_key;

        //签名步骤三：MD5加密
        $string = md5($string);

        //签名步骤四：所有字符转为大写
        $result = strtoupper($string);

        return $result;
    }

    function checkSign($data, $secret_key)
    {
        $tmp_data = $data;
        unset($tmp_data['sign']);

        $sign = StringHelper::getSign($tmp_data, $secret_key);

        if ($this->data['sign'] == $sign) {
            return true;
        }

        return false;
    }

    /**
     *    作用：将xml转为array
     */
    static function xmlToArray($xml)
    {
        // 将XML转为array
        $array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $array_data;
    }


}