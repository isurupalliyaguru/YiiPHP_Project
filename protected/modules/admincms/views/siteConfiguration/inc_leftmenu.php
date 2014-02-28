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
		case 'admin':
			$thisobj->menu=array(
				array('label'=>'List SiteConfiguration', 'url'=>array('index')),
				array('label'=>'Create SiteConfiguration', 'url'=>array('create')),
			);
			return $thisobj->menu;
		case 'index':
		case 'create':
			$thisobj->menu=array(
				array('label'=>'Create SiteConfiguration', 'url'=>array('create')),
				array('label'=>'Manage SiteConfiguration', 'url'=>array('admin')),
			);
			return $thisobj->menu;
		case 'view':		
			$thisobj->menu=array(
				array('label'=>'Update SiteConfiguration', 'url'=>array('update', 'id'=>$model->configid),'active'=>($thisobj->action->Id == 'update' ? true: false)),
			);
			return $thisobj->menu;
		case 'update':		
			$thisobj->menu=array(
				array('label'=>'Update Site Configuration', 'url'=>array('update', 'id'=>$model->configid),'active'=>($thisobj->action->Id == 'update' ? true: false)),
				/*array('label'=>'Location details', 'url'=>array('location/admin'),'active'=>( $thisobj->action->Id == 'update' && Yii::app()->controller->id == 'Location' ? true: false)),*/
			);
			return $thisobj->menu;
	}
	
}

?>