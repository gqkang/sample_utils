<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 16/5/25
 * Time: 下午9:56
 */

// 测试长链接转短链接
include(dirname(__FILE__).'/../../src/util/HttpHelper.php');

$long_url = 'https://github.com/gqkang/sample_utils';

$short_url = HttpHelper::convertToShortUrl($long_url);

echo $short_url;
echo "\n";