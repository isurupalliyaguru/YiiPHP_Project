<?php
$this->breadcrumbs=array(
	'Update',
);

//left menu items
Yii::import('application.modules.admincms.views.siteConfiguration.inc_leftmenu',true);
getAdminLeftMenuItems($this,"update",$model);
?>

<h1>Update Site Configuration</h1>
<?php if(Yii::app()->user->hasFlash('actionUpdate')):?>
    <div class="success">
        <?php echo Yii::app()->user->getFlash('actionUpdate'); ?>
    </div>
<?php endif; ?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>