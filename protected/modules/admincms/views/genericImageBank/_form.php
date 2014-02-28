<?php
Yii::import('application.modules.admincms.extensions.qtip.QTip');
//setting up qtip
Yii::import('application.modules.admincms.extensions.qtip.QTipSetup',true);// by passing the "true" parameter we are forcing the file including before execution of the code. (otherwise this will not function properly)
?> 
<div class="form">
<fieldset>
	<legend>Upload New Image</legend>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'generic-image-bank-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>
	<p class="note">This is used for widgets only. If you want to upload images to your page, please use the content editor in the Pages section of the CMS.</p>
	
	<?php echo $form->errorSummary($model); ?>
	<div class="row"<?=(Yii::app()->controller->action->id == 'update' ? ' style="display:none"' : '')?>>
		<?php echo $form->labelEx($model,'categoryid',array('class'=>'form_controller')); ?>
		<?php 
		$selID = (empty($model->parentcatid) ? $model->categoryid : $model->parentcatid);
		echo $form->dropDownList($model,'categoryid',$model->getImageCategory(), array('options' => array($selID=>array('selected'=>true)))); ?>
		<?php echo $form->error($model,'categoryid'); ?>
	</div>
	<div id='ajax_subcat'<?=(Yii::app()->controller->action->id == 'update' ? ' style="display:none"' : '')?>></div>
	<div class="row">
		<?php echo $form->labelEx($model,'upload_image',array('class'=>'form_controller')); ?>
		<?php echo $form->fileField($model,'upload_image'); ?>
		<?php echo $form->error($model,'upload_image'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'image_alt', array('class'=>'form_controller')); ?>
		<?php echo $form->textField($model,'image_alt',array('size'=>50,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'image_alt'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'image_title', array('class'=>'form_controller')); ?>
		<?php echo $form->textField($model,'image_title',array('size'=>50,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'image_title'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'url', array('class'=>'form_controller')); ?>
		<?php echo $form->textField($model,'url',array('size'=>50,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'url'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'order_no', array('class'=>'form_controller')); ?>
		<?php echo $form->textField($model,'order_no',array('size'=>5,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'order_no'); ?>
	</div>	
	<div class="spacer_1px"></div>
	<div class="row">
		<?php echo "<label class=\"form_controller\">Image HTML</label><a class='help' href='javascript:;' title=\"This field is applicable only for specific templates where rich (HTML) content is used with the image.\">Help</a></br><span class=\"heighlight\"> (if copying from Word, please use the 'paste from Word' icon below, or 'paste as plain text' icon to remove formatting)</span>";  ?>
		</br>
	</div>	
	<div class="row">
		<?php
			
			$this->widget('application.modules.admincms.extensions.ckeditor.CKEditorWidget',
			array(
			  "model"=>$model,                 # Data-Model
			  "attribute"=>'image_html',          # Attribute in the Data-Model
			  "defaultValue"=>$model->image_html,     # Optional
			 
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
		<?php echo $form->error($model,'image_html'); ?>
	</div>	
	<div class="row">
		<?php echo $form->labelEx($model,'advanced_options', array('class'=>'form_controller')); ?>
		<?php echo $form->textField($model,'advanced_options',array('size'=>50,'maxlength'=>150)); ?><a class="help" href="javascript:;" title="Use this field to specify additional elements within the IMG tag, for example: style='margin-left: 2px;'">Help</a> 
		<?php echo $form->error($model,'advanced_options'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Upload' : 'Update'); ?>
	</div>

<?php $this->endWidget(); ?>
</fieldset>
<script type='text/javascript'>
	function loadSubCat() {
		$.ajax({
		  url: '/admincms/GenericImageBank/subcategory/',
		  data: {catid : $('#GenericImageBank_cms_categoryid').val(), subcatid : <?=(!empty($model->parentcatid) ? $model->categoryid : 0)?>, mode: '<?=$this->action->id?>'},
		  beforeSend: function() {
			$('#ajax_subcat').html('<img src="/images/bodycss/icons/refresh.gif" alt="" title="" style="float:left; margin: 0 0 10px 35%;"/>');		
		  },	
		  success: function(data) {
			$('#ajax_subcat').html(data);			
		  }
		});
	}
	$('#GenericImageBank_cms_categoryid').change(function() {
		loadSubCat();
	});
	$(function() {
		loadSubCat();	
	});
</script>
</div><!-- form -->