<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $this->title;?></title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css" >
    <link rel="stylesheet" href="/css/style.css">
  <?php
    foreach ($this->scriptsMap as $script) {
      Yii::app()->clientScript->registerScriptFile (
        $script,
        CClientScript::POS_HEAD
      ); 
    }
  ?>
  <script type="text/javascript">
    var globalOptions = {
      token_name:'<?php echo Yii::app()->request->csrfTokenName; ?>',
      token_value:'<?php echo Yii::app()->request->csrfToken; ?>',
      is_logged: <?php echo isset(Yii::app()->user->id) ? 1 : 0; ?>
    }
  </script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="l-layout">  
      <div class="header navbar navbar-fixed-top" >
        <div class="header-content">
          <a class="logo" href="/">
            <img src="/img/logo.png">
          </a>
          <?php
            if (!Yii::app()->user->isGuest) :
              $this->renderPartial('//shared/topMenu');
            endif;
          ?>
        </div>
      </div>
      <div class="content">
        <div class="content-content">
          <?php
            echo $content;
          ?>
        </div>
     </div>
    </div>
  </body>
</html>
