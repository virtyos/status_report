<?php

define('DS', DIRECTORY_SEPARATOR);


$dir = dirname(__FILE__);

$configConsole = $dir . '/config/console.php';

require_once($dir . DS . '..' . DS . '..' . DS . '..' . DS . 'yii' . DS . 'yii.php');
$config = $configConsole;

// change the following paths if necessary
$yiic = $dir . DS . '..' . DS . '..' . DS . '..' . DS . 'yii' . DS . 'yiic.php';

require_once($yiic);
