<?php
$this->breadcrumbs=array(
	'Site Configurations'=>array('index'),
	'Create',
);

//left menu items
Yii::import('application.modules.admincms.views.siteConfiguration.inc_leftmenu',true);
getAdminLeftMenuItems($this,"create","");
?>

<h1>Create SiteConfiguration</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>