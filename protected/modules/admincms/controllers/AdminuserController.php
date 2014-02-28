<?php

class AdminuserController extends Controller {
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters() {
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
				array('allow',  // allow all users to perform 'changepassword' action
					'actions'=>array('changepassword'),
					'users'=>array('*'),
				),
				array('deny',  // deny
					'users'=>array($contentmn_name),
				),
			);
		}
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate() {	
		$model = new Adminuser;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['Adminuser']))
		{	
			$model->setScenario('scenarioCreate');
			$model->attributes = $_POST['Adminuser'];
			if (!empty(Yii::app()->user->content_man_un)) {
				$model->adminuser_groupid = 2;
			}
			if ($model->validate()) // validation is called. Here model applies the validation rules.
				$validate = true;
			else $validate = false;
			$model->password = Adminuser::model()->encrypt($model->password);// encrypting the password before entering to the database
			if ($validate) { // validation is called. Here model applies the validation rules.
				if($model->insert()) {
					$this->redirect(array('index','id'=>$model->userid));
				}
			}
			else {
				$model->password = "";
				$model->confirm_password = "";
			}
		}
		$model->unsetAttributes();
		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id) {
		$model = $this->loadModel($id);
		if (isset($_POST['Adminuser'])) {
			($_POST['Adminuser']['reset_password']==1) ? $model->setScenario('scenarioUpdateAll') : $model->setScenario('scenarioNoPasswordUpdate');
			$model->attributes = $_POST['Adminuser'];
			if ($_POST['Adminuser']['reset_password']==1) {
				if ($_POST['Adminuser']['password'] == $_POST['Adminuser']['confirm_password']) {
					$model->reset_password = $_POST['Adminuser']['reset_password'];
					$model->confirm_password = $_POST['Adminuser']['confirm_password'];
					if ($model->validate()) { // validation is called. Here model applies the validation rules.
						if ($model->resetPasswordOrUpdateOthers($model->reset_password)) {
							Yii::app()->user->setFlash('actionUpdate','Database was updated successfully');
							$this->redirect(array('index'));
						}
					}
					
				} 
				else { 
					$model->addError('reset_password','Passwords do not match'); 
				}
			}			
			else if ($model->validate()) { // validation is called. Here model applies the validation rules.
				if($model->saveAttributes(array('username_email', 'name','adminuser_groupid'))) {
					Yii::app()->user->setFlash('actionUpdate','Database was updated successfully');
					$this->redirect(array('index'));
				}
			}
		}
	
		$this->render('update',array(
			'model'=>$model,
		));
	}
	
	public function actionChangepassword() {
		$model = $this->loadModel(Yii::app()->user->userid);
		$model->setScenario('scenarioChangePassword');
		
		if (isset($_POST['Adminuser'])) {
			$model->attributes=$_POST['Adminuser'];
			$model->old_password = $_POST['Adminuser']['old_password'];
			$model->new_password = $_POST['Adminuser']['new_password'];
			$model->confirm_password = $_POST['Adminuser']['confirm_password'];
			if ($model->validate()) { // validation is called. Here model applies the validation rules.
				if($model->validateAndChangepassword()) {
					Yii::app()->user->setFlash('actionChangepassword','Database was updated successfully');
					$this->redirect(Yii :: app()->createUrl('/admincms/adminuser/changepassword'));
				}
				else {
					Yii::app()->user->setFlash('actionChangepassword_error','Old password is incorrect');
					$this->redirect(Yii :: app()->createUrl('/admincms/adminuser/changepassword'));
				}
			}
		}
		$this->render('changepassword',array(
					'model'=>$model,));

	}

	public function actionIndex() {
		if (Yii::app()->request->isAjaxRequest && !empty($_POST['delete_user_id'])){ //If this Action gets a Ajax request with a delete item id, item's deleted and recreate the content for Ajax response
			try {
				$this->loadModel($_POST['delete_user_id'])->delete(); 
			}
			catch (Exception $e) {
				echo "<div class='errorSummary'><p>Error occured: if this error persists, please contact admin with the following <br /><br />" . $e  . "</p></div>";
			}
		}
		$model=new Adminuser('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Adminuser']))
			$model->attributes=$_GET['Adminuser'];
			
		if (Yii::app()->request->isAjaxRequest && !empty($_POST['delete_user_id'])) //If Ajax request, _ajaxContent.php in the module is called
			$this->renderPartial('_ajaxContent',array(
			'model'=>$model,
			'page' => 'index',
			), false, false);
		else //default view file rendering
			$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id) {
		$model=Adminuser::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model) {
		if(isset($_POST['ajax']) && $_POST['ajax']==='adminuser-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
