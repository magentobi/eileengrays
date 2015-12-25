<?php

/**
 *
 * @desc SiteController.php file.
 *
 * @author Qiu Xincai <qiuxc@eileengrays.com>
 * @link http://www.eileengrays.com/
 * @copyright  EileenGrays.Com 2013-2015
 * @license http://www.eileengrays.com/
 */
class SiteController extends Controller
{
    public function actionIndex(){

    }

    public function actionLogin(){

    }

    public function actionLogout(){

    }

    public function actionAmazon(){

        $cookie = tempnam('./temp','cookie');
        //登陆页面URL
        $url = 'https://www.amazon.cn/ap/signin?_encoding=UTF8&openid.assoc_handle=cnflex&openid.claimed_id=http%3A%2F%2Fspecs.openid.net%2Fauth%2F2.0%2Fidentifier_select&openid.identity=http%3A%2F%2Fspecs.openid.net%2Fauth%2F2.0%2Fidentifier_select&openid.mode=checkid_setup&openid.ns=http%3A%2F%2Fspecs.openid.net%2Fauth%2F2.0&openid.ns.pape=http%3A%2F%2Fspecs.openid.net%2Fextensions%2Fpape%2F1.0&openid.pape.max_auth_age=0&openid.return_to=https%3A%2F%2Fwww.amazon.cn%2F%3Fie%3DUTF8%26openid.pape.max_auth_age%3D0%26openid.return_to%3Dhttps%253A%252F%252Flocalhost%252Fsite%252Famazon%253Fref_%253Dnav_signin%26openid.identity%3Dhttp%253A%252F%252Fspecs.openid.net%252Fauth%252F2.0%252Fidentifier_select%26openid.assoc_handle%3Dcnflex%26_encoding%3DUTF8%26openid.mode%3Dcheckid_setup%26openid.ns.pape%3Dhttp%253A%252F%252Fspecs.openid.net%252Fextensions%252Fpape%252F1.0%26openid.claimed_id%3Dhttp%253A%252F%252Fspecs.openid.net%252Fauth%252F2.0%252Fidentifier_select%26openid.ns%3Dhttp%253A%252F%252Fspecs.openid.net%252Fauth%252F2.0%26ref_%3Dnav_signin';
        $this->get($url,$cookie);
        //登陆提交参数
        $data = array(
            'appActionToken'=>'s78Du4a2IBogj2Fktztwj2B8dDXZBj2Boj3D',
            'appAction' => 'SIGNIN',
            'openid.pape.max_auth_age'=>'ape:MA==',
            'openid.return_to'=>'ape:aHR0cHM6Ly93d3cuYW1hem9uLmNuL2dwL3lvdXJzdG9yZS9ob21lP2llPVVURjgmYWN0aW9uPXNpZ24tb3V0JnBhdGg9JTJGZ3AlMkZ5b3Vyc3RvcmUlMkZob21lJnJlZl89bmF2X19nbm9fc2lnbm91dCZzaWduSW49MSZ1c2VSZWRpcmVjdE9uU3VjY2Vzcz0x',
            'prevRID'=>'ape:SjU2WFhWVzhNV1gySlhFUVpYMDQ=',
            'openid.identity'=>'ape:aHR0cDovL3NwZWNzLm9wZW5pZC5uZXQvYXV0aC8yLjAvaWRlbnRpZmllcl9zZWxlY3Q=',
            'openid.assoc_handle'=>'ape:Y25mbGV4',
            'openid.mode'=>'ape:Y2hlY2tpZF9zZXR1cA==',
            'openid.ns.pape'=>'ape:aHR0cDovL3NwZWNzLm9wZW5pZC5uZXQvZXh0ZW5zaW9ucy9wYXBlLzEuMA==',
            'openid.claimed_id'=>'ape:aHR0cDovL3NwZWNzLm9wZW5pZC5uZXQvYXV0aC8yLjAvaWRlbnRpZmllcl9zZWxlY3Q=',
            'pageId'=>'ape:Y25mbGV4',
            'openid.ns'=>'ape:aHR0cDovL3NwZWNzLm9wZW5pZC5uZXQvYXV0aC8yLjA=',
            'email'=>'sourcode@163.com',
            'create'=>'0',
            'password'=>'123456789',
            'metadata1'=>'xH/IUluVa2t7B7utRrZBCrTGMut/JXkPdNV/AQ4Gd77f5JjTyOQCqRqdD/gHv5YFmkEIYpBcEXR0/PXIGTiz6ywdJK8Yk+LxqlD3TkUPfbcAdJtjahvr/iZzDfUk4tpcAH7tCyWKHbEOYfUV2jxOO9zxesNDfk4FdZnCSbpf4SHYKOYpxX7qsnyDHV9jHDFK++2dALoe/capkCtfwCyjSJ7nSEvJbGZhVcnDXXxY8ooNyhiuu5Mxt/uevRfceJvWKl/SdT76MC565gdR7dMCRY0S8bKwIovIiIiEvXAbPklXv+LTzfbPFs9G3JeIxUKxr6wkoTxUnMb76jew51aXTzuuhfUq6L/GBwzHVR5lvyCKILPmAjShH9tIwm3uJjNpyVLewJJkWkpU8FyAXgBeaVAl5X+LqI1tRun3ji/6AwMlCbuspbE6WvF+NWo6aCWSuKcP48m7mRF+OZNzltlKF08tTOk5OPzlGOyvt2YX9SSPD+EWQG+gRcv3Qb9v2JocKt+v2Ggk6D51DQquVwaJ+ekh8J/nHDYn8dOJV1lbVpJJJXoPoqAGfmRxOpE9Kuo2eIg7+GE63d0mBYyOmG04uPXhuPdIGvo9ObxzOh4dp8Z6dE+25SgGDdx3MIjM6y6AaCj89TPpLfsoPL0m/rmjiJbKq5T6HjkLKqmrLZuUS3PlixkKQaQBJO3uNcWYI4XqPXrI4X4EVj2DApZC0vo39eIcM/kYkvV2JiP/TT5785FQiXrrnfrgK+GMvsdSk2NvLibC6HlWhlRC7ETxPDiixazo5+kQCCkHQ6aIsB6YtWoCmmj1iAaFsw=='
        );

        //登陆提交地址
        $url = 'https://www.amazon.cn/ap/signin?ie=UTF8&pf_rd_r=KS3DEQDQDS8YCHKBXAFG&pf_rd_m=A1AJ19PSB66TGU&pf_rd_t=6301&pf_rd_i=cnflex&pf_rd_p=66012152&pf_rd_s=signin-slot';
        $content = $this->post($url,$data,$cookie);
        print_r($content);

    }


