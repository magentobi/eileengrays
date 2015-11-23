<?php
/**
 *
 * @desc       index.php file.
 * @var $form CActiveForm
 * @author     Qiu Xincai <qiuxc@eileengrays.com>
 * @link       http://www.eileengrays.com/
 * @copyright  EileenGrays.Com 2013-2015
 * @license    http://www.eileengrays.com/
 */
?>
<div class="row">
    <div class="col-xs-12">
        <div class="page-header">
            <h1>速卖通授权操作页面<small>这里提供速卖通的授权操作</small></h1>
        </div>
    </div>
</div>

<form class="form-horizontal" method="post">
    <div class="form-group">
        <label for="storeName" class="col-sm-2 control-label">店铺</label>
        <div class="col-sm-10">
            <?php echo CHtml::dropDownList('storeName','',$storesList,array('class'=>'form-control'))?>
        </div>
    </div>
    <div class="form-group">
        <label for="option" class="col-sm-2 control-label">操作</label>
        <div class="col-sm-10">
            <?php echo CHtml::dropDownList('action','',array(
                "getCode"=>"获取令牌授权(需要认证)",
                "refreshToken"=>"刷新令牌授权",
                "postponeToken"=>"更新refreshToken"
            ),array('class'=>'form-control'))?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">提交</button>
        </div>
    </div>
</form>
