<?php
header("Content-type: text/html; charset=utf-8");
date_default_timezone_set('PRC');
// change the following paths if necessary
$yii=dirname(__FILE__).'/../../../framework/yii.php';
$config=dirname(__FILE__).'/../protected/config/main.php';

// remove the following line when in production mode
// defined('YII_DEBUG') or define('YII_DEBUG',true);

require_once($yii);
Yii::createWebApplication($config)->run();
