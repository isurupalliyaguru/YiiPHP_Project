<?php
if (isset($menu))  {
	$page = 'menu';
	$key ='menuid';
	$header = 'Menu';
}
else if(isset($menuitem)) {
	$page = 'menuitem';
	$key ='pagemenu_itemid';
	$header = 'Menu Item';	
}
else {
	$page = 'index';
	$key ='pageid';
	$header = 'Page';
}
$this->breadcrumbs=array(
	'Pages'=>array($page),
	'Update',
);
//left menu
Yii::import('application.modules.admincms.views.pages.inc_leftmenu',true);
getAdminLeftMenuItems($this,"update");
?>
<h3>Update  <?php echo $header . " ID " .$model->$key . " - ". (isset($model->sef_url) ? $model->sef_url : "") . ""; ?></h3>

<?php 
if (isset($menu)) 
	echo $this->renderPartial('_formmenu', array('model'=>$model));
else if (isset($menuitem))
	echo $this->renderPartial('_formmenu_item', array('model'=>$model,'dataProvider'=>$dataProvider,'menuname'=>$menuname));	
else
	echo $this->renderPartial('_form', array('model'=>$model, 'gibcat'=>$gibcat)); 
?>