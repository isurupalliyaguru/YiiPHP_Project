<?php
/*
The following was used instead of CArrayDataProvider ealier. New coding should use CArrayDataProvider 
Yii::import('application.extensions.arrayDataProvider.*');
*/

class PagesController extends Controller
{
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
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id) {
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate() {
		$model = new Pagecontent;
		$gibcat = new GenericImageBankCategory;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Pagecontent']))
		{
			$model->attributes=$_POST['Pagecontent'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->pageid));
		}

		$this->render('create',array(
			'model'=>$model, 'gibcat'=>$gibcat,
		));
	}
	
	public function actionAssignImageCategories(){
		
		if(isset($_POST['categoryid'])) { 
			$sql = "UPDATE page_content SET categoryid=" . $_POST['categoryid'] . " WHERE pageid=" . $_POST['pageid'] . "";
			
			$connection = Yii::app()->db;
			$command = $connection->createCommand($sql);
			$data = $command->query();
			
			$this->redirect(Yii::app()->createUrl("/admincms/pages/assignimages/" . $_POST['pageid']));
		}
	}
	
	public function actionCreatemenu() {
		$menu = true;
		$model=new Pagemenu;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if(isset($_POST['Pagemenu']))
		{
			$model->attributes=$_POST['Pagemenu'];
			if($model->save())
				$this->redirect(array('menu'));
		}

		$this->render('create',array(
			'model'=>$model,
			'menu'=>$menu,
		));
	}
	
	public function actionCreatemenuitem() {
		$menuitem = true;
		$model=new PagemenuItems;
		if (Yii::app()->request->isAjaxRequest && !empty($_POST['delete_menu_item_id']))
			$this->loadModel($_POST['delete_menu_item_id'], false, true)->delete();	
			
		else if(isset($_POST['PagemenuItems']))
		{
			$model->attributes=$_POST['PagemenuItems'];
			if($model->validateAbsoluteurlandPageid()) {
				try {
					if($model->save())
					Yii::app()->user->setFlash('actionUpdatemenuitems','Successfully added the new menu item');
					$this->redirect('/admincms/pages/createmenuitem/'.$_GET['id']);
				}
				catch (Exception $e) {
					$model->addError('menu_heading_override',$e);
				}
			}
		}
		$model_cms = new PagemenuItems_cms;
		if (Yii::app()->request->isAjaxRequest && !empty($_POST['delete_menu_item_id'])) {
			$dataProvider = $model_cms->getmenuitems($_POST['ajax_redirect_id']);
			$this->renderPartial('_ajaxContent',array(
			'dataProvider'=>$dataProvider,
			'page' => 'menuitem',
			), false, false);}
		else {
			$model_cms = new PagemenuItems_cms;
			$dataProvider = $model_cms->getmenuitems($_GET['id']);
			$menu_model = $this->loadmodel($_GET['id'], true);//load menu model for this id
			$this->render('create',array(
			'model'=>$model,
			'menuitem'=>$menuitem,
			'dataProvider'=>$dataProvider,
			'menuname'=>$menu_model->menuname,
			));	
		}
	}
	

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id) {
		$model=$this->loadmodel($id);
		$gibcat = new GenericImageBankCategory;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Pagecontent']))
		{
			$model->attributes=$_POST['Pagecontent'];
			$model->date_last_modified = date("Y-m-d H:i:s");
			if($model->save())
				$this->redirect(array('view','id'=>$model->pageid));
		}

		$this->render('update',array(
			'model'=>$model, 'gibcat'=>$gibcat,
		));
	}
	public function actionUpdatemenu($id) {
		$model = $this->loadmodel($id,true);
		$menu = true;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Pagemenu']))
		{
			$model->attributes=$_POST['Pagemenu'];
			if($model->save())
				$this->redirect('/admincms/pages/menu');
		}

		$this->render('update',array(
			'model'=>$model,
			'menu'=>$menu,
		));
	}
	public function actionUpdatemenuitems($id) {
		$model = $this->loadmodel($id,false,true);
		$menuitem = true;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if (isset($_POST['PagemenuItems'])) {
			$model->attributes=$_POST['PagemenuItems'];
			if ($model->validateAbsoluteurlandPageid()) {
				if($model->save()) {
					Yii::app()->user->setFlash('actionUpdatemenuitems','Menu item successfully updated');
					$this->redirect(Yii::app()->createUrl("/admincms/pages/createmenuitem/".$_GET['menuid']));
				}
			}
			
		}
		$model_cms = new PagemenuItems_cms;
		$dataProvider = $model_cms->getmenuitems($_GET['menuid']);
		$menu_model = $this->loadmodel($_GET['menuid'], true,false);//load menu model for this id
		$this->render('update',array(
			'model'=>$model,
			'menuitem'=>$menuitem,
			'dataProvider'=>$dataProvider,
			'menuname'=>$menu_model->menuname,
		));	
	
	}
	
	public function actionAssignimages() {
		if (Yii::app()->request->isAjaxRequest && !empty($_POST['categoryid'])) { // For retriving the images per category
			$model=new GenericImageBank_cms;
			$model->categoryid = $_POST['categoryid'];
			$dataProvider = $model->getCategoryImages();
			$this->renderPartial('_ajaxContent',array(
				'dataProvider'=>$dataProvider,
				'page' => 'previewImages',
				'pageid' => $_POST['pageid'] 
				
			), false, false);
		}
		else if (Yii::app()->request->isAjaxRequest && !empty($_POST['getassinged_images'])) { // For retriving assigned images
			$model=new GenericImageBankPage;
			$model->pageid = $_POST['pageid'];
			$dataProvider = $model->getAssignedImages();
			$this->renderPartial('_ajaxContent',array(
				'dataProvider'=>$dataProvider,
				'page' => 'getAssignedImages',
				'pageid' => $_POST['pageid']
			), false, false);
		}
		else if (Yii::app()->request->isAjaxRequest && !empty($_GET['assign_image'])) { // To assign images for a page
			$model=new GenericImageBankPage;
			$model->pageid = $_GET['pageid'];
			$model->imageid = $_GET['imageid'];
			try {
				if($model->save()) {
					$dataProvider = $model->getAssignedImages();
					$this->renderPartial('_ajaxContent',array(
						'dataProvider'=>$dataProvider,
						'page' => 'getAssignedImages',
						'pageid' => $_GET['pageid']
					), false, false);		
				}
			}
			catch (Exception $e) {
				echo "<div class='errorSummary'><p>The image has already been assigned.&nbsp;&nbsp;&nbsp;<a href='javascript:;' onclick='getAssignedImages();return false;'>OK</a><br /><br /></p></div>";
			}			
		}
		else if (Yii::app()->request->isAjaxRequest && !empty($_GET['delete_img'])) {
			$imageid = $_GET['imageid'];
			$pageid = $_GET['pageid'];
			$model = GenericImageBankPage::model()->findByPk(array('imageid'=>$imageid , 'pageid'=>$pageid));//Primary key is a composite key
			if($model->delete()) {		
				$model->pageid = $pageid;
				$dataProvider = $model->getAssignedImages();
				$this->renderPartial('_ajaxContent',array(
					'dataProvider'=>$dataProvider,
					'page' => 'getAssignedImages',
					'pageid' => $pageid 
				), false, false);				
			}
		}	
		else if (Yii::app()->request->isAjaxRequest && !empty($_GET['assignOrderNo'])) {
			$orderno = $_GET['orderno'];
			$pageid = $_GET['pageid'];
			$imageid = $_GET['imageid'];
			$model = GenericImageBankPage::model()->findByPk(array('imageid'=>$imageid , 'pageid'=>$pageid));//Primary key is a composite key
			$model->orderno = $orderno;
			if($model->save()) {
				$model->pageid = $pageid;
				$dataProvider = $model->getAssignedImages();
				$this->renderPartial('_ajaxContent',array(
					'dataProvider'=>$dataProvider,
					'page' => 'getAssignedImages',
					'pageid' => $pageid 
				), false, false);				
			}
		}		
		else {
			if(!empty($_GET["delete_cat"])) {
				$model_pc = new Pagecontent;
				$model_pc->removeCategoryId($_GET["id"]);
			}
			$result_arr = GenericImageBankCategory::model()->findAll();
			$this->render('page_images',array(
				'id'=>$_GET['id'],
				'category_arr'=>$result_arr
			));
		}
	}
	
	
	public function actionAssignedImageCategories() {
		
		$model = new Pagecontent;
					
		if (Yii::app()->request->isAjaxRequest && !empty($_POST['getassinged_categories'])) { // For retriving assigned images
			$gibcat = new GenericImageBankCategory;
			
			$model->pageid = $_POST['pageid'];
			$row = $model->getCategoryByPageId($model->pageid);		

			$dataProvider = $gibcat->getCategoryByCategoryId($row["categoryid"]);
			$this->renderPartial('_ajaxContent',array(
				'dataProvider'=>$dataProvider,
				'page' => 'getAssignedCategry',
				'pageid' => $_POST['pageid']
			), false, false);
		} 
	}
	
	/**
	 * Lists all models.
	 */
	public function actionIndex() {
		if (Yii::app()->request->isAjaxRequest && !empty($_POST['delete_page_id'])) {//If this Action gets a Ajax request with a delete item id, item's deleted and recreate the content for Ajax response
			try {
				$this->loadModel($_POST['delete_page_id'])->delete();
			}
			catch (Exception $e) {
				echo "<div class='errorSummary'><p>Sorry, we cannot delete this page yet - please first delete the MENU item(s) to which this page (ID " . $_POST['delete_page_id'] . ") has been assigned, and try again. <a href='menu'>Manage Menus</a></p></div>";
			}
		}
		$model=new Pagecontent_cms;
		$model->getDataprovider_pages();
		if (Yii::app()->request->isAjaxRequest && !empty($_POST['delete_page_id']) && empty(Yii::app()->user->content_man_un)) //If Ajax request, _ajaxContent.php in the module is called
			$this->renderPartial('_ajaxContent',array(
				'dataProvider_published'=> $model->dataProvider_1,
				'dataProvider_unpublised' => $model->dataProvider_2,
				'check_unpublised_pages' => $model->check_provider,
				'page' => 'index',
			), false, false);
		else //default view file rendering
			$this->render('index',array(
				'dataProvider_published'=> $model->dataProvider_1,
				'dataProvider_unpublised' => $model->dataProvider_2,
				'check_unpublised_pages' => $model->check_provider,
			));
	}

	public function actionMenu() {
		if (Yii::app()->request->isAjaxRequest && !empty($_POST['delete_menu_id']) && empty(Yii::app()->user->content_man_un)){ //If this Action gets a Ajax request with a delete item id, item's deleted and recreate the content for Ajax response
			try {
				$this->loadModel($_POST['delete_menu_id'], true)->delete();  // delete the passed id from DB after loading the correct model
			}
			catch (Exception $e) {
				echo "<div class='errorSummary'><p>Please delete the menu items first</p></div>";
			}
		}
		$model=new Pagemenu_cms;
		$model->getDataprovider_menu();
		if (Yii::app()->request->isAjaxRequest && !empty($_POST['delete_menu_id'])) //If Ajax request, _ajaxContent.php in the module is called
			$this->renderPartial('_ajaxContent',array(
			'dataProvider_menu_main'=> $model->dataProvider_1,
			'dataProvider_menu_subnav' => $model->dataProvider_2,
			'check_menu_subnav' => $model->check_provider,
			'page' => 'menu',
			'pageSize' => 50,
		), false, false);
		else //default view file rendering
			$this->render('menu',array(
			'dataProvider_menu_main'=> $model->dataProvider_1,
			'dataProvider_menu_subnav' => $model->dataProvider_2,
			'check_menu_subnav' => $model->check_provider,
			'pageSize' => 50,
		));
	}
	
	

	/**
	 * Manages all models.
	 */
	public function actionAdmin() {
		$model=new Pagecontent('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Pagecontent']))
			$model->attributes=$_GET['Pagecontent'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id, $menu = false, $menuitem = false) {
		$model='';
		if($menu) {
			$model=Pagemenu::model()->findByPk((int)$id); // for menu
			if($model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		else if($menuitem) {
			$model=PagemenuItems::model()->findByPk((int)$id); // for menu item
			if($model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		else{	
			$model=Pagecontent::model()->findByPk((int)$id); // for pages
			if($model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}
	
	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model) {
		if(isset($_POST['ajax']) && $_POST['ajax']==='pagecontent-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
