<?
class AdminAppFilter extends CFilter
{
  protected function preFilter($filterChain)
  {
    if (Yii::app()->user->role != 'admin') {
      Yii::app()->request->redirect('/login');
    }
    return true;
  }

  protected function postFilter($filterChain)
  {
  }
}