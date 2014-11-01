<?php
class UserController extends ApiController {
  
  public function filters() {
    return array(
      array('AuthTokenFilter'),
      array('AdminFilter + create, delete'),
    );
  }
  
  public function actionRole() {
    $this->resultStatus = self::RESULT_SUCCESS;
    $this->resultData = array(
      'user_role' =>$this->currentUser->role
    );
    $this->sendResult();    
  }
  
  
  public function actionEdit() {
    $data = Yii::app()->request->getParam('User');
    if (!$data['id']) {
      $this->resultStatus = self::RESULT_ERROR;
      $this->resultErrorMessage = 'Нет id';
    } else {
      $user = User::model()->findByPk($data['id']);
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
  
  public function actionDelete() {
    $userId = Yii::app()->request->getParam('id');
    $result = User::model()->deleteByPk($userId); 
    if ($result > 0) {
      $this->resultStatus = self::RESULT_SUCCESS;
    } else {
      $this->resultStatus = self::RESULT_ERROR;
      $this->resultErrorMessage = 'Ни одного юзера не удалено';
    }
    $this->sendResult();  
  }
  
  public function actionShow() {
    $userId = Yii::app()->request->getParam('id');
    if (!$userId) {
      $user = $this->currentUser;
    } else {
      $user = User::model()->findByPk($userId); 
    }
    if (!$user) {
      Yii::app()->request->redirect('/api/error/notFound');
    }
    $this->resultData = array(
      'id' => $user->id,
      'login' => $user->login,
      'first_name' => $user->first_name,
      'last_name' => $user->last_name,
      'role' => $user->role,
    );
    $this->resultStatus = self::RESULT_SUCCESS;
    $this->sendResult();  
  }
  
}