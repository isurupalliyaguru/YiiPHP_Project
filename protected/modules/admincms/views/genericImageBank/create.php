<?php
$this->breadcrumbs=array(
	'Generic Image Bank'=>array('create'),
	'Create',
);

//left menu items
Yii::import('application.modules.admincms.views.genericImageBank.inc_leftmenu',true);
getAdminLeftMenuItems($this,"create");

?>
<?php 
if ($this->action->Id == 'ImageCategory')
	echo "<h1>Create new image type</h1>";
else
	echo "<h1>Upload a new image</h1>"; 
?>

<?php if(Yii::app()->user->hasFlash('actionCreate')):?>
    <div class="success">
        <?php echo Yii::app()->user->getFlash('actionCreate'); ?>
    </div>
<?php endif;
if (!empty($imgpath))
	echo "<b>Image path:</b><span style='color:red'> " . $imgpath . "</span>";
 ?>


<?php 
if ($this->action->Id == 'ImageCategory')
	echo $this->renderPartial('_form_image_category', array('model'=>$model));
else
	echo $this->renderPartial('_form', array('model'=>$model)); 
?>
