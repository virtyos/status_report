<?php
class ApiController extends CController
{
  const RESULT_SUCCESS = 1;
  const RESULT_ERROR = 0;
  const RESULT_NEED_LOGIN = -1;
  const RESULT_ERROR_FORBIDDEN = -2;
  const RESULT_NOT_FOUND = -3;
  

  public $resultStatus;
  public $resultData;
  public $resultErrorMessage;
  
  public $authToken = null;
  public $currentUser = null;
  
  public function init() {
    $this->authToken = Yii::app()->request->getParam('auth_token');
    if ($this->authToken) {
      $this->currentUser = User::model()->findByAttributes(
        array('auth_token' => $this->authToken)
      );
    }
    parent::init();
  }
  
  protected function sendResult() {
    $result = array();
    $result['status'] = $this->resultStatus;
    if ($this->resultStatus == self::RESULT_SUCCESS) {
      $result['data'] = $this->resultData;
    } elseif ($this->resultStatus == self::RESULT_ERROR) {
      $result['error_message'] = $this->resultErrorMessage;
    }
    echo json_encode($result);
  }
  

}