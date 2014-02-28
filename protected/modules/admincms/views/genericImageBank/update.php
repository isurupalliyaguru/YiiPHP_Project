<?php
$this->breadcrumbs=array(
	'Generic Image Bank'=>array('create'),
	'Update',
);

//left menu items
Yii::import('application.modules.admincms.views.genericImageBank.inc_leftmenu',true);
getAdminLeftMenuItems($this,"update"); 
?>

<h1>Update image <?php echo $model->imageid; ?></h1>
<?php if(Yii::app()->user->hasFlash('actionUpdate')):?>
    <div class="success">
        <?php echo Yii::app()->user->getFlash('actionUpdate'); ?>
    </div>
<?php endif; ?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>