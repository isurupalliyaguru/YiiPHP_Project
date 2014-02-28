<?php
$this->breadcrumbs=array(
	'Site Configurations'=>array('index'),
	'Manage',
);

//left menu items
Yii::import('application.modules.admincms.views.siteConfiguration.inc_leftmenu',true);
getAdminLeftMenuItems($this,"admin","");

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('site-configuration-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Site Configurations</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'site-configuration-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'configid',
		'jscode_in_head',
		'jscode_upper_body',
		'jscode_lower_body',
		'default_email_address',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
