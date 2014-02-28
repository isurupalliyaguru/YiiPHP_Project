<?php
$this->breadcrumbs=array(
	'Newsletter Signups'=>array('index'),
	'Create',
);

//left menu items
Yii::import('application.modules.admincms.views.newsletterSignup.inc_leftmenu',true);
getAdminLeftMenuItems($this,"create","");
?>

<h1>Create NewsletterSignup</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>