<?php
$this->breadcrumbs=array(
	'Generic Image Bank'=>array('index'),
	$model->imageid,
);

//left menu items
Yii::import('application.modules.admincms.views.genericImageBank.inc_leftmenu',true);
getAdminLeftMenuItems($this,"view");
?>

<h1>View GenericImageBank #<?php echo $model->imageid; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'imageid',
		'image_fileref',
		'image_height',
		'image_width',
		'image_version',
		'image_type',
	),
)); ?>
