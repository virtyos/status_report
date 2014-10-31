<?php
class ErrorController extends ApiController {

  public function actionNologin() {
    $this->resultStatus = self::RESULT_NEED_LOGIN;
    $this->resultErrorMessage = '��������� �����������'; 
    $this->sendResult();    
  }
  
  public function actionForbidden() {
    $this->resultStatus = self::RESULT_ERROR_FORBIDDEN;
    $this->resultErrorMessage = '������ ��������'; 
    $this->sendResult();    
  }
  
  public function actionNotFound() {
    $this->resultStatus = self::RESULT_NOT_FOUND;
    $this->resultErrorMessage = '�� �������'; 
    $this->sendResult();    
  }
}