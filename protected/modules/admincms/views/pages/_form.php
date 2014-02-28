<?php
Yii::import('application.modules.admincms.extensions.qtip.QTip');
//setting up qtip
Yii::import('application.modules.admincms.extensions.qtip.QTipSetup',true);// by passing the "true" parameter we are forcing the file including before execution of the code. (otherwise this will not function properly)

Yii::app()->clientScript->registerScriptFile(Yii::app()->request->getBaseUrl(true)."/admin/js/admin_common.js",CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScript("counter",
	"$(document).ready(function(){	
		$('#html_title').charCount({
			allowed: 70,		
			warning: 10,
			counterText: 'Recommended characters left: '	
		});
	});"
,CClientScript::POS_END);
?>
<div class="form">
<fieldset>
	<legend>Add/Edit Page</legend>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pagecontent-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	

	<div class="row">
		<?php echo $form->labelEx($model,'sef_url<span class="required"> *</span><span class="heighlight"> (edit only for search engine purposes)</span>', array('class'=>'form_controller')); ?>
		<?php echo $form->textField($model,'sef_url',array('size'=>50,'maxlength'=>50)); ?><a class="help" href="javascript:;" title="Search Engine friendly URL">Help</a><br />
		<?php echo $form->error($model,'sef_url'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'meta_description', array('class'=>'form_controller')); ?>
		<?php echo $form->textArea($model,'meta_description',array('rows'=>6, 'cols'=>50)); ?><br />
		<?php echo $form->error($model,'meta_description'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'meta_keywords', array('class'=>'form_controller')); ?>
		<?php echo $form->textArea($model,'meta_keywords',array('rows'=>6, 'cols'=>50)); ?><br />
		<?php echo $form->error($model,'meta_keywords'); ?>
	</div>
	<div class="row">
		<?php echo "<label class=\"form_controller\">Menu Heading<span class=\"required\"> *</span><span style=\"font-weight: normal;\"> (default reference for this page)</span></label>"; ?>
		<?php echo $form->textField($model,'menu_heading',array('size'=>60,'maxlength'=>100)); ?><br />
		<?php echo $form->error($model,'menu_heading'); ?>
	</div>
	<div class="spacer_1px"></div>
	<div class="row">
		<?php echo $form->labelEx($model,'html_h1', array('class'=>'form_controller')); ?>
		<?php echo $form->textField($model,'html_h1',array('size'=>60,'maxlength'=>200)); ?><br />
		<?php echo $form->error($model,'html_h1'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'html_title', array('class'=>'form_controller')); ?>
		<?php echo $form->textField($model,'html_title',array('size'=>60,'maxlength'=>200,'id'=>'html_title')); ?><br />
		<?php echo $form->error($model,'html_title'); ?>
	</div>
	<div class="spacer_1px"></div>
	<div class="row">
		<?php echo "<label class=\"form_controller\">Content</label></br><span class=\"heighlight\"> (if copying from Word, please use the 'paste from Word' icon below, or 'paste as plain text' icon to remove formatting)</span>";  ?>
		</br>
	</div>
	<div class="row">
		<?php
			
			$this->widget('application.modules.admincms.extensions.ckeditor.CKEditorWidget',
			array(
			  "model"=>$model,                 # Data-Model
			  "attribute"=>'html_content',          # Attribute in the Data-Model
			  "defaultValue"=>$model->html_content,     # Optional
			 
			 # Additional Parameter (Check http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html)
			  "config" => 
				array(
				  "height"=>"150px",
				  "width"=>"96%",
				  "toolbar"=>"Full",
					'filebrowserBrowseUrl' => Yii::app()->getBaseUrl(true),
				),
			) 
		);

		?>

		<?php //echo $form->textArea($model,'html_content',array('rows'=>6, 'cols'=>50)); ?><br />
		<?php echo $form->error($model,'html_content'); ?>
	</div>

	<div class="row">
		<?php echo "<label class=\"form_controller\">Secondary Content</label></br><span class=\"heighlight\"> (if copying from Word, please use the 'paste from Word' icon below, or 'paste as plain text' icon to remove formatting)</span>";  ?>
		</br>
	</div>
	<div class="row">
		<?php
			$this->widget('application.modules.admincms.extensions.ckeditor.CKEditorWidget',array(
			  "model"=>$model,                 # Data-Model
			  "attribute"=>'html_content2',          # Attribute in the Data-Model
			  "defaultValue"=>$model->html_content2,     # Optional
			 
			 # Additional Parameter (Check http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html)
			  "config" => array(
				  "height"=>"150px",
				  "width"=>"96%",
				   "toolbar"=>"Full",
				   'filebrowserBrowseUrl' => Yii::app()->getBaseUrl(true),
				  ),
				) 
			  );

		?>
		<br />
		<?php echo $form->error($model,'html_content2'); ?>
	</div>
	
	<div class="row">
		<?php echo "<label class=\"form_controller\">Extra Content (certain templates only)</label></br><span class=\"heighlight\"> (if copying from Word, please use the 'paste from Word' icon below, or 'paste as plain text' icon to remove formatting)</span>";  ?>
		</br>
	</div>
	<div class="row">
		<?php
			$this->widget('application.modules.admincms.extensions.ckeditor.CKEditorWidget',array(
			  "model"=>$model,                 # Data-Model
			  "attribute"=>'html_content3',          # Attribute in the Data-Model
			  "defaultValue"=>$model->html_content3,     # Optional
			 
			 # Additional Parameter (Check http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html)
			  "config" => array(
				  "height"=>"150px",
				  "width"=>"96%",
				   "toolbar"=>"Full",
				   'filebrowserBrowseUrl' => Yii::app()->getBaseUrl(true),
				  ),
				) 
			  );

		?>
		<br />
		<?php echo $form->error($model,'html_content3'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'addon_class', array('class'=>'form_controller')); ?>
		<?php echo $form->textField($model,'addon_class',array('size'=>60,'maxlength'=>50)); ?><a class="help" href="javascript:;" title="Add CSS class for the page">Help</a><br />
		<?php echo $form->error($model,'addon_class'); ?>
	</div>	
	<div class="row">
		<?php echo $form->labelEx($model,'published', array('class'=>'form_controller')); ?>
		<?php echo $form->checkBox($model,'published'); ?><br />
		<?php echo $form->error($model,'published'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'parent_pageid', array('class'=>'form_controller')); ?>
		<?php echo $form->dropDownList($model,'parent_pageid', Pagecontent_cms::parentpageID(), array('prompt'=>'none')); ?><br />
		<?php echo $form->error($model,'parent_pageid'); ?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>
</fieldset>
</div><!-- form -->