<?php
function getAdminLeftMenuItems($thisobj,$viewfile) {
/*
	pre:@param $thisobj is the current view object.
		@param $viewfile is the name of the viewfile the function is called.
	post: Returns the appropriate left menu for the viewfile.
*/
	$thisobj->menu ="";
	switch($viewfile) {
		case 'create':
		case 'update':
		case 'admin':
			$thisobj->menu=array(
				array('label'=>'Add New Image', 'url'=>array('genericImageBank/create'),'active'=>($thisobj->action->Id == 'create' ? true: false)),
				array('label'=>'Manage Image Bank', 'url'=>array('genericImageBank/admin'),'active'=>($thisobj->action->Id == 'admin' ? true: false)),
				array('label'=>'Manage Image Categories', 'url'=>array('genericImageBankCategory/adminCategory'),'active'=>($thisobj->action->Id == 'admincategory' ? true: false)),
				array('label'=>'Add' . (!empty(Yii::app()->user->super_user_un) ? " Main/" : ' ') . 'Sub Category', 'url'=>array('genericImageBankCategory/createCategory/'),'active'=>($thisobj->action->Id == 'CreateCategory' ? true: false))
			);
			return $thisobj->menu;			
		case 'index':
		case 'view':
			$thisobj->menu=array(
				array('label'=>'Add New Image', 'url'=>array('create'),'active'=>($thisobj->action->Id == 'create' ? true: false)),
				array('label'=>'Manage Generic Image Bank', 'url'=>array('admin'),'active'=>($thisobj->action->Id == 'admin' ? true: false)),
			);
			return $thisobj->menu;			
	}
	
}

?>