<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'pageid'); ?>
		<?php echo $form->textField($model,'pageid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sef_url'); ?>
		<?php echo $form->textField($model,'sef_url',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'menu_heading'); ?>
		<?php echo $form->textField($model,'menu_heading',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'html_content'); ?>
		<?php echo $form->textArea($model,'html_content',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'html_content2'); ?>
		<?php echo $form->textArea($model,'html_content2',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'html_h1'); ?>
		<?php echo $form->textField($model,'html_h1',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'html_title'); ?>
		<?php echo $form->textField($model,'html_title',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'meta_keywords'); ?>
		<?php echo $form->textArea($model,'meta_keywords',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'meta_description'); ?>
		<?php echo $form->textArea($model,'meta_description',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'published'); ?>
		<?php echo $form->textField($model,'published'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'parent_pageid'); ?>
		<?php echo $form->textField($model,'parent_pageid'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->