<?php

/**
 *
 * @desc       Oauth2Controller.php file.
 *
 * @author     Qiu Xincai <qiuxc@eileengrays.com>
 * @link       http://www.eileengrays.com/
 * @copyright  EileenGrays.Com 2013-2015
 * @license    http://www.eileengrays.com/
 */
class Oauth2Controller extends CController
{
    public function actionIndex()
    {
        /**
         * @var $request CHttpRequest
         */
        $request = Yii::app()->getRequest();
        if($request->getIsPostRequest()){
            $storeName = $request->getPost('storeName');
            $action = $request->getPost('action');
            $this->redirect(array('oauth2/'.$action,'storeName'=>$storeName));
        }
        $this->layout = '/layouts/layouts';
        $stores = Yii::app()->params['aliExpress']['stores'];
        $storesList = array();
        foreach($stores as $store => $config)
        {
            $storesList[$store] = $store;
        }
        $this->render('index',array('storesList'=>$storesList));
    }

    public function actionGetCode()
    {
        /**
         * @var $request CHttpRequest
         * @var $aliExpress AliExpress
         * @var $cache CFileCache
         */
        $request = Yii::app()->getRequest();
        $code = $request->getQuery('code');
        $storeName = $request->getQuery('storeName','aliexpress_lb');
        $config = Yii::app()->params['aliExpress']['stores'][$storeName];
        $config = array('appKey'=>'5757108','appSecret'=>'xAHiXKJXqu');
        $cache = Yii::app()->getCache();

        if($code){
            return $this->redirect($this->createUrl('getToken',array('storeName'=>$storeName,'code'=>$code)));
        }else{
//            if($cache->offsetExists($storeName."_code"))
//            {
//                $code = $cache->offsetGet($storeName."_code");
//                $cache->offsetUnset($storeName."_code");
//                return $this->redirect($this->createUrl('getToken',array('storeName'=>$storeName,'code'=>$code)));
//            }else{
                $redirectUrl = $request->getHostInfo().$this->createUrl('Oauth2/getCode',array('storeName'=>$storeName));
                return $this->redirect(Yii::app()->aliExpress->getCode($config,$redirectUrl));
//            }
        }
    }
    public function actionGetToken()
    {
        /**
         * @var $cache  CFileCache
         * @var $request CHttpRequest
         * @var $aliExpress AliExpress
         */
        header("Content-type: text/html; charset=utf-8");
        $request = Yii::app()->getRequest();
        $storeName = $request->getQuery('storeName','aliexpress_lb');
        $config = Yii::app()->params['aliExpress']['stores'][$storeName];
        $config = array('appKey'=>'5757108','appSecret'=>'xAHiXKJXqu');
        $cache = Yii::app()->getCache();

        $code = $request->getQuery('code');

        if($code){
            $response = (array) Yii::app()->aliExpress->getToken($config,$code,$request->getHostInfo().$this->createUrl('getToken'));
            if(isset($response['error'])){
                echo $response['error_description'];
            }
            print_r($response);
            $cache->set($storeName."_access_token",$response['access_token'],$response['expires_in']);
            echo $response['access_token'];
        }else if($cache->offsetGet($storeName."_access_token")){
            echo $cache->offsetGet($storeName."_access_token");
        }else{
            echo "code 参数必须";
        }
    }

    public function actionRefreshToken(){

    }
    public function actionPostponeToken(){
        /**
         * @var $request CHttpRequest
         * @var $aliExpress AliExpress
         */
        $request = Yii::app()->getRequest();
        $aliExpress = Yii::app()->aliExpress;
        $storeName = $request->getQuery('storeName','aliexpress_lb');
        $config = Yii::app()->params['aliExpress']['stores'][$storeName];
        $cache = Yii::app()->getCache();

//        $result = $aliExpress->postponeToken($config,$accessToken,$refreshToken);
    }



}