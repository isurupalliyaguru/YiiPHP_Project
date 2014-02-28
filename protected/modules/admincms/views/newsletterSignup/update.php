<?php
$this->breadcrumbs=array(
	'Newsletter Signups'=>array('index'),
	$model->subscribeid=>array('view','id'=>$model->subscribeid),
	'Update',
);

//left menu items
Yii::import('application.modules.admincms.views.newsletterSignup.inc_leftmenu',true);
getAdminLeftMenuItems($this,"update","");
?>

<h1>Update Newsletter Signup <?php echo $model->subscribeid; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>