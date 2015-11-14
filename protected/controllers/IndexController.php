<?php

class IndexController extends Controller
{
    public function actionIndex(){
//        $this->layout = 'main';
//        /**
//         * @var $app CWebApplication
//         */
//        $app = Yii::app();
//        $app->getClientScript()->registerCoreScript('jquery',CClientScript::POS_READY);
//        echo Yii::app()->language;
//        echo Yii::t('app','x');
//        $this->render('index');

        $url = 'https://passport.jd.com/uc/login';
        $ch = curl_init($url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        $data = curl_exec($ch);
        var_dump($data);
    }
}