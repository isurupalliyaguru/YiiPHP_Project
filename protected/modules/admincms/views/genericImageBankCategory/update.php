<?php
$this->breadcrumbs=array(
	'Generic Image Bank Categories'=>array('createCategory'),
	'Update',
);

//left menu items
Yii::import('application.modules.admincms.views.genericImageBankCategory.inc_leftmenu',true);
getAdminLeftMenuItems($this,"update");
?>

<h1>Update image category <?php echo $model->categoryid; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>