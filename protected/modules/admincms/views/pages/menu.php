<?php
$this->breadcrumbs=array(
	'Pages',
);
//left menu
Yii::import('application.modules.admincms.views.pages.inc_leftmenu',true);
getAdminLeftMenuItems($this,"menu");
?>
<h1>Manage Menu</h1>
<?php 
echo CHtml::link('Add New Menu','createmenu',array('class'=>'search-button'));
?>
<?php $this->widget('widget.confirmDelete', array('ItmName'=>'menu', 'confirmText'=>'menu item', 'ajaxAction'=>'menu', 'delete_item_id'=>'delete_menu_id', 'delete_item_name'=>'delete_menu_name')); ?>
<div id="ajax_content">
<?php $this->renderPartial('_ajaxContent', array(
			'dataProvider_menu_main'=> $dataProvider_menu_main,
			'dataProvider_menu_subnav' => $dataProvider_menu_subnav,
			'check_menu_subnav' => $check_menu_subnav,
			'page' => 'menu',
			'baseURL'=>Yii::app()->request->baseUrl,
		)); ?>
</div>
