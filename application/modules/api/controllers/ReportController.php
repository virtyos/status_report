<?php
class ReportController extends ApiController {


  public function filters() {
    return array(
      array('AuthTokenFilter'),
    );
  }
  
  public function actionCreate() {
    $report = new Report;
    $data = Yii::app()->request->getParam('Report');
    $report->setAttributes($data);
    $report->created_at = time();
    $report->owner_id = $this->currentUser->id;
    if ($report->save()) {
      $this->resultStatus = self::RESULT_SUCCESS;
    } else {  
      $this->resultStatus = self::RESULT_ERROR;
      $this->resultErrorMessage = $report->getFirstError();
    }
    $this->sendResult();  
  }  
  
  public function actionShowList() {
    $userId = Yii::app()->request->getParam('user_id');
    $limit = Yii::app()->request->getParam($limit);
    $offset = Yii::app()->request->getParam($offset);
    if (!$limit) {
      $limit = 30;
    }
    if (!$offset) {
      $offset = 0;
    }
    $cr = new CDbCriteria;
    $cr->limit = $limit; 
    $cr->offset = $offset;
    $cr->order = 'created_at DESC'; 
    if ($userId) {
      $cr->addCondition('owner_id = :owner_id');
      $cr->params = array(':owner_id' => $userId);
    }
    $reports = Report::model()->findAll($cr);
    $this->resultData['reports'] = array();
    foreach ($reports as $report) {
      $this->resultData['reports'][] = array (
        'id' => $report->id,
        'text' => $report->text,
        'owner_id' => $report->owner_id,
        'created_at' => $report->created_at,
      );
    }
    $this->resultStatus = self::RESULT_SUCCESS;
    $this->sendResult();  
  }  
  
}