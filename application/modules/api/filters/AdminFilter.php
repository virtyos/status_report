<?php
class AdminFilter extends CFilter {
  protected function preFilter($filterChain) {
    if ($this->currentUser->role !== 'admin')) {
      Yii::app()->request->redirect('/api/error/forbidden');
      return false;
    }
    return true;
  }
 
  protected function postFilter($filterChain) {
  }
}