<?php
$this->breadcrumbs=array(
	'Newsletter Signups'=>array('index'),
	$model->subscribeid,
);

//left menu items
Yii::import('application.modules.admincms.views.newsletterSignup.inc_leftmenu',true);
getAdminLeftMenuItems($this,"view",$model);
?>

<h1>View NewsletterSignup #<?php echo $model->subscribeid; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'subscribeid',
		'date_of_subscription',
		'email_address',
	),
)); ?>
