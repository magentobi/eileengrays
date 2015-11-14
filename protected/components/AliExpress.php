<?php

/**
 * Created by PhpStorm.
 * User: john
 * Date: 2015/10/15
 * Time: 17:01
 */
class AliExpress extends ApiComponent
{

    CONST SITE = 'aliexpress';

    CONST API = 'gw.api.alibaba.com/openapi/';
    /**
    在国际交易开放平台，url请求的多个参数都要参与签名（与文件上传有关的api中，文件字节流那个参数不参与签名），下面以两个参数为例，假设请求的url格式如下所示：
    http://gw.api.alibaba.com/openapi/param2/1/system/currentTime/1000000?b=2&a=1（appKey=1000000，假设secretKey=test123）

    参照签名算法说明，签名串s组装规则为：
    1、 构造签名因子：urlPath。url 中的一部分，我们称之为urlPath，从协议（param2）开始截取，到“?”为止，urlPath=param2/1/system/currentTime/1000000
    2、 构造签名因子：拼装的参数。参数 b=2&a=1，首先将参数的key和value拼在一起，得到b2和a1，然后按照首字母排序，得到a1和b2，最后按顺序拼在一起得到a1b2
    3、 合并两个签名因子。把前两步的字符串拼起来，得到s = param2/1/system/currentTime/1000000a1b2
    4、 对合并后的签名因子执行hmac_sha1算法。 Signature=uppercase (hex (hmac_sha1 (s, secretKey)) 得到签名33E54F4F7B989E3E0E912D3FBD2F1A03CA7CCE88
    ——secretKey为签名密钥，与urlPath中的appKey（1000000）对应
    ——hmac_sha1为通用的hmac_sha1算法，各编程语言一般都对应类库
    ——hex为转为十六进制
    ——uppercase为转为大写字符

    说明：API签名算法主要是使用urlPath和请求参数作为签名因子进行签名，主要针对api 调用
     */

    /**
     * @param $config
     * @param $urlPath
     * @param $params
     * @return string
     */
    protected function generateCodeSign($config,$urlPath,$params)
    {
        $paramStr = '';

        if(is_string($params))
        {
            $paramStr = str_replace(array('&','='),'',$params);
        }

        if(is_array($params))
        {
            ksort($params);
            foreach($params as $key => $value)
            {
                $paramStr.=$key.$value;
            }
        }

        $signStr = $urlPath.$paramStr;

        $codeSign = strtoupper(bin2hex(hash_hmac("sha1", $signStr, $config['appSecret'], true)));

        return $codeSign;
    }

