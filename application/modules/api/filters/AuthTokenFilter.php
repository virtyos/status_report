<?php
class AuthTokenFilter extends CFilter {
  protected function preFilter($filterChain) {
    if (!Yii::app()->controller->authToken || !Yii::app()->controller->currentUser) {
      Yii::app()->request->redirect('/api/error/nologin');
      return false;
    }
    return true;
  }
 
  protected function postFilter($filterChain) {
  }
}