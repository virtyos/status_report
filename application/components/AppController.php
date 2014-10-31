<?php

class AppController extends CController
{
  const AJAX_STATUS_SUCCESS = 1;
  const AJAX_STATUS_ERROR = 0;
  
  public $currentUser;
  public $scriptsMap = array();
  
  public $renderData = array();
  
  public $title = 'Status Reporter';

  public function init()
  { 
    parent::init();
    $this->initScriptsMap();
    if (isset(Yii::app()->user->id)) {
      $this->currentUser = User::model()->findByPk(Yii::app()->user->id);
      $this->setTimeZone();
    }
  }
  
  public function setTimeZone() {
    $timezoneName = timezone_name_from_abbr("", (-$this->currentUser->timezone)*3600, false);
    if ($timezoneName) {
      date_default_timezone_set($timezoneName);
    }
  }
  
  public function initScriptsMap() {
    $this->scriptsMap[] = Yii::app()->params['js_path'].'/js/jquery-min.js';
    $this->scriptsMap[] = Yii::app()->params['js_path'].'/bootstrap/js/bootstrap.min.js';
    $this->scriptsMap[] = Yii::app()->params['js_path'].'/js/main.js';
  }

}