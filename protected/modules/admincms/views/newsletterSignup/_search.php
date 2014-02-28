<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'subscribeid'); ?>
		<?php echo $form->textField($model,'subscribeid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_of_subscription'); ?>
		<?php echo $form->textField($model,'date_of_subscription'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'email_address'); ?>
		<?php echo $form->textField($model,'email_address',array('size'=>60,'maxlength'=>128)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->