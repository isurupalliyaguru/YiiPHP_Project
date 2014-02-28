<?php
$this->breadcrumbs=array(
	'Newsletter Signups',
);

//left menu items
Yii::import('application.modules.admincms.views.newsletterSignup.inc_leftmenu',true);
getAdminLeftMenuItems($this,"index","");
?>

<h1>Newsletter Signups</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
