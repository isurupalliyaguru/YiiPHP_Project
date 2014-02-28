<?php

// uncomment the following to define a path alias
//Yii::setPathOfAlias('local','ztest/3003online');
Yii::setPathOfAlias('widget', dirname(__FILE__) . '/../widgets');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Apartments lanka',

	'defaultController' => 'pages',
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.controllers.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'admincms',
		'cmshome' => array('login/index'),
		/*
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'Enter Your Password Here',
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		*/
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'loginUrl'=>array('/pages/home'),
		),
			
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>array(
				'admincms'=>'admincms/default/login',
				'admincms/<controller:\w+>/<action:\w+>/<id:\d+>/<menuid:\d+>'=>'admincms/<controller>/<action>',
				'admincms/<controller:\w+>/<action:\w+>/<id:\d+>'=>'admincms/<controller>/<action>',
				'admincms/<controller:\w+>/<action:\w+>/<id:\w+>'=>'admincms/<controller>/<action>',
				//'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'portfolio'=>'portfolio/index',
				'contact'=>'contact/index',
				'inquiry'=>'hotel/index',
				//'inquiry/<action>/<param>'=>'inquiry/index/<param>',
				'<sef_url:[a-z0-9\-_]+>'=>'pages/index',
				//'<sef_url:[a-z0-9\-_]+>/hotel'=>'places/index',
				'<sef_url:[a-z0-9\-_]+>/hotel'=>'hotel/index',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				
			),
		),
		'clientScript'=>array(
			'scriptMap'=>array(
			  'jquery.js'=>'/js/jquery-1.7.min.js',
			),
        ),
		/*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		*/
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=flats_apartmentslanka',
			'emulatePrepare' => true,
			'username' => 'final_flat_apartments',
			'password' => 'fwtf5ykjokl1vhmfx',
			'charset' => 'utf8',
			'enableProfiling'=>true,
			'enableParamLogging' => true,
		),
		
		'errorHandler'=>array(
			// use 'pages/error' action to display errors
            'errorAction'=>'pages/error',
        ),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					//'levels'=>'error, warning',
					'levels'=>'profile',
					'enabled'=>true,
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
		'Navigation'=>array(
			'class'=>'Navigation',
		),
		'SiteConfig'=>array(
			'class'=>'SiteConfiguration',
		),
		
        
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
		'webRoot' => dirname(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'),
	),
);