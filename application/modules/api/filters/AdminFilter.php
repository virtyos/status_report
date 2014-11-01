<?php
class AdminFilter extends CFilter {
  protected function preFilter($filterChain) {
    if (Yii::app()->controller->currentUser->role !== 'admin') {
      Yii::app()->request->redirect('/api/error/forbidden');
      return false;
    }
    return true;
  }
 
  protected function postFilter($filterChain) {
  }
}