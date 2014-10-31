<?php

return array(
  'commandPath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'commands',
  'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
  'name' => 'Findaflat',
  'commandMap' => array(
    'node-socket' => 'application.extensions.yii-node-socket.lib.php.NodeSocketCommand'
  ),
  'import' => array(
    'application.models.*',
    'application.components.*',
    'application.vendors.*',
  ),
  'components' => array(
    'db' => array(
      'class' => 'CDbConnection',
      'connectionString' => 'mysql:host=localhost;dbname=flat',
      'username' => 'admin',
      'password' => 'bqccu512',
      //'password'=>'Llkfo5OMJf54hF',
      'emulatePrepare' => true,
      'charset' => 'UTF8',

    ),
    
    'nodeSocket' => array(
      'class' => 'application.extensions.yii-node-socket.lib.php.NodeSocket',
      'host' => 'findaflat.ru',	// default is 127.0.0.1, can be ip or domain name, without http
      'port' => 2002		// default is 3001, should be integer
    ),

    'mailer' => array(
      'class' => 'Mailer',
      'from' => 'robot@findaflat.ru',
      'fromName' => 'Findaflat',
      'sender' => 'robot@findaflat.ru'
    ),

  ),
);