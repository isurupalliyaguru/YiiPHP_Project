<?php
$this->breadcrumbs=array(
	'Generic Image Bank Categories'=>array('createCategory'),
	'Manage',
);

//left menu items
Yii::import('application.modules.admincms.views.genericImageBankCategory.inc_leftmenu',true);
getAdminLeftMenuItems($this,"admin");

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('generic-image-bank-category-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Image Categories</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>
<?php $this->widget('widget.confirmDelete', array('ItmName'=>'image category', 'confirmText'=>'image category', 'ajaxAction'=>'adminCategory', 'delete_item_id'=>'delete_imgCat_id', 'delete_item_name'=>'delete_imgCat_name')); ?>
<div id="ajax_content">
<?php 
$this->renderPartial('_ajaxContent', array(
	'model'=>$model,
	'page'=>'MIC',
)); 
?>
</div>
