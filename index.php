<?php
date_default_timezone_set("Asia/Bangkok");
define('DS', DIRECTORY_SEPARATOR);
define('YII_DEBUG', true);

$dir = dirname(__FILE__);
$appDir = $dir . DS . 'application';


$config = $appDir . DS . 'config' . DS . 'main.php';
require_once($dir . DS . '..' . DS . 'yii' . DS . 'yii.php');


header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');
header("Cache-Control: no-cache");
header("Expires: -1");

ini_set('display_errors', 'on');
ini_set('register_globals', 'on');
//error_reporting(E_ERROR | E_WARNING | E_PARSE);

Yii::createWebApplication($config)->run();
