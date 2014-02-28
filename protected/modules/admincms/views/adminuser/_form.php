<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'adminuser-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<div class="row">
		<?php echo $form->labelEx($model,'username_email', array('class'=>'form_controller')); ?>
		<?php echo $form->textField($model,'username_email',array('size'=>60,'maxlength'=>128)); ?><br />
		<?php echo $form->error($model,'username_email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name', array('class'=>'form_controller')); ?>
		<?php echo $form->textField($model,'name',array('size'=>30,'maxlength'=>30)); ?><br />
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'adminuser_groupid', array('class'=>'form_controller')); ?>
		<?php echo $form->dropDownList($model,'adminuser_groupid', Adminuser::get_groupname()); ?>
		<?php echo $form->error($model,'adminuser_groupid'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'password', array('class'=>'form_controller')); ?>
		<?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>100)); ?><br />
		<?php echo $form->error($model,'password'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'Confirm password', array('class'=>'form_controller')); ?>
		<?php echo $form->passwordField($model,'confirm_password',array('size'=>60,'maxlength'=>100)); ?><br />
		<?php echo $form->error($model,'confirm_password'); ?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->