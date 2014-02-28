<?php
$this->breadcrumbs=array(
	'Generic Image Bank Categories'=>array('createCategory'),
	'Create',
);

//left menu items
Yii::import('application.modules.admincms.views.genericImageBankCategory.inc_leftmenu',true);
getAdminLeftMenuItems($this,"create");
?>

<h1>Create image category</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>