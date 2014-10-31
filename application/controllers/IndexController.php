<?php

class IndexController extends AppController
{
  public function actionIndex() {
    if (isset(Yii::app()->user->id)) {
      $this->redirect('/user/show');
    } else {
      $this->redirect('/login');
    }
  }

}