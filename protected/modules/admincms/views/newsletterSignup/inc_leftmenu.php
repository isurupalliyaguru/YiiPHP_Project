<?php
function getAdminLeftMenuItems($thisobj,$viewfile,$model="") {
/*
	pre:@param $thisobj is the current view object.
		@param $viewfile is the name of the viewfile the function is called.
		@param $model is the model file which the view is used.
	post: Returns the appropriate left menu for the viewfile.
*/
	$thisobj->menu ="";
	switch($viewfile) {
		case 'csv':
		case 'admin':
		case 'create':
			$thisobj->menu=array(
				array('label'=>'Create Newsletter Signup', 'url'=>array('create'),'active'=>($thisobj->action->Id == 'create' ? true: false)),
				array('label'=>'Manage Newsletter Signup', 'url'=>array('admin'),'active'=>($thisobj->action->Id == 'admin' ? true: false)),
				array('label'=>'Export to CSV', 'url'=>array('exportcsv'),'active'=>($thisobj->action->Id == 'exportcsv' ? true: false)),
			);
			return $thisobj->menu;
			
		case 'update':	
			$thisobj->menu=array(
				array('label'=>'Create Newsletter Signup', 'url'=>array('create'),'active'=>($thisobj->action->Id == 'create' ? true: false)),
				array('label'=>'Manage Newsletter Signup', 'url'=>array('admin'),'active'=>($thisobj->action->Id == 'admin' ? true: false)),
			);
			return $thisobj->menu;
			
		case 'index':	
			$thisobj->menu=array(
				array('label'=>'Create NewsletterSignup', 'url'=>array('create')),
				array('label'=>'Manage NewsletterSignup', 'url'=>array('admin')),
			);
			return $thisobj->menu;
			
		case 'view':	
			$thisobj->menu=array(
				array('label'=>'List NewsletterSignup', 'url'=>array('index')),
				array('label'=>'Create NewsletterSignup', 'url'=>array('create')),
				array('label'=>'Update NewsletterSignup', 'url'=>array('update', 'id'=>$model->subscribeid)),
				array('label'=>'Delete NewsletterSignup', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->subscribeid),'confirm'=>'Are you sure you want to delete this item?')),
				array('label'=>'Manage NewsletterSignup', 'url'=>array('admin')),
			);
			return $thisobj->menu;
	}
	
}

?>