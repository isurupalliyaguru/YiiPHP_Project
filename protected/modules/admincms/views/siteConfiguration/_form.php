<?php
Yii::import('application.modules.admincms.extensions.qtip.QTip');
//setting up qtip
Yii::import('application.modules.admincms.extensions.qtip.QTipSetup',true);// by passing the "true" parameter we are forcing the file including before execution of the code. (otherwise this will not function properly)
?>
<div class="form">
<fieldset>
	<legend>Site configuration </legend>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'site-configuration-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); 
	$help_text ="Use this only if you are familiar with Javascript. Include valid &lt;&zwnj;script language=&quot;javascript&quot; type=&quot;text/javascript&quot;&zwnj;&gt;  for example. This feature is useful for example if you want to integrate Google Analytics into your site.";
	?>
	<div class="row">
		<?php echo $form->labelEx($model,'default_meta_description', array('class'=>'form_controller')); ?><a class="help" href="javascript:;" title="Site default meta description">Help</a><br />
		<?php echo $form->textArea($model,'default_meta_description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'default_meta_description'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'default_meta_keywords', array('class'=>'form_controller')); ?><a class="help" href="javascript:;" title="Site default meta keywords">Help</a><br />
		<?php echo $form->textArea($model,'default_meta_keywords',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'default_meta_keywords'); ?>
	</div>	
	<div class="row">
		<?php echo $form->labelEx($model,'default_email_address', array('class'=>'form_controller')); ?><br/>
		<?php echo $form->textField($model,'default_email_address',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'default_email_address'); ?>
	</div>
	<a class="help" href="javascript:;" title="" onclick="javascript:$('#jscode_container').toggle('slow');" style='font-size: 12px; color: blue;'>Advanced users: Insert Javascript Code &gt;&gt;</a>
	<div id='jscode_container' style='display: none'>
		<div class="row">
			<?php echo $form->labelEx($model,'jscode_in_head', array('class'=>'form_controller')); ?><a class="help" href="javascript:;" title="<?=$help_text?>">Help</a><br />
			<?php echo $form->textArea($model,'jscode_in_head',array('rows'=>6, 'cols'=>50)); ?>
			<?php echo $form->error($model,'jscode_in_head'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'jscode_upper_body', array('class'=>'form_controller')); ?><a class="help" href="javascript:;" title="<?=$help_text?>">Help</a><br />
			<?php echo $form->textArea($model,'jscode_upper_body',array('rows'=>6, 'cols'=>50)); ?>
			<?php echo $form->error($model,'jscode_upper_body'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'jscode_lower_body', array('class'=>'form_controller')); ?><a class="help" href="javascript:;" title="<?=$help_text?>">Help</a><br />
			<?php echo $form->textArea($model,'jscode_lower_body',array('rows'=>6, 'cols'=>50)); ?>
			<?php echo $form->error($model,'jscode_lower_body'); ?>
		</div>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>
</fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->