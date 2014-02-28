<?php
function getAdminLeftMenuItems($thisobj,$viewfile) {
/*
	pre:@param $thisobj is the current view object.
		@param $viewfile is the name of the viewfile the function is called.
	post: Returns the appropriate left menu for the viewfile.
*/
	$thisobj->menu ="";
	switch($viewfile) {
		case 'changepassword':
		case 'create':
			if(empty(Yii::app()->user->content_man_un)) {
				$thisobj->menu=array(
					array('label'=>'Manage Users', 'url'=>array('index'),'active'=>($thisobj->action->Id == 'index' ? true: false)),
					array('label'=>'Change My Password', 'url'=>array('changepassword'),'active'=>($thisobj->action->Id == 'changepassword' ? true: false)),
				);
			}
			else {
				$thisobj->menu=array(
					array('label'=>'Change My Password', 'url'=>array('changepassword'),'active'=>($thisobj->action->Id == 'changepassword' ? true: false)),
				);
			}
			return $thisobj->menu;
		
		case 'update':
		case 'admin':
			$thisobj->menu=array(
				array('label'=>'Manage Users', 'url'=>array('index'),'active'=>($thisobj->action->Id == 'index' ? true: false)),
				array('label'=>'Change My Password', 'url'=>array('changepassword'),'active'=>($thisobj->action->Id == 'changepassword' ? true: false)),
			);
			return $thisobj->menu;
	}
	
}

?>