<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pagecontent-formmenu',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'menuname', array('class'=>'form_controller')); ?>
		<?php echo $form->textField($model,'menuname', array('size'=>50,'maxlength'=>50)); ?><br />
		<?php echo $form->error($model,'menuname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'published', array('class'=>'form_controller')); ?>
		<?php echo $form->checkBox($model,'published'); ?><br />
		<?php echo $form->error($model,'published'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_subnavigation', array('class'=>'form_controller')); ?>
		<?php echo $form->checkBox($model,'is_subnavigation'); ?><br />
		<?php echo $form->error($model,'is_subnavigation'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->