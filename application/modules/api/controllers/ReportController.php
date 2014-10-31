<?php
class ReportController extends ApiController {

  const REPORT_SHOW_ALL = 

  public function filters() {
    return array(
      array('AuthTokenFilter'),
    );
  }
  
  public actionCreate() {
    $report = new Report;
    $data = Yii::app()->request->getaParam('Report');
    $report->setAttributes($data);
    $report->owner_id = $this->currentUser->id;
    if ($report->save()) {
      $this->resultStatus = self::RESULT_SUCCESS;
    } else {  
      $this->resultStatus = self::RESULT_ERROR;
      $this->resultErrorMessage = $report->getFirstError();
    }
    $this->sendResult();  
  }  
  
  public actionShowList() {
    $action = 
    $this->sendResult();  
  }  
  
}