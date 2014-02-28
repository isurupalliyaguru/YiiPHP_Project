<?php
$this->breadcrumbs=array(
	'Newsletter Signups'=>array('index'),
	'Manage',
);

//left menu items
Yii::import('application.modules.admincms.views.newsletterSignup.inc_leftmenu',true);
getAdminLeftMenuItems($this,"admin","");

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('newsletter-signup-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Newsletter Signups</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>
<?php $this->widget('widget.confirmDelete', array('ItmName'=>'News letter', 'confirmText'=>'Are you sure you want to delete this item', 'ajaxAction'=>'admin', 'delete_item_id'=>'delete_newslettr_subscription_id', 'delete_item_name'=>'delete_newslettr_subscription')); ?>

<div id="ajax_content">
<?php 
$this->renderPartial('_ajaxContent', array(
	'model'=>$model,
	'page'=>'MNLS',//manage news letter signup
		)); ?>
</div>
