<?php

class LoginController extends AppController {

  public function actionIndex() {
    $model = new LoginForm;
    if ($_POST) {
      $model->attributes = $_POST['LoginForm'];
      if ($model->validate()) {
        if ($model->login()) {
          $timezone = $_POST['timezone'];
          if ($timezone) {
            $user = User::model()->findByPk(Yii::app()->user->id);
            if ($user) {
              $user->timezone = $timezone;
              $user->save();
            }
          }
          $this->redirect('/user/show');
        }
      }
    }

    $this->render('index', array('model' => $model));
  }


  public function actionLogout() {
    Yii::app()->user->logout();
    $this->redirect('/');
  }
  
  

}