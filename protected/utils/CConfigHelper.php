<?php

/**
 *
 * CConfigHelper class file.
 *
 * @author Qiu Xincai <qiuxc@eileengrays.com>
 * @link http://www.eileengrays.com/
 * @copyright  EileenGrays.Com 2013-2015
 * @license http://www.eileengrays.com/
 */

class CConfigHelper
{
    public static function getConfig($name)
    {
        $params = Yii::app()->params;
        return isset($params[$name]) ? $params[$name] : array();
    }
}