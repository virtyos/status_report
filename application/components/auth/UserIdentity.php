<?php
class UserIdentity extends MyIdentity {

  public function authenticate() {
    $user = User::model()->find('login = :login', array(':login' => $this->username));

    if ($user !== null && $user->validatePassword($this->password)) {
      $this->_id = $user->id;
      $this->errorCode = self::ERROR_NONE;
      $this->setState('login', $user->login);
      $this->setState('role', $user->role);
    } else {
      $this->errorCode = self::ERROR_PASSWORD_INVALID;
    }

    return $this->errorCode == self::ERROR_NONE;
  }

}