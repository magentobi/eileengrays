<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Eileen Grays',

    // preloading 'log' component
    'preload' => array('log'),
    'behaviors' => array(
        'application'=>array(
            'class'=>'ext.behaviors.ApplicationBehavior'
        )
    ),

    'theme' => 'metis',

    'modules' => require(dirname(__FILE__) . '/modules.php'),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.utils.*',
    ),

    'sourceLanguage'=>'en_us',
//    'language'=>'zh_cn',
    'defaultController' => 'index',
    // application components
    'components' => CMap::mergeArray(require(dirname(__FILE__) . '/components.php'),array(
        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
        ),
//        'errorHandler' => array(
//            // use 'site/error' action to display errors
//            'errorAction' => 'error/index',
//        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => require(dirname(__FILE__) . '/rules.php'),
        ),
        'clientScript'=>array(
            'corePackages' => array(
                'jquery' => array(
                    'baseUrl' => '//cdn.bootcss.com/jquery/1.11.3/',
                    'js' => array('jquery.min.js')
                )
            ),
            'packages' => require(dirname(__FILE__) . '/packages.php'),
            'scriptMap' => array(
//                'jquery.js' => '//cdn.bootcss.com/jquery/1.11.3/jquery.min.js',
//                'jquery.min.js' => '//cdn.bootcss.com/jquery/1.11.3/jquery.min.js'
            ),
        ),
    )) ,

    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => require(dirname(__FILE__) . '/params.php'),
);