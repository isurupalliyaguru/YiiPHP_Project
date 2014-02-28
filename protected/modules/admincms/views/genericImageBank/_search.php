<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'imageid'); ?>
		<?php echo $form->textField($model,'imageid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'image_fileref'); ?>
		<?php echo $form->textField($model,'image_fileref',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'image_height'); ?>
		<?php echo $form->textField($model,'image_height'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'image_width'); ?>
		<?php echo $form->textField($model,'image_width'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'image_version'); ?>
		<?php echo $form->textField($model,'image_version'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'image_type'); ?>
		<?php echo $form->textField($model,'image_type'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->