    /**

    1) 用户使用app，访问在速卖通的隐私数据
    2) app发起授权请求
    http://authhz.alibaba.com/auth/authorize.htm?client_id=xxx&site=aliexpress&redirect_uri=YOUR_REDIRECT_URL&state=YOUR_PARM&_aop_signature=SIGENATURE
    a) client_id：app注册时，分配给app的唯一标示，又称appKey
    b) site:site参数标识当前授权的站点，直接填写aliexpress
    c) redirect_uri: app的入口地址，授权临时令牌会以queryString的形式跟在该url后返回
    d) state：可选，app自定义参数，回跳到redirect_uri时，会原样返回
    e) aop_signature：签名
    参数签名(_aop_signature)为所有参数key + value 字符串拼接后排序，把排序结果拼接为字符串data后通过bytesToHexString(HAMC-RSA1(data, appSecret))计算签名。 验证签名的方式为对参数执行同样的签名，比较传入的签名结果和计算的结果是否一致，一致为验签通过。
    注：只有客户端和WEB端授权流程发起授权请求这一步使用参数签名串组装规则，只用url请求参数作为签名因子；其他签名均需加入urlPath作为额外因子（见API签名串组装规则）。
    3) 用户输入用户名密码，并确认授权
    4) 返回临时授权码code给app
    具体返回方式，参照redirect_uri说明
    5) 使用code获取令牌
    https://gw.api.alibaba.com/openapi/http/1/system.oauth2/getToken/YOUR_APPKEY?grant_type=authorization_code&need_refresh_token=true&client_id= YOUR_APPKEY&client_secret= YOUR_APPSECRET&redirect_uri=YOUR_REDIRECT_URI&code=CODE
    注：此接口必须使用POST方法提交；必须使用https
    getToken接口参数说明：
    a) grant_type为授权类型，使用authorization_code即可
    b) need_refresh_token为是否需要返回refresh_token，如果返回了refresh_token，原来获取的refresh_token也不会失效，除非超过半年有效期
    c) client_id为app唯一标识，即appKey
    d) client_secret为app密钥
    e) redirect_uri为app入口地址
    f) code为授权完成后返回的一次性令牌
    g) 调用getToken接口不需要签名
    注：如果超过code有效期（2分钟）或者已经使用code获取了一次令牌，code都将失效，需要返回第二步重新获取code
    6) 返回令牌
    getToken返回结果：{"aliId":"8888888888","resourceOwner":"xxx","expires_in":"36000","access_token":"8795258a-6c8f-43a5-b8d0-763631edb610","refresh_token":"8795258a-6c8f-43a5-b8d0-763631edb610","refresh_token_timeout":"20121222222222+0800"}
    说明：resource_owner为登录id，aliId为阿里巴巴集团统一的id，refresh_token_timeout表示refreshToken的过期时间
    7) 使用令牌访问用户隐私数据
    例如访问以下api：http://gw.api.alibaba.com/openapi/param2/1/aliexpress.open/api.findAeProductById/1?productId=xxx&access_token=ACCESS_TOKEN&_aop_signature=SIGENATURE
    签名示例见API签名规则

     */
    /**
     * @desc 根据配置文件和CODE获取AccessToken接口
     * @param $config
     * @param $code
     * @param $redirectUrl
     * @return mixed
     */
    protected function getToken($config,$code,$redirectUrl)
    {
        $urlPath = 'http/1/system.oauth2/getToken/' . $config['appKey'];

        $getTokenUrl = ApiComponent::HTTPS_SCHEMA.AliExpress::API.$urlPath;

        $data = CArrayHelper::buildQuery(array(
            'grant_type' => 'authorization_code',
            'need_refresh_token' => true,
            'client_id' => $config['appKey'],
            'client_secret' => $config['appSecret'],
            'redirect_uri' => $redirectUrl,
            'code' => $code
        ));

        $response = $this->post($getTokenUrl,$data,array(
            CURLOPT_SSL_VERIFYPEER => false
        ));

        $object = json_decode($response);

        return $object->accessToken;
    }

    /**
     * @desc 根据配置文件获取CODE CODE用来获取Token
     * @param $config
     * @param $redirectUrl
     * @return string
     */
    public function getCode($config,$redirectUrl)
    {
        $options = array(
            'client_id' => $config['appKey'],
            'redirect_uri' => urlencode($redirectUrl),
            'site' => AliExpress::SITE
        );

        $codeSign = $this->generateCodeSign($config, '', $options);
        $options['_aop_signature'] = $codeSign;

        $query = CArrayHelper::buildQuery($options);

        return "http://gw.api.alibaba.com/auth/authorize.htm?".$query;

    }

    /**
     * 跟新refreshToken
     * @param $config
     * @param $accessToken
     * @param $refreshToken
     * @return mixed
     */
    protected function postponeToken($config,$accessToken,$refreshToken)
    {

        $urlPath = 'param2/1/system.oauth2/postponeToken/' . $config['appKey'];

        $url = ApiComponent::HTTPS_SCHEMA.AliExpress::API.$urlPath;

        $data = array(
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
            'client_id' => $config['appKey'],
            'client_secret' => $config['appSecret']
        );

        $timeout = 5;
        $response = $this->post($url,$data);

        return $response;
    }

