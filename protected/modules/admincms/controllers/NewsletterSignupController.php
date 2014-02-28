<?php

class NewsletterSignupController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules() {	
		$contentmn_name  = (!empty(Yii::app()->user->content_man_un) ? Yii::app()->user->content_man_un : "" );
		if (Yii::app()->user->isGuest) {
			return array(
				array('deny',  // deny all users
					'users'=>array('*'),
				),
			);
		}
		else {
			return array(
				array('deny',  // allow all users to perform 'index' and 'view' actions
					'actions'=>array('admin','delete', ),
					'users'=>array($contentmn_name),
				),
			);
		}
	}
	/**

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}
	 */
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new NewsletterSignup_cms;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['NewsletterSignup_cms']))
		{
			$model->attributes=$_POST['NewsletterSignup_cms'];
			if($model->save())
				$this->redirect(array('admin','id'=>$model->subscribeid));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['NewsletterSignup_cms']))
		{
			$model->attributes=$_POST['NewsletterSignup_cms'];
			if($model->save())
				$this->redirect(array('admin','id'=>$model->subscribeid));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('NewsletterSignup');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	*/
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new NewsletterSignup_cms('search');
		
		if (Yii::app()->request->isAjaxRequest && !empty($_POST['delete_newslettr_subscription_id']) && empty(Yii::app()->user->content_man_un)){ //If this Action gets a Ajax request with a delete item id, item's deleted and recreate the content for Ajax response
			try {
				$this->loadModel($_POST['delete_newslettr_subscription_id'])->delete(); // delete the passed id from DB after loading the correct model
			}
			catch (Exception $e) {
				echo "<div class='errorSummary'><p>Error occured: if this error persists, please contact admin with the following <br /><br />" . $e  . "</p></div>";
			}
		}
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['NewsletterSignup_cms']))
			$model->attributes=$_GET['NewsletterSignup_cms'];
			
		if (Yii::app()->request->isAjaxRequest && !empty($_POST['delete_newslettr_subscription_id'])) //If Ajax request, _ajaxContent.php in the module is called
			$this->renderPartial('_ajaxContent',array(
			'model'=>$model,
			'page'=>'MGIB', //Manage image categories
			), false, false);
		else
		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	public function actionExportCsv() {
		$model=new NewsletterSignup_cms;
		if (isset($_REQUEST['csv'])) {
			NewsletterSignup_cms::model()->query_to_csv("news_letter_signups.csv", true, true);
			Yii::app()->end();
		}
		if(!isset($_REQUEST['csv'])) {
			$this->render('csv',array(
				'model'=>$model,
			));
		}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=NewsletterSignup_cms::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='newsletter-signup-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
