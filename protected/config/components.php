<?php
/**
 *
 * @desc       db.php file.
 *
 * @author     Qiu Xincai <qiuxc@eileengrays.com>
 * @link       http://www.eileengrays.com/
 * @copyright  EileenGrays.Com 2013-2015
 * @license    http://www.eileengrays.com/
 */
 
return array(
    'db' => array(
        'connectionString' => 'mysql:host=localhost;dbname=test',
        'emulatePrepare' => true,
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
        'tablePrefix' => '',
    ),
    'log' => array(
        'class' => 'CLogRouter',
        'routes' => array(
            array(
                'class' => 'CFileLogRoute',
                'levels' => 'error, warning',
                'logFile' => 'application-'.date('Y-m-d').'.log'
            ),
            // uncomment the following to show log messages on web pages
            /*
            array(
                'class'=>'CWebLogRoute',
            ),
            */
        ),
    ),
);