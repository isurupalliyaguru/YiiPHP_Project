<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Manage',
);

//left menu items
Yii::import('application.modules.admincms.views.adminuser.inc_leftmenu',true);
getAdminLeftMenuItems($this,"admin");

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('adminuser-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Users</h1>
<?php echo CHtml::link('Create New User','/admincms/adminuser/create',array('class'=>'add_new')); ?>
<br/> <br/>
<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>
<?php $this->widget('widget.confirmDelete', array('ItmName'=>'user', 'confirmText'=>'user', 'delete_item_id'=>'delete_user_id', 'delete_item_name'=>'delete_user_name')); ?>
<div id="ajax_content">
<?php 
$this->renderPartial('_ajaxContent', array(
	'model'=>$model,
	'page'=>'index',
		)); ?>
</div>

