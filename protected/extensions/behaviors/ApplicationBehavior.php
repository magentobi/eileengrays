<?php

/**
 *
 * @desc       ApplicationBehavior.php file.
 *
 * @author     Qiu Xincai <qiuxc@eileengrays.com>
 * @link       http://www.eileengrays.com/
 * @copyright  EileenGrays.Com 2013-2015
 * @license    http://www.eileengrays.com/
 */
class ApplicationBehavior extends CBehavior
{

    public function events()
    {
        return array(
            'onBeginRequest' => 'beginRequest',
            'onEndRequest' => 'endRequest'
        );
    }
    public function beginRequest($event)
    {
        $event->sender->setLanguage(isset($_GET['lang'])?$_GET['lang']:'en_us');
    }

    public function endRequest($event)
    {
    }
}