<?php
function getAdminLeftMenuItems($thisobj,$viewfile) {
/*
	pre:@param $thisobj is the current view object.
		@param $viewfile is the name of the viewfile the function is called.
	post: Returns the appropriate left menu for the viewfile.
*/
	$thisobj->menu ="";
	switch($viewfile) {
		case 'page_images':
		case 'view':
		case 'index':
		case 'menu':
			$thisobj->menu=array(
				array('label'=>'Manage Pages', 'url'=>array('index'),'active'=>($thisobj->action->Id == 'index' ? true: false)),
				array('label'=>'Manage Menus', 'url'=>array('menu'),'active'=>($thisobj->action->Id == 'menu' ? true: false)),
			);
			return $thisobj->menu;
		case 'create':
			$thisobj->menu=array(
				array('label'=>'Manage Pages', 'url'=>array('index'),'active'=>($thisobj->action->Id == 'index'|| $thisobj->action->Id == 'create' ? true: false)),
				array('label'=>'Manage Menus', 'url'=>array('menu'),'active'=>($thisobj->action->Id == 'menu'|| $thisobj->action->Id == 'createmenu' || $thisobj->action->Id == 'createmenuitem' ? true: false)),
			);
			return $thisobj->menu;
		case 'update':
			$thisobj->menu=array(
				array('label'=>'Manage Pages', 'url'=>array('index'),'active'=>($thisobj->action->Id == 'index' ? true: false)),
				array('label'=>'Manage Menus', 'url'=>array('menu'),'active'=>($thisobj->action->Id == 'menu'||$thisobj->action->Id == 'updatemenu' ? true: false)),
			);
			return $thisobj->menu;
	}
	
}





?>