    /**
     * 获取订单列表
     * @param        $config
     * @param        $accessToken
     * @param string $createDateStart
     * @param int    $page
     * @param int    $pageSize
     * @return mixed
     */
    public function findOrderListQuery($config,$accessToken,$createDateStart = '12/21/2014 00:00:00',$page = 1,$pageSize = 50)
    {
        $urlPath = "param2/1/aliexpress.open/api.findOrderListQuery/" . $config['appKey'];

        $url = ApiComponent::HTTP_SCHEMA.AliExpress::API.$urlPath;

        $options = array(
            'access_token' => $accessToken,
            'page' => $page,
            'pageSize' => $pageSize,
            'createDateStart' => $createDateStart
        );

        $codeSign = $this->generateCodeSign($config, $urlPath, $options);

        $options['_aop_signature'] = $codeSign;

        $data = CArrayHelper::buildQuery($options);

        return $this->post($url,$data,array(
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_SSL_VERIFYPEER => false
        ));
    }

    public function findOrderById($config,$accessToken,$orderId = '66893916986695')
    {

        $urlPath = "param2/1/aliexpress.open/api.findOrderById/" . $config['appKey'];

        $url = ApiComponent::HTTP_SCHEMA.AliExpress::API.$urlPath;

        $options = array(
            'access_token' => $accessToken,
            'orderId' => $orderId
        );

        $codeSign = $this->generateCodeSign($config, $urlPath, $options);

        $options['_aop_signature'] = $codeSign;

        $data = CArrayHelper::buildQuery($options);

        return $this->post($url,$data,array(
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_SSL_VERIFYPEER => false
        ));
    }

    public function findOrderListSimpleQuery($config,$accessToken,$createDateStart = '2014-12-04',$page = 1,$pageSize = 100)
    {

        $urlPath = 'param2/1/aliexpress.open/api.findOrderListSimpleQuery/' . $config['appKey'];

        $url = ApiComponent::HTTP_SCHEMA.AliExpress::API.$urlPath;
//        $url = 'http://gw.api.alibaba.com/openapi/param2/1/aliexpress.open/api.findOrderListSimpleQuery/' . $appKey; //接口URL
//        $data = 'access_token=' . $access_token . '&page=1&pageSize=100&createDateStart=2014-12-04'; //准备POST参数 page=1&pageSize=100&createDateStart=2014-12-04&access_token=ef69cc45-bfa1-4802-a35e-ee233ac99bb5&_aop_signature=C24C71C005C0EEC62EB9DDF98C7A071934505F4D
        $data = array(
            'access_token' => $accessToken,
            'page' => $page,
            'pageSize' => $pageSize,
            'createDateStart' => $createDateStart
        );

        return $this->post($url,$data,array(
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_SSL_VERIFYPEER => false
        ));
    }

    public function findOrderReceiptInfo($config,$accessToken,$orderId)
    {
//        $url = 'http://gw.api.alibaba.com/openapi/param2/1/aliexpress.open/api.findOrderReceiptInfo/' . $appKey; //接口URL
//        $data = 'access_token=' . $access_token . '&orderId=65150145825523'; //准备POST参数 page=1&pageSize=100&createDateStart=2014-12-04&access_token=ef69cc45-bfa1-4802-a35e-ee233ac99bb5&_aop_signature=C24C71C005C0EEC62EB9DDF98C7A071934505F4D

        $urlPath = 'param2/1/aliexpress.open/api.findOrderReceiptInfo/' . $config['appKey'];

        $url = ApiComponent::HTTP_SCHEMA.AliExpress::API.$urlPath;

        $data = array(
            'access_token' => $accessToken,
            'orderId' => $orderId,
        );

        return $this->post($url,$data,array(
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_SSL_VERIFYPEER => false
        ));

    }

    public function findAeProductById($config,$accessToken,$productId)
    {

//        $url = 'http://gw.api.alibaba.com/openapi/param2/1/aliexpress.open/api.findAeProductById/' . $appKey; //接口URL
//        $data = 'access_token=' . $access_token . '&productId=1956492979'; //准备POST参数

        $urlPath = 'param2/1/aliexpress.open/api.findAeProductById/' . $config['appKey'];

        $url = ApiComponent::HTTP_SCHEMA.AliExpress::API.$urlPath;

        $data = array(
            'access_token' => $accessToken,
            'productId' => $productId,
        );

        return $this->post($url,$data,array(
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_SSL_VERIFYPEER => false
        ));


    }

