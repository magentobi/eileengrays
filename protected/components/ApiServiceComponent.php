<?php

/**
 *
 * @desc       ApiServiceComponent.php file.
 *
 * @author     Qiu Xincai <qiuxc@eileengrays.com>
 * @link       http://www.eileengrays.com/
 * @copyright  EileenGrays.Com 2013-2015
 * @license    http://www.eileengrays.com/
 */
abstract class ApiServiceComponent extends CApplicationComponent
{
    protected function beforeGetOrders(){
        if($this->hasEventHandler('onBeforeGetOrders')){
            $event = new OrderBehavior();
            $this->onAfterGetOrders($event);
            return $event;
        }
        return false;
    }
    protected function afterGetOrders(){

    }
    protected function beforeGetOrder(){

    }
    protected function afterGetOrder(){

    }
    protected function beforeGetOrderItem(){

    }
    protected function afterGetOrderItem(){

    }

    protected function onBeforeGetOrders($event){
        $this->raiseEvent('onBeforeGetOrders',$event);
    }
    protected function onAfterGetOrders($event){
        $this->raiseEvent('onAfterGetOrders',$event);
    }
    protected function onBeforeGetOrder($event){
        $this->raiseEvent('onBeforeGetOrder',$event);
    }
    protected function onAfterGetOrder($event){
        $this->raiseEvent('onAfterGetOrder',$event);
    }
    protected function onBeforeGetOrderItem($event){
        $this->raiseEvent('onBeforeGetOrderItem',$event);
    }
    protected function onAfterGetOrderItem($event){
        $this->raiseEvent('onAfterGetOrderItem',$event);
    }
}