<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'adminuser-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); 
	echo $form->hiddenField($model, 'adminuser_groupid');
	?>
	

	<div class="row">
		<?php echo $form->labelEx($model,'username_email'); ?>
		<?php echo $form->textField($model,'username_email',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'username_email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Old password'); ?>
		<?php echo $form->passwordField($model,'old_password',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'old_password'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'New password'); ?>
		<?php echo $form->passwordField($model,'new_password',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'old_password'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->