<?php
$this->breadcrumbs=array(
	'Site Configurations'=>array('index'),
	$model->configid,
);

//left menu items
Yii::import('application.modules.admincms.views.siteConfiguration.inc_leftmenu',true);
getAdminLeftMenuItems($this,"view",$model);
?>

<h1>View Site Configuration</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'configid',
		'jscode_in_head',
		'jscode_upper_body',
		'jscode_lower_body',
		'default_email_address',
	),
)); ?>
