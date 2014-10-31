<?php

class ReportController extends AppController {

  public function filters() {
    return array(
      array('application.filters.AuthAppFilter')
    );
  }

  public function actionIndex() {
    $this->redirect('/report/all');
  }


  public function actionAdd() {
    $text = Yii::app()->request->getParam('text');
    $report = new Report;
    $report->text = $text;
    $report->owner_id = $this->currentUser->id;
    $report->created_at = time();
    $result = array();
    if ($report->save()) {
      $result['status'] = self::AJAX_STATUS_SUCCESS;
      $result['html'] = $this->renderPartial('reportBlock', array('report' => $report), true);
    } else {
      $result['status'] = self::AJAX_STATUS_ERROR;
      $result['error'] = $report->getFirstError();
    }
    echo json_encode($result);
  }
  
  public function actionAll() {
    $cr = new CDbCriteria;
    $cr->order = 'created_at DESC';
    
    $count = Report::model()->count($cr);
    $render_params['count'] = $count;
    $pagination = new CPagination($count);
    $pagination->pageSize = 20;
    $pagination->applyLimit($cr);

    $reports = Report::model()->findAll($cr);
    $this->renderData['pagination'] = $pagination;
    $this->renderData['reports'] = $reports;
   
    $this->render('all', $this->renderData);
  }

}