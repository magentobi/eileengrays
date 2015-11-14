<?php

/**
 *
 * @desc       UserController.php file.
 *
 * @author     Qiu Xincai <qiuxc@eileengrays.com>
 * @link       http://www.eileengrays.com/
 * @copyright  EileenGrays.Com 2013-2015
 * @license    http://www.eileengrays.com/
 */
class UserController extends Controller
{
    public function actionLogin()
    {
        $this->layout = 'empty';
        if (!Yii::app()->user->isGuest) {
            $this->redirect($this->createUrl('index'));
        }
        $model = new LoginForm;
        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login()) {
                $url = Yii::app()->createUrl('site/index');
                $this->redirect($url);
            }
        }

        // display the login form
        $this->renderPartial('login', array('model' => $model));
    }
}