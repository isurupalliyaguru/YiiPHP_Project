<?php

class AdmincmsModule extends CWebModule
{	

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		
		$this->setImport(array(
			'admincms.models.*',
			'admincms.components.*',
			'admincms.controllers.*',
		));
		 Yii::app()->setComponents(array(
			'user' => array(
                'class' => 'CWebUser',
                'loginUrl' => Yii::app()->createUrl('admincms/default/login'), // This is setting the "loginUrl" varibale for the "Admincms" module. Not logged in users wil be redirected to this link.
            ),
            'errorHandler'=>array(
            'errorAction'=>'admincms/default/error',
			),
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			$controller->layout = 'main';
			return true;
		}
		else
			return false;
	}
}
