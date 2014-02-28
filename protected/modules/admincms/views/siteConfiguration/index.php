<?php
$this->breadcrumbs=array(
	'Site Configurations',
);

//left menu items
Yii::import('application.modules.admincms.views.siteConfiguration.inc_leftmenu',true);
getAdminLeftMenuItems($this,"index","");
?>

<h1>Site Configurations</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
