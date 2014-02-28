<?php
$this->breadcrumbs=array(
	'Generic Image Bank'=>array('Change Thumbnail'),
	'Create',
);

//left menu items
Yii::import('application.modules.admincms.views.genericImageBank.inc_leftmenu',true);
getAdminLeftMenuItems($this,"admin");

?>
<div class="form">
<fieldset>
	<legend>Upload Thumbnail Image</legend>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'generic-image-bank-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>
<input type='hidden' name='imgid' value='<?=$imgid?>' />
<div class="row">
	<label class="form_controller">Thumbnail Image</label>
	<?php echo $form->fileField($model,'upload_image'); ?>
	<?php echo $form->error($model,'upload_image'); ?>
</div>
<div class="row buttons">
	<?php echo CHtml::submitButton('Update'); ?>
</div>

<?php $this->endWidget(); ?>