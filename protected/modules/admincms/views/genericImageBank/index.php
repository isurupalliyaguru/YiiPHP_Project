<?php
$this->breadcrumbs=array(
	'Generic Image Bank',
);

//left menu items
Yii::import('application.modules.admincms.views.genericImageBank.inc_leftmenu',true);
getAdminLeftMenuItems($this,"index");
?>

<h1>Generic Image Banks</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
