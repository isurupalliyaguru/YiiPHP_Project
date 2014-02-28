<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'portfolio_id'); ?>
		<?php echo $form->textField($model,'portfolio_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'orderno'); ?>
		<?php echo $form->textField($model,'orderno'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'logo_image_filename'); ?>
		<?php echo $form->textField($model,'logo_image_filename',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'url'); ?>
		<?php echo $form->textField($model,'url',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'launch_date'); ?>
		<?php echo $form->textField($model,'launch_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'short_desc'); ?>
		<?php echo $form->textArea($model,'short_desc',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'technology_desc'); ?>
		<?php echo $form->textArea($model,'technology_desc',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'features_desc'); ?>
		<?php echo $form->textArea($model,'features_desc',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'comments'); ?>
		<?php echo $form->textArea($model,'comments',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'commentator'); ?>
		<?php echo $form->textField($model,'commentator',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'published'); ?>
		<?php echo $form->textField($model,'published'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->