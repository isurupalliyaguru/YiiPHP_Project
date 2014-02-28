<?php
//left menu items
Yii::import('application.modules.admincms.views.adminuser.inc_leftmenu',true);
getAdminLeftMenuItems($this,"changepassword");
?>
<?php if(Yii::app()->user->hasFlash('actionChangepassword')):?>
    <div class="success">
        <?php echo Yii::app()->user->getFlash('actionChangepassword'); ?>
    </div>
<?php endif; ?>

<?php if(Yii::app()->user->hasFlash('actionChangepassword_error')):?>
    <div class="errorSummary">
        <?php echo Yii::app()->user->getFlash('actionChangepassword_error'); ?>
    </div>
<?php endif; ?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user_password_change',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	
	<div class="row">
		<?php echo $form->labelEx($model,'old_password'); ?>
		<?php echo $form->passwordField($model,'old_password',array('size'=>30,'maxlength'=>30,'value' => '')); ?>
		<?php echo $form->error($model,'old_password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'new_password'); ?>
		<?php echo $form->passwordField($model,'new_password',array('size'=>60,'maxlength'=>100,'value' => '')); ?>
		<?php echo $form->error($model,'new_password'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'confirm_password'); ?>
		<?php echo $form->passwordField($model,'confirm_password',array('size'=>60,'maxlength'=>100,'value' => '')); ?>
		<?php echo $form->error($model,'confirm_password'); ?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton('Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->