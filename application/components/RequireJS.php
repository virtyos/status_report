<?php

class RequireJS extends CWidget
{
  public $app_name;

  public function run()
  {
    Yii::app()->clientScript->registerScriptFile(
      '/js/libs/require/require.js',
      CClientScript::POS_HEAD
    );

    $script =
      'require.config({
				baseUrl: "'.Yii::app()->params['js_path'].'",
                urlArgs: "ver=v5",
				waitSeconds: 8,
				paths: {
					"async": "libs/plugins/requirejs/async",
                    "order": "libs/plugins/requirejs/order",
                    "jquery": "libs/jquery/jquery-min",
					"underscore": "libs/underscore/underscore-min",
					"backbone": "libs/backbone/backbone-min",
					"templates": "../templates",
                    "fotorama": "libs/plugins/fotorama",
                    "ui": "libs/plugins/jquery-ui",
                    "mfupload": "libs/plugins/mfupload",
                    "raty": "libs/plugins/jquery.raty.min",
                    "eauth": "libs/plugins/eauth",
					"cookie": "libs/plugins/cookie"
				},
                shim: {
                    backbone: {
                        deps: ["underscore", "jquery"]
                    },
                    "fotorama": {
                        deps: ["jquery"]
                    },
                    "ui": {
                        deps: ["jquery"]
                    },
                    "mfupload": {
                        deps: ["jquery"]
                    },
                    "raty": {
                        deps: ["jquery"]
                    },
                    "eauth": {
                        deps: ["jquery"]
                    },
                    "cookie": {
                        deps: ["jquery"]
                    }					
                }
			});';

    if (!empty($this->app_name)) {
      $script .= 'require(["order!apps/default", "order!apps/' . $this->app_name . '"],
                function(Default, App){
                    $(function(){
                        Default.init();
                        App.initialize();
                    })
                });';
    } else {
      $script .= 'require(["order!apps/default"],
                function(Default){
                    $(function(){
                         Default.init();
                    });
                });';
    }

    //add init code for require js
    Yii::app()->clientScript->registerScript(
      'requireInit',
      $script,
      CClientScript::POS_HEAD
    );
  }
}

?>