<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2015/10/9
 * Time: 17:54
 */

$ch = curl_init("https://www.baidu.com");
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
curl_exec($ch);
var_dump(curl_error($ch));
var_dump(curl_errno($ch));