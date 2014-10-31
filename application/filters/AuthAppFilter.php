<?
class AuthAppFilter extends CFilter
{
  protected function preFilter($filterChain)
  {

    if (!isset(Yii::app()->user->id)) {
      Yii::app()->request->redirect('/login');
    }

    return true;
  }

  protected function postFilter($filterChain)
  {
  }
}