    public function postProduct($config,$accessToken,$product)
    {
        $urlPath = "param2/1/aliexpress.open/api.postAeProduct/".$config['appKey'].'?access_token=' . $accessToken;

        $url = ApiComponent::HTTP_SCHEMA.AliExpress::API.$urlPath;

        $re =  $this->post($url,$product,array(
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_SSL_VERIFYPEER => false
        ));

        $result = json_decode($re, true);
        var_dump($result);
        header("Content-type: text/html; charset=utf-8");
        if ($result['success']) {
            echo '第'.$result['productId'].'上传成功！' . $result['productId'].'<br/>';
        } else {
            echo $product['model'];
            throw new Exception("错误代码:" . $result['error_code']);
//        exit();
        }
    }

    public function refreshToken($config,$refreshToken)
    {
//        $getTokenUrl = 'https://gw.api.alibaba.com/openapi/param2/1/system.oauth2/refreshToken/' . $appKey;
//        $data = 'grant_type=refresh_token&refresh_token=' . $refreshToken . '&client_id=' . $appKey . '&client_secret=' . $appSecret . '&_aop_signature=' . $code_sign;

        $urlPath = 'param2/1/system.oauth2/refreshToken/' . $config['appKey'];
        $url = ApiComponent::HTTPS_SCHEMA.AliExpress::API.$urlPath;

        $options = array(
            'client_id' => $config['appKey'],
            'grant_type' => 'refresh_token',
            'client_secret' => $config['appSecret'],
            'refresh_token' => $refreshToken
        );

        $codeSign = $this->generateCodeSign($config,$urlPath,$options);

        $options['_aop_signature'] = $codeSign;

        $data = CArrayHelper::buildQuery($options);

        return $this->post($url,$data,array(
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_SSL_VERIFYPEER => false
        ));

    }

    public function sellerShipment($config,$accessToken,$serviceName,$logisticsNo,$sendType,$outRef)
    {
        $urlPath = 'param2/1/aliexpress.open/api.sellerShipment/' . $config['appKey'].'?access_token='.$accessToken;
        $url = ApiComponent::HTTP_SCHEMA.AliExpress::API.$urlPath;

        $options = array(
            'access_token' => $accessToken,
            'serviceName' => $serviceName,
            'logisticsNo' => $logisticsNo,
            'sendType' => $sendType,
            'outRef' => $outRef
        );

        $codeSign = $this->generateCodeSign($config, $urlPath, $options);

        $options['_aop_signature'] = $codeSign;

        $data = CArrayHelper::buildQuery($options);

        return $this->post($url,$data,array(
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_SSL_VERIFYPEER => false
        ));
    }

    public function getPostCategoryById($config,$accessToken,$cateId = '380210')
    {
        $urlPath = 'param2/1/aliexpress.open/api.getPostCategoryById/' . $config['appKey'].'?access_token='.$accessToken;
        $url = ApiComponent::HTTP_SCHEMA.AliExpress::API.$urlPath;
        $data = array(
            'cateId' => $cateId
        );
        $this->post($url,$data,array(
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_SSL_VERIFYPEER => false
        ));
    }

    public function getAttributesResultByCateId($config,$accessToken,$cateId = '200000181')
    {
        $urlPath = 'param2/1/aliexpress.open/api.getAttributesResultByCateId/' . $config['appKey'].'?access_token='.$accessToken;
        $url = ApiComponent::HTTP_SCHEMA.AliExpress::API.$urlPath;
        $data = array(
            'cateId' => $cateId
        );
        $this->post($url,$data,array(
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_SSL_VERIFYPEER => false
        ));
    }

    public function listFreightTemplate($config,$accessToken)
    {
        $urlPath = 'param2/1/aliexpress.open/api.listFreightTemplate/' . $config['appKey'].'?access_token='.$accessToken;
        $url = ApiComponent::HTTP_SCHEMA.AliExpress::API.$urlPath;
        $data = array(
        );
        $this->post($url,$data,array(
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_SSL_VERIFYPEER => false
        ));
    }

}