<?php if(Yii::app()->user->hasFlash('actionCreateImagetype')):?>
    <div class="success">
        <?php echo Yii::app()->user->getFlash('actionCreateImagetype'); ?>
    </div>
<?php endif; ?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'category_name-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'category_name'); ?>
		<?php echo $form->textField($model,'category_name',array('size'=>60,'maxlength'=>100,'value'=>'')); ?>
		<?php echo $form->error($model,'category_name'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->