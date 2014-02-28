<?php

class DefaultController extends Controller
{
	// This is the default controller for the back end
    public function actionIndex()
    {
		$this->layout='main';
		$this->render('index');
    }
	public function actionError()
	{
		// if any error happens the error view of the Default view folder is executed.
		if ($error=Yii::app()->errorHandler->error)
		{
			if (Yii::app()->request->isAjaxRequest) {
				echo $error['message'];
			}
			else {
				$this->layout='main';
				print_r($error);
				$this->render('error', $error);
				
			}				
		}   
    }
	public function actionLogin()
	{	
		
		$model=new LoginForm;
		
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->createUrl('admincms/pages/index'));
		}
		// display the login form
		if (Yii::app()->user->isGuest) {
			$this->render('index',array('model'=>$model));
		}
		else {// if the user logs in successfully take him to pages/index of the admincms
			$this->redirect($this->redirect(Yii::app()->createUrl('admincms/pages/index')));
		}
	}
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->createUrl('admincms/default/login'));
	}
	
}	