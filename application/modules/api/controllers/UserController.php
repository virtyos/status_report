<?php
class UserController extends ApiController {
  
  public function filters() {
    return array(
      array('AuthTokenFilter'),
      array('AdminFilter + create, delete');
    );
  }
  
  public actionRole() {
    $this->resultStatus = self::RESULT_SUCCESS;
    $this->resultData = array(
      'user_role' =>$this->currentUser->role
    );
    $this->sendResult();    
  }
  
  public actionCreate() {
    $user = new User;
    $data = Yii::app()->request->getaParam('User');
    $user->setAttributes($data);
    if ($user->save()) {
      $this->resultStatus = self::RESULT_SUCCESS;
    } else {  
      $this->resultStatus = self::RESULT_ERROR;
      $this->resultErrorMessage = $user->getFirstError();
    }
    $this->sendResult();  
  }
  
  public actionEdit() {
    $data = Yii::app()->request->getaParam('User');
    if (!$data['id']) {
      $this->resultStatus = self::RESULT_ERROR;
      $this->resultErrorMessage = 'Нет id';
    } else {
      $user = new User::model()->findByPk($data['id']);
      $user->setAttributes($data);
      if ($user->save()) {
        $this->resultStatus = self::RESULT_SUCCESS;
      } else {  
        $this->resultStatus = self::RESULT_ERROR;
        $this->resultErrorMessage = $user->getFirstError();
      }
    }
    $this->sendResult();  
  }
  
  public actionDelete() {
    $userId = Yii::app()->request->getaParam('id');
    $result = User::model()->deleteByPk($userId); 
    if ($result > 0) {
      $this->resultStatus = self::RESULT_SUCCESS;
    } else {
      $this->resultStatus = self::RESULT_ERROR;
      $this->resultErrorMessage = 'Ни одного юзера не удалено';
    }
    $this->sendResult();  
  }
  
  public actionShow() {
    $userId = Yii::app()->request->getaParam('id');
    $user = User::model()->findByPk($userId); 
    if (!$user) {
      Yii::app()->request->redirect('/api/error/notFound');
    }
  }
  
}