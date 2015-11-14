<?php

/**
 *
 * @desc       ArrayHelper.php file.
 *
 * @author     Qiu Xincai <qiuxc@eileengrays.com>
 * @link       http://www.eileengrays.com/
 * @copyright  EileenGrays.Com 2013-2015
 * @license    http://www.eileengrays.com/
 */

class CArrayHelper
{
    public function getOrderArray($array,$name)
    {

    }


    /**
     * 组装URL参数
     * @param $array
     * @return string
     */
    public static function buildQuery($array)
    {
        if(is_array($array))
        {
            if(function_exists('http_build_query'))
            {
                $query = http_build_query($array);
            }
            else
            {
                $query = '';
                foreach($array as $key => $value)
                {
                    $query .= implode('=',array($key,$value));
                }
            }
        }
        else
        {
            $query = $array;
        }

        return $query;
    }

}