<?php
Yii::import('application.modules.admincms.extensions.qtip.QTip');
//setting up qtip
Yii::import('application.modules.admincms.extensions.qtip.QTipSetup',true);// by passing the "true" parameter we are forcing the file including before execution of the code. (otherwise this will not function properly)
?>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'generic-image-bank-category-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row" <?=(Yii::app()->controller->action->id == 'update' ? ' style="display:none"' : '')?>>
		<?php echo $form->labelEx($model,'parentcatid', array('class'=>'form_controller')); ?>
		<?php echo $form->dropDownList($model,'parentcatid', $model->parentcatID(), array('prompt'=>'none')); ?><a class="help" href="javascript:;" title="Development team (super users) can create Parent categories, keeping this feild blank. Others, please select an option.">Help</a><br />
		<?php echo $form->error($model,'parentcatid'); ?>
	</div>	
	
	<div class="row">
		<?php echo $form->labelEx($model,'category_name', array('class'=>'form_controller')); ?>
		<?php echo $form->textField($model,'category_name',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'category_name'); ?>
	</div>
	<div class="row">
		<label for="GenericImageBankCategory_category_name" class="form_controller required">Thumbnail Dimension<span class="required">*</span></label>
		<?php echo $form->textField($model,'thumbnail_width',array('size'=>10,'maxlength'=>10, 'placeholder'=>'width')); ?>&nbsp;&nbsp;x&nbsp;
		<?php echo $form->textField($model,'thumbnail_height',array('size'=>10,'maxlength'=>10, 'placeholder'=>'height')) . " px"; ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'sef_url', array('class'=>'form_controller')); ?>
		<?php echo $form->textField($model,'sef_url',array('size'=>60,'maxlength'=>100)); ?><a class="help" href="javascript:;" title="This is used for categorised image galleries. Please leave it blank, if you are not sure.">Help</a>
		<?php echo $form->error($model,'sef_url'); ?>
	</div>	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

