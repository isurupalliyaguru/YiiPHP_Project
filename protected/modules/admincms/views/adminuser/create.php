<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Create',
);
//left menu items
Yii::import('application.modules.admincms.views.adminuser.inc_leftmenu',true);
getAdminLeftMenuItems($this,"create");
?>

<h1>Create Users</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>