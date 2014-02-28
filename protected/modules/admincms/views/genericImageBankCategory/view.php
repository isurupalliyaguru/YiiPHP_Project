<?php
$this->breadcrumbs=array(
	'Generic Image Bank Categories'=>array('index'),
	$model->categoryid,
);

//left menu items
Yii::import('application.modules.admincms.views.genericImageBankCategory.inc_leftmenu',true);
getAdminLeftMenuItems($this,"view");
?>

<h1>View GenericImageBankCategory #<?php echo $model->categoryid; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'categoryid',
		'category_name',
	),
)); ?>
