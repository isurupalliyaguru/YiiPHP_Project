<?php

class PagesController extends Controller {

	public $layout ='//layouts/column1';
	public $html_title = "";
	public $meta_keywords = "";
	public $meta_description = "";
	public $addon_css_class = "";
	public $pageid = "";
	public $error = "";
	
	public function actionIndex() {
		$this_sef_url = (!empty($_REQUEST['sef_url'])? $_REQUEST['sef_url'] : "home"); // getting the SEF URL. If it is empty we are setting it to home.
		try {
			$row = Pagecontent::model()->getPageContent($this_sef_url); // get the page content for the page
			$this->setPageAttributes($row);
			$this->_canonicalUrl = $this_sef_url;//All but home has no sef url
		}
		catch (Exception $error) { //catches any database errors
			throw new CHttpException(404,"The requested page is invalid."); // The page content for this requested page was not found.
		}
		if ($row) { // row is found (page has contents) so we are rending the default view
			$parent_page_sefurl = array();
			if(!empty($row['pageid']) && gIsModelEnabled("breadcrumb")){ 				
				$parent_page_sefurl = Pagecontent::model()->getBreadcrumbData($row['pageid']); //get breadcrumb array from SP
			}
			$this->render('default',array(
			'row'=>$row,
			'parent_page_sefurl'=>$parent_page_sefurl
			));
		}
		else throw new CHttpException(404,'The requested page is invalid.');// fail safe error. if somehow missed all above this should be an error.
		
	}
	
	public function actionError() { //This is the default error action to where it is redirected if a given action is not found; has been configured in config/main.php
	    if($error=app()->errorHandler->error) {		
	    	if(app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else {
				$row = Pagecontent::model()->getPageContent('pagenotfound'); // get the page content for the page
				if ($row) { // row is found (page has contents) so we are rending the default view
					$row['html_title'] .= (!empty($row['html_title']) ? ' ' : '') . ' (' . $error['code'] . ')';
					$this->setPageAttributes($row);		
					$this->render('default',array ('row'=>$row));
				}
				else
					$this->render('error', $error); // execute the error view file 	        	
			}
	    }
	}
	
	protected function setPageAttributes($row) {
		/* @param $row contains all the page DB content
			post: Sets page attributes for this $row['pageid']  OR does nothing if the page is not found
		*/
		if(!empty($row['pageid'])) { //if the page id is empty in the database result the requested 'sef_url' is incorrect. So the page id should not be empty.		
			$this->html_title = $row['html_title'];
			$this->meta_description = (!empty($row['meta_description']) ? $row['meta_description'] : app()->SiteConfig->defaultMetaDescription);
			$this->meta_keywords = (!empty($row['meta_keywords']) ? $row['meta_keywords'] : app()->SiteConfig->defaultMetaKeywords);
			$this->addon_css_class = ( !empty($row['addon_class']) ? $row['addon_class'] : "");
			$this->pageid = $row['pageid'];		
		}
	}
	
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='newsletter-signup-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

?>