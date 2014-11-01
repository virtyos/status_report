<?php
class AuthController extends ApiController {
  
  public function actionLogin() {
    $login = Yii::app()->request->getParam('login');
    $password = Yii::app()->request->getParam('password');
    $loginForm = new LoginTokenForm;
    $loginForm->login = $login;
    $loginForm->password = $password;
    if (!$loginForm->validate()) {
      $this->resultErrorMessage = $loginForm->getFirstError();
      $this->resultStatus = self::RESULT_ERROR;
    } else {
      $authResult = $loginForm->authenticate();
      if (!$authResult) {
        $this->resultStatus = self::RESULT_ERROR;
        $this->resultErrorMessage = 'Не удалось авторизоваться. Неправильный логин или пароль';
      } else {
        $this->resultStatus = self::RESULT_SUCCESS;
        $this->resultData = array(
          'auth_token' => $authResult
        );
      }
    }
    $this->sendResult();
  }
  
  public function actionLogout() {
    if (!$this->currentUser) {
      $this->resultStatus = self::RESULT_ERROR;
      $this->resultErrorMessage = 'Неизвестный пользователь';
    } else {
      $this->currentUser->auth_token_expires = 0;
      if ($this->currentUser->save()) {
        $this->resultStatus = self::RESULT_SUCCESS;
      } else {
        $this->resultStatus = self::RESULT_ERROR;
        $this->resultErrorMessage = 'Не удалось разлогиниться';
      }
    }
    $this->sendResult();
  }
  
}