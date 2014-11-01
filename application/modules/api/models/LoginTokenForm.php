<?php

class LoginTokenForm extends CFormModel
{
  public $login;
  public $password;


  /**
   * Declares the validation rules.
   * The rules state that login and password are required,
   * and password needs to be authenticated.
   */
  public function rules()
  {
    return array(
      // username and password are required
      array('login, password', 'required'),
    );
  }
  
  
  public function behaviors() {
    return array(
      'modelErrorBehavior' => array(
        'class' => 'application.behaviors.ModelErrorBehavior',
      ),
    );
  }

  /**
   * Declares attribute labels.
   */
  public function attributeLabels()
  {
    return array(
      'login' => 'Логин',
      'password' => 'Пароль',
    );
  }

  public function authenticate()
  {
    $user = User::model()->findByAttributes(array(
      'login' => $this->login
    ));
    if (!$user || !$user->validatePassword($this->password)) {
      return false;
    }
    $time = time();
    $user->auth_token = md5($user->login . $user->auth_token . $time. rand());
    $user->auth_token_expires = $time + 2*3600;
    if ($user->save()) {
      return $user->auth_token;
    } else {
      return false;
    }
  }

}
