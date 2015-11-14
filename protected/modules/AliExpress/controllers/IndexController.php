<?php

/**
 * Created by PhpStorm.
 * User: john
 * Date: 2015/10/15
 * Time: 16:58
 */
class IndexController extends CController{

    public function actionIndex(){
        /**
         * @var $request CHttpRequest
         * @var $sessiion CHttpSession
         */
        phpinfo();
//        $request = Yii::app()->getRequest();
//        $code = $request->getQuery('code','');
//        if(empty($code))
//        {
//            $configArray = CConfigHelper::getConfig('stores');
//            $config = $configArray['lc'];
//            $this->redirect(Yii::app()->aliExpress->getCode($config,$request->getHostInfo().$this->createUrl('aliExpress')));
//        }
//        else
//        {
//            $sessiion = Yii::app()->getSession();
//            $sessiion -> add('code',$code);
//        }

    }

    public function actionRefreshToken()
    {

    }
}