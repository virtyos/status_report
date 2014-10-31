<?php
date_default_timezone_set('Europe/Moscow');
// This is the main Web application configuration. Any writable
// application properties can be configured here.
return array(
  'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
  'name' => 'Status report',
  'defaultController' => 'index',
  'preload'=>array('log'),
  'language' => 'ru',

  // autoloading model and component classes
  'import' => array(
    'application.models.*',
    'application.components.*',
    'application.components.auth.*',
  ),

  'modules' => array(
    'gii' => array(
      'class' => 'system.gii.GiiModule',
      'password' => '111',
    ),
    'api',
  ),


  // application components
  'components' => array(
    'user' => array(
      'loginUrl' => '/admin/login',
      'allowAutoLogin' => true,
    ),
    
    'log' => array (
      'class' => 'CLogRouter', 
      'routes' => array (
        array (
          'class' => 'CFileLogRoute', 
          'levels' => 'error, warning' 
        ),
      ) 
    ),

    'request' => array(
      'enableCsrfValidation' => true,
      'enableCookieValidation' => true,
      'class' => 'HttpRequest',
      'csrfTokenName' => 'token',
      'csrfCookie' => array('domain' => 'status_report.dev'),
      'noCsrfValidationRoutes' => array(),
    ),


    'session' => array(
      'class' => 'CDbHttpSession',
      'sessionName' => 'SID',
      'sessionTableName' => 'status_reporter_sessions',
      'connectionID' => 'db',
      'autoCreateSessionTable' => true,
      'timeout' => 3600,
      'cookieParams' => array(
        'domain' => 'status_report.dev',
        'lifetime' => 24 * 3600,
      ),
    ),


    'db' => array(
      'class' => 'CDbConnection',
      'connectionString' => 'mysql:host=localhost;dbname=status_report',
      'username' => 'root',
      'password' => '',
      'emulatePrepare' => true,
      'charset' => 'UTF8',

    ),

    'urlManager' => array(
      'urlFormat' => 'path',
      'showScriptName' => false,
      'rules' => array(
        'api' => 'api',
        '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
      ),
    ),

  ),

  'params' => array(  
    'baseUrl' => 'status_report.dev',
    'adminEmail' => 'admin@status_report.dev',
  ),

);
