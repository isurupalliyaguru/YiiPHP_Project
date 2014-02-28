<?php
$this->breadcrumbs=array(
	'Generic Image Bank Categories',
);

//left menu items
Yii::import('application.modules.admincms.views.genericImageBankCategory.inc_leftmenu',true);
getAdminLeftMenuItems($this,"index");
?>

<h1>Generic Image Bank Categories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
