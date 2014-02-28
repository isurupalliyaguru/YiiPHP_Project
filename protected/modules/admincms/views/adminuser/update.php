<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Update',
);
//left menu items
Yii::import('application.modules.admincms.views.adminuser.inc_leftmenu',true);
getAdminLeftMenuItems($this,"update");

?>

<h1>Update Users <?php echo $model->userid; ?></h1>

<?php echo $this->renderPartial('_form_update', array('model'=>$model)); ?>