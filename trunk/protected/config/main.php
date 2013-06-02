<?php

// uncomment the following to define a path alias
//Yii::setPathOfAlias('bootstrap','ext.bootstrap.components.Bootstrap');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Тренажер-имитатор специализированный Примус-Т',

	// preloading 'log' component
	'preload'=>array(
            'log',
            'bootstrap',
            ),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
              /*  'application.modules.user.models.*',
                'application.modules.user.components.*',*/

	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123',
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
                        'generatorPaths' => array(
                            'bootstrap.gii'
                        ),
		),
            
                'AjaxModule',
               /* 'user',*/
	
	),

	// application components
	'components'=>array(
                'user'=>array(
                        // enable cookie-based authentication
                        'allowAutoLogin'=>true,
                        'loginUrl' => array('user/login'),

		),
                'session' => array(
                    'class' => 'CDbHttpSession',
                    'timeout' => 60,
                ),

             //   'clientScript' => array(
             //           'scriptMap' => array(
             //                   'jquery.js' => false,
              //                  'jquery.min.js' => false,
               //         )
		//),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
                    ),
                'authManager'=>array(
                    'class' => 'PhpAuthManager',
                    'defaultRoles' => array('guest'),
                    ),
		
		/*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=primus_db_prod',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
			'tablePrefix' => 'tbl_',
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
                        'errorAction'=>'site/error',
                ),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
                ),
                'bootstrap'=>array(
                        'class'=>'ext.bootstrap.components.Bootstrap', // assuming you extracted bootstrap under extensions
                        'responsiveCss' => true,
                ),
                'user'=>array(
                        'class' => 'WebUser',
                ),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
    
        'sourceLanguage'=>'ru'
);