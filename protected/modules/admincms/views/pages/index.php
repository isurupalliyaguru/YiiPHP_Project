<?php
$this->breadcrumbs=array(
	'Pages',
);
//left menu
Yii::import('application.modules.admincms.views.pages.inc_leftmenu',true);
getAdminLeftMenuItems($this,"index");
?>
<h1>Manage Pages</h1>
<?php echo CHtml::link('Add New Page','/admincms/pages/create',array('class'=>'search-button')); ?>	 
<?php 
//Call 'confirmDelete' widget
$this->widget('widget.confirmDelete', array('ItmName'=>'page', 'confirmText'=>'page', 'delete_item_id'=>'delete_page_id', 'delete_item_name'=>'delete_page_name')); ?>
<div id="ajax_content">
<?php $this->renderPartial('_ajaxContent', array(
			'dataProvider_published'=> $dataProvider_published,
			'dataProvider_unpublised' => $dataProvider_unpublised,
			'check_unpublised_pages' => $check_unpublised_pages,
			'page' => 'index',
		)); ?>
</div>