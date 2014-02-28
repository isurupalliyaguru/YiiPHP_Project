<?php
Yii::import('application.modules.admincms.extensions.qtip.QTip');
// qtip options
$opts = array(
    'position' => array(
        'corner' => array(
            'target' => 'topRight',
            'tooltip' => 'bottomLeft'
            )
        ),
    'show' => array(
        'when' => array('event' => 'mouseover' ),
        'effect' => array( 'length' => 300 )
    ),
    'hide' => array(
        'when' => array('event' => 'mouseout' ),
        'effect' => array( 'length' => 500 )
    ),
    'style' => array(
        'color' => 'black',
        'name' => 'blue',
        'border' => array(
            'width' => 1,
            'radius' => 3,
        ),
    )
);
 
// apply tooltip on the jQuery selector (1 parameter)
QTip::qtip('.row a[title]', $opts);
?>
<div class="form">
<fieldset>
	<legend>Add/Edit Portfolio-entry</legend>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'portfolio-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'orderno', array('class'=>'form_controller')); ?>
		<?php echo $form->textField($model,'orderno'); ?>
		<?php echo $form->error($model,'orderno'); ?>
		<a class="help" href="javascript:;" title="Order Number of the page">Help</a>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'logo_image_filename', array('class'=>'form_controller')); ?>
		<?php echo $form->textField($model,'logo_image_filename', array('size'=>50,'maxlength'=>50, 'title'=>'Image name of the logo')); ?>
		<?php echo $form->error($model,'logo_image_filename'); ?>
		<a class="help" href="javascript:;" title="Eg:-'client_logo.jpg' OR 'some_company_logo.png'">Help</a>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title', array('class'=>'form_controller')); ?>
		<?php echo $form->textField($model,'title', array('size'=>60,'maxlength'=>100, 'title'=>'Title of the html page')); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'url', array('class'=>'form_controller')); ?>
		<?php echo $form->textField($model,'url', array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'url'); ?>
	</div>

	<div class="row">
		<?php echo "<div class='form_controller'><b>Launch Date</b> (yyyy-mm-dd)</div>" ?>
		<?php Yii::import('application.modules.admincms.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
				$this->widget('CJuiDateTimePicker',array(
				'model'=>$model, //Model object
				'attribute'=>'launch_date', //attribute name
                'mode'=>'date', //use "time","date" or "datetime" (default)
				'language' => '',
				'options'=>array(
				'showAnim'=>'fold',
                'dateFormat'=>'yy-mm-dd'), // jquery plugin options
			));
		?>
		<?php echo $form->error($model,'launch_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'short_desc', array('class'=>'form_controller')); ?>
		<?php echo $form->textArea($model,'short_desc', array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'short_desc'); ?>
		<a class="help" href="javascript:;" title="A short description about the client">Help</a>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'technology_desc', array('class'=>'form_controller')); ?>
		<?php echo $form->textArea($model,'technology_desc', array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'technology_desc'); ?>
	</div>

	<div class="row">
		<?php echo "<div class='form_controller'>Features :<br /> <span class='heighlight'>(use Line Breaks To Separate Each Point)</span></div>"; ?>
		<?php echo $form->textArea($model,'features_desc', array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'features_desc'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comments', array('class'=>'form_controller')); ?>
		<br />
		<div>
		<?php
			$this->widget('application.modules.admincms.extensions.ckeditor.CKEditorWidget',array(
			  "model"=>$model,                 # Data-Model
			  "attribute"=>'comments',          # Attribute in the Data-Model
			  "defaultValue"=>$model->comments,     			# Optional
			 
			 # Additional Parameter (Check http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html)
			  "config" => array(
				  "height"=>"150px",
				  "width"=>"96%",
				  "toolbar"=> array ( 
				  array('Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker','/','Bold','Italic','Underline','Strike','-','NumberedList','BulletedList','-','Outdent','Indent','Blockquote','-','Link','Unlink','-','Table','SpecialChar','-','Cut','Copy','Paste','-','Undo','Redo','-','Maximize', 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe'),
					),
				  ),
				) 
			  );

		?>
		</div>
		<?php echo $form->error($model,'comments'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'commentator', array('class'=>'form_controller')); ?>
		<?php echo $form->textField($model,'commentator',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'commentator'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'published', array('class'=>'form_controller')); ?>
		<?php echo $form->checkBox($model,'published', array('checked'=>'yes')); ?><br />
		<?php echo $form->error($model,'published'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->