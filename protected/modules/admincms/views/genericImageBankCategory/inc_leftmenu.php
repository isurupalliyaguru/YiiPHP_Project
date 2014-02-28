<?php
function getAdminLeftMenuItems($thisobj,$viewfile) {
/*
	pre:@param $thisobj is the current view object.
		@param $viewfile is the name of the viewfile the function is called.
	post: Returns the appropriate left menu for the viewfile.
*/
	$thisobj->menu ="";
	switch($viewfile) {
		case 'admin':
		case 'update':
		case 'create':
			$thisobj->menu=array(
				array('label'=>'Add New Image', 'url'=>array('genericImageBank/create'),'active'=>($thisobj->action->Id == 'create' ? true: false)),
				array('label'=>'Manage Image Bank', 'url'=>array('genericImageBank/admin'),'active'=>($thisobj->action->Id == 'admin' ? true: false)),
				array('label'=>'Manage Image Categories', 'url'=>array('genericImageBankCategory/adminCategory'),'active'=>($thisobj->action->Id == 'adminCategory' ? true: false)),
				array('label'=>'Add' . (!empty(Yii::app()->user->super_user_un) ? " Main/" : ' ') . 'Sub Category', 'url'=>array('genericImageBankCategory/createCategory/'),'active'=>($thisobj->action->Id == 'CreateCategory' ? true: false))
			);
			return $thisobj->menu;
			
		case 'view':	
			$this->menu=array(
				array('label'=>'List GenericImageBankCategory', 'url'=>array('index')),
				array('label'=>'Create GenericImageBankCategory', 'url'=>array('create')),
				array('label'=>'Update GenericImageBankCategory', 'url'=>array('update', 'id'=>$model->categoryid)),
				array('label'=>'Delete GenericImageBankCategory', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->categoryid),'confirm'=>'Are you sure you want to delete this item?')),
				array('label'=>'Manage GenericImageBankCategory', 'url'=>array('admin')),
			);
			return $thisobj->menu;
		
		case 'index':
			$this->menu=array(
				array('label'=>'Create GenericImageBankCategory', 'url'=>array('create')),
				array('label'=>'Manage GenericImageBankCategory', 'url'=>array('admin')),
			);
			return $thisobj->menu;
	}
	
}

?>