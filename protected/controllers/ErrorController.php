<?php

/**
 * Created by PhpStorm.
 * User: john
 * Date: 2015/10/9
 * Time: 11:30
 */
class ErrorController extends Controller
{
    public function actionIndex()
    {
        if($error=Yii::app()->errorHandler->error)
        {
            if(Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('index', $error);
        }
    }
}