    protected function post($url,$data,$cookie){
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,CArrayHelper::buildQuery($data));
        curl_setopt($ch,CURLOPT_HEADER,1);
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,0);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
        $this->test($ch);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result =  curl_exec($ch);
        print_r(curl_error($ch));
        return $result;
    }

    protected function get($url,$cookie){
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
        return curl_exec($ch);
    }

    protected function saveCookie($cookie){

    }

    protected function test($ch){
        return curl_setopt($ch,CURLOPT_HTTPHEADER,array(
            'Cache-Control:max-age=0, no-cache, no-store, must-revalidate',
            'Connection:keep-alive',
            'Content-Encoding:gzip',
            'Content-Type:text/html;charset=UTF-8',
            'Date:Fri, 25 Dec 2015 10:55:36 GMT',
            'Expires:Thu, 01 Jan 1970 00:00:00 GMT',
            'Pragma:No-cache',
            'Server:Server',
            'Set-Cookie:at-main=-; path=/; domain=.www.amazon.cn; expires=Thu, 25-Dec-2003 10:55:36 GMT',
            'Set-Cookie:session-id=-; path=/; domain=.www.amazon.cn; expires=Thu, 25-Dec-2003 10:55:36 GMT',
            'Set-Cookie:ubid-acbcn=480-4002145-2360620; Domain=.amazon.cn; Expires=Thu, 20-Dec-2035 10:55:36 GMT; Path=/',
            'Set-Cookie:session-id-time=-; path=/; domain=.www.amazon.cn; expires=Thu, 25-Dec-2003 10:55:36 GMT',
            'Set-Cookie:session-token=-; path=/; domain=.www.amazon.cn; expires=Thu, 25-Dec-2003 10:55:36 GMT',
            'Set-Cookie:ubid-acbcn=-; path=/; domain=.www.amazon.cn; expires=Thu, 25-Dec-2003 10:55:36 GMT',
            'Set-Cookie:a-ogbcbff=deleted; Domain=.amazon.cn; Expires=Thu, 01-Jan-1970 00:00:10 GMT; Path=/',
            'Set-Cookie:x-acbcn=-; path=/; domain=.www.amazon.cn; expires=Thu, 25-Dec-2003 10:55:36 GMT',
            'Set-Cookie:UserPref=-; path=/; domain=.www.amazon.cn; expires=Thu, 25-Dec-2003 10:55:36 GMT',
            'Set-Cookie:ap-fid=""; Domain=.amazon.cn; Expires=Thu, 01-Jan-1970 00:00:10 GMT; Path=/ap/; Secure',
            'Transfer-Encoding:chunked',
            'Vary:Accept-Encoding,User-Agent',
            'X-Frame-Options:SAMEORIGIN',
        ));
    }

}