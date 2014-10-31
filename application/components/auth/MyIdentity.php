<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class MyIdentity extends CUserIdentity
{
  protected $_id;

  public function getId()
  {
    return $this->_id;
  }
}