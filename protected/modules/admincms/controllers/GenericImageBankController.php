<?php

class GenericImageBankController extends Controller {
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
				array('deny',  // allow all users to perform 'index' and 'view' actions
					'actions'=>array('admin','delete', ),
					'users'=>array($contentmn_name),
				),
			);
		}
	}

	// View action is no longer in use 09-08-2011
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate() {
		$model=new GenericImageBank_cms;
		//$model->getImageCategory();
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['GenericImageBank_cms'])) 
		{
			$model->attributes = $_POST['GenericImageBank_cms'];	
			if (!empty($_POST['GenericImageBank_cms']['subcategoryid'])) { // Save under the sub category
				$model->categoryid = $_POST['GenericImageBank_cms']['subcategoryid'];
				$model->parentcatid	= $_POST['GenericImageBank_cms']['categoryid'];
			}
			else { // No sub category - Save under the parent Category				
				$model->categoryid = $_POST['GenericImageBank_cms']['categoryid'];
			}
			$model->image_alt = $_POST['GenericImageBank_cms']['image_alt'];
			$model->image_title = $_POST['GenericImageBank_cms']['image_title'];
			$model->url = $_POST['GenericImageBank_cms']['url'];
			$model->order_no = $_POST['GenericImageBank_cms']['order_no'];
			$model->advanced_options = $_POST['GenericImageBank_cms']['advanced_options'];
			$model->image_html = $_POST['GenericImageBank_cms']['image_html'];				
			if(!empty($_FILES['GenericImageBank_cms']["name"]["upload_image"])) {
				$model->upload_image = $_FILES['GenericImageBank_cms'];
				if ($model->validateImageExtention($_FILES['GenericImageBank_cms']["name"]["upload_image"])) {
					//$model->test($model->primaryKey);
					if($model->save(array('categoryid'))) {						
						if($model->uploadAndSaveImage($_POST['GenericImageBank_cms']['categoryid'] . (!empty($_POST['GenericImageBank_cms']['subcategoryid']) ? "/" . $_POST['GenericImageBank_cms']['subcategoryid'] : ''), $model->categoryid)) {
							$model->thumb_image_fileref = $model->image_fileref;
							$model->save(array('image_width','image_height','image_version','image_fileref', 'thumb_image_fileref', 'image_alt', 'image_title', 'url', 'order_no', 'image_html', 'advanced_options'));
							Yii::app()->user->setFlash('actionCreate','Database was updated successfully');
						}
						else {
							$model->addError('upload_image', 'An error occured while uploading the image. Please check again.');
							$this->redirect(array('create','id'=>$model->imageid));
						}
					}
				} else $model->addError('upload_image', 'Please use jpg/png/gif image file');
			} else $model->addError('upload_image', 'Please select a file');
		}
		$this->render('create',array(
			'model'=>$model,'imgpath'=> $model->imagepath
		));
	}
	
	public function actionChange_thumbnail($imgid) {
		$model=new GenericImageBank_cms();
		if(isset($_POST['GenericImageBank_cms'])) {	
			$model->upload_image = $_FILES['GenericImageBank_cms'];
			if($model->replaceThumbnail($imgid))
				$this->redirect('/admincms/genericImageBank/admin'); 
		}
		$this->render('change_thumbnail',array('model'=>$model,'imgid'=>$imgid));	
	}	
	
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id) {
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$model=$this->loadModel($id);
		if(isset($_POST['GenericImageBank_cms']))
		{			
			if(!empty($_FILES['GenericImageBank_cms']["name"]["upload_image"])) {
				if (!empty($_POST['GenericImageBank_cms']['subcategoryid'])) { // Save under the sub category
					$model->categoryid = $_POST['GenericImageBank_cms']['subcategoryid'];
				}
				else // No sub category - Save under the parent Category				
					$model->categoryid = $_POST['GenericImageBank_cms']['categoryid'];			
				$model->upload_image = $_FILES['GenericImageBank_cms'];
				$model->image_alt = $_POST['GenericImageBank_cms']['image_alt'];
				$model->image_title = $_POST['GenericImageBank_cms']['image_title'];
				$model->url = $_POST['GenericImageBank_cms']['url'];
				$model->order_no = $_POST['GenericImageBank_cms']['order_no'];
				$model->advanced_options = $_POST['GenericImageBank_cms']['advanced_options'];
				$model->image_html = $_POST['GenericImageBank_cms']['image_html'];				
				if ($model->validateImageExtention($_FILES['GenericImageBank_cms']["name"]["upload_image"])) {
					//$model->test($model->primaryKey);	
					if($model->uploadAndSaveImage($_POST['GenericImageBank_cms']['categoryid'] . (!empty($_POST['GenericImageBank_cms']['subcategoryid']) ? "/" . $_POST['GenericImageBank_cms']['subcategoryid'] : ''), $model->categoryid)) {
						$model->thumb_image_fileref = $model->image_fileref;
						$model->save(array('image_width','image_height','image_version','image_fileref','image_alt','image_title','url', 'order_no','image_html', 'advanced_options'));
						Yii::app()->user->setFlash('actionUpdate','Database was updated successfully');
					}
					else $model->addError('upload_image', 'An error occured while uploading the image. Please check again.');
					$this->redirect(array('update','id'=>$model->imageid));
				} else $model->addError('upload_image', 'Please use jpg/png/gif image file');
			} else {
				$model->image_alt = $_POST['GenericImageBank_cms']['image_alt'];
				$model->image_title = $_POST['GenericImageBank_cms']['image_title'];
				$model->url = $_POST['GenericImageBank_cms']['url'];
				$model->order_no = $_POST['GenericImageBank_cms']['order_no'];
				$model->advanced_options = $_POST['GenericImageBank_cms']['advanced_options'];
				$model->image_html = $_POST['GenericImageBank_cms']['image_html'];
				$model->save(array('image_alt','image_title','url','image_html','advanced_options'));
				Yii::app()->user->setFlash('actionUpdate','Database was updated successfully');
				$this->redirect(array('/admincms/genericImageBank/admin/', 'categoryid'=> $_POST['GenericImageBank_cms']['categoryid'], 'subcat' => (!empty($_POST['GenericImageBank_cms']['subcategoryid']) ? $_POST['GenericImageBank_cms']['subcategoryid'] : '')));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionAdmin() {
		if (Yii::app()->request->isAjaxRequest && !empty($_POST['delete_image_id']) && empty(Yii::app()->user->content_man_un)) { //If this Action gets a Ajax request with a delete item id, item's deleted and recreate the content for Ajax response
			try {
				$model = $this->loadModel($_POST['delete_image_id']); // delete the passed id from DB after loading the correct model
				if($model->deleteImages($_POST['delete_image_id']))
					$model->delete(); // delete the images from the server
			}
			catch (Exception $e) {
				$error = Yii::app()->errorHandler->error;
				echo "<div class='errorSummary'><p>Error occured: if this error persists, please contact admin with the following <br /><br />" . $e  . "</p></div>";
			}
		}
		else { 
			$model = new GenericImageBank_cms('search');
			$model_cat = new GenericImageBankCategory('search');	
			$model->unsetAttributes();  // clear any default values
			$model->categoryid = (!empty($_GET['subcat']) ? $_GET['subcat'] : (!empty($_GET['categoryid']) ? $_GET['categoryid'] : 0));// On page load, no image should be loaded. So default id = 0
			if(isset($_GET['GenericImageBank_cms']))
				$model->attributes=$_GET['GenericImageBank_cms'];
			if(!empty($_GET['GenericImageBank_cms']['subcategoryid'])) {
				if ($_GET['GenericImageBank_cms']['subcategoryid'] == 'va')
					$model->parentcatid = $model->categoryid;
				else	
					$model->categoryid = $_GET['GenericImageBank_cms']['subcategoryid'];	
			}
		}
		if (Yii::app()->request->isAjaxRequest)	//If Ajax request, _ajaxContent.php in the module is called
			$this->renderPartial('_ajaxContent',array(
			'model'=>$model,
			'page'=>'MGIB',
			), false, false);
		else //default view file rendering
			$this->render('admin',array(
				'model'=>$model,
				'subcat'=> (!empty($_GET['subcat']) ? $_GET['subcat'] : ''),
				'pcat'=> (!empty($_GET['categoryid']) ? $_GET['categoryid'] : '')
			));
	}
	
	public function actionSubCategory($catid, $subcatid, $mode='') {
		/*
			@params $catid, $subcatid, $mode are request parameters
			@param $mode is passed on image create/update mode
			This action is used get the AJAx response for the Subcategories of the given parent category
		*/
		$model=new GenericImageBankCategory();
		$options = $model->getSubCat($catid, $subcatid);
		echo '
		<div class="row">
			<label for="GenericImageBank_cms_subcategoryid" class="form_controller">Sub Category</label>
			<select id="GenericImageBank_cms_subcategoryid" name="GenericImageBank_cms[subcategoryid]">				
				'. (!empty($options) ? ($mode != 'create' ? "<option value='va'>View all</option>" : '') . $options : "<option value=''>No Subcategory</option>") . '
			</select>
		</div>';
	}	
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id) {
		$criteria = new CDbCriteria;
		$criteria->select = 't.*,gibc.categoryid,gibc.parentcatid';
		$criteria->join = 'INNER JOIN generic_image_bank_category gibc ON gibc.categoryid = t.categoryid';//t is the Alias for the current table 
		$model = GenericImageBank_cms::model()->findByPk((int)$id, $criteria);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model) {
		if(isset($_POST['ajax']) && $_POST['ajax']==='generic-image-bank-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
