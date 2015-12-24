<?php

/**
 *
 * @desc       CModelHelper.php file.
 *
 * @author     Qiu Xincai <qiuxc@eileengrays.com>
 * @link       http://www.eileengrays.com/
 * @copyright  EileenGrays.Com 2013-2015
 * @license    http://www.eileengrays.com/
 */
class CModelHelper
{
    public static function getError(CActiveRecord $model)
    {
        $errors = $model->getErrors();
        $key = array_keys($errors);
        return $errors[current($key)];
    }

    public static function indexField($fieldName,$index)
    {
        return sprintf("[%d]%s",$index,$fieldName);
    }
}