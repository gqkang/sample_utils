<?php

/**
 * Created by PhpStorm.
 * User: apple
 * Date: 16/5/25
 * Time: 下午9:10
 */
class HttpHelper
{
    /**
     *  作用：以post方式提交xml到对应的接口url
     */
    static function postXmlCurl($url, $body, $second = 30)
    {
        //初始化curl
        $ch = curl_init();

        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);

        //这里设置代理，如果有的话
        //curl_setopt($ch,CURLOPT_PROXY, '8.8.8.8');
        //curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);

        //运行curl
        $data = curl_exec($ch);
        curl_close($ch);

        //返回结果
        if ($data) {
            curl_close($ch);
            return $data;

        } else {

            $error = curl_errno($ch);
            echo "curl出错，错误码:$error" . "<br>";
            echo "<a href='http://curl.haxx.se/libcurl/c/libcurl-errors.html'>错误原因查询</a></br>";
            curl_close($ch);
            return false;
        }
    }

    /**
     * 长url转为短url
     * @param $long_url
     * @return string
     */
    static function convertToShortUrl($long_url)
    {
        $url = trim($long_url);
        $url = urlencode($url);

        $short_url = '';
        if($url){
            $short_url = self::sinaShortenUrl($url);
        }

        return $short_url;
    }

    /**
     * 根据长网址获取短网址
     * @param $long_url
     * @return string
     */
    private static function sinaShortenUrl($long_url)
    {
        // 拼接请求地址，此地址你可以在官方的文档中查看到
        $sina_appkey = '31641035';
        $url = 'http://api.t.sina.com.cn/short_url/shorten.json?source=' . $sina_appkey . '&url_long=' . $long_url;

        // 获取请求结果

        // 设置附加HTTP头
        $add_head = array("Content-type: application/json");
        // 初始化curl，当然，你也可以用fsockopen代替
        $curl_obj = curl_init();
        // 设置网址
        curl_setopt($curl_obj, CURLOPT_URL, $url);
        // 附加Head内容
        curl_setopt($curl_obj, CURLOPT_HTTPHEADER, $add_head);
        // 是否输出返回头信息
        curl_setopt($curl_obj, CURLOPT_HEADER, 0);
        // 将curl_exec的结果返回
        curl_setopt($curl_obj, CURLOPT_RETURNTRANSFER, 1);
        // 设置超时时间
        curl_setopt($curl_obj, CURLOPT_TIMEOUT, 30);
        // 执行
        $result = curl_exec($curl_obj);
        // 关闭curl回话
        curl_close($curl_obj);

        // 解析json
        $json = json_decode($result);

        // 异常情况返回false
        if (isset($json->error) || !isset($json[0]->url_short) || $json[0]->url_short == '') {
            return '';
        } else {
            return $json[0]->url_short;
        }
    }


}