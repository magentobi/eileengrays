<!DOCTYPE html>
<html xmlns="/www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Eileen Grays DataCenter</title>
        <link href="<?php echo Yii::app()->theme->baseUrl;?>/css/login-box.css" rel="stylesheet" type="text/css" />
    </head>
    <body style="background: #FFF;">
        <center>
            <div style="margin-top: 100px;">
                <div style="margin-bottom: 20px;"><img src="<?php echo Yii::app()->theme->baseUrl;?>/images/logo.jpg" /></div>
                <div id="login-box">

                     <?php
                        $form = $this->beginWidget('CActiveForm', array(
                                    'id' => 'login-form',
                                    'enableAjaxValidation' => true,
                                ));
                        ?>
                        <div style="margin-top:20px;" id="login-box-name">
                            Username:
                        </div>
                        <div style="margin-top:20px;" id="login-box-field">
                            <input maxlength="2048" size="50" value="" title="Username" class="form-login" name="LoginForm[username]">
                        </div>
                    <div style="clear: both;"></div>
                        <div id="login-box-name">Password:</div>
                        <div id="login-box-field">
                            <input type="password" maxlength="2048" size="30" value="" title="Password" class="form-login" name="LoginForm[password]">
                        </div>
                    <div style="clear: both;"></div>
                        <span class="login-box-options">
                            <input type="checkbox" value="1" name="LoginForm[rememberMe]"> Remember Me 
                            <a style="margin-left:30px;" href="#">Forgot password?</a></span>
                        <br>
                        <br>
                       <?php echo CHtml::submitButton('SIGN IN',array('class'=>'login-buttom')); ?>
                       <?php echo $form->error($model, 'username'); ?>
                       <?php echo $form->error($model, 'password'); ?>
                    <?php $this->endWidget(); ?>
                </div>
            </div>
        </center>
    </body>
</html>
