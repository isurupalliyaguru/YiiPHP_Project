<?php
$this->breadcrumbs=array(
	'Generic Image Bank'=>array('create'),
	'Manage',
);

//left menu items
Yii::import('application.modules.admincms.views.genericImageBank.inc_leftmenu',true);
getAdminLeftMenuItems($this,"admin");

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('generic-image-bank-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Images</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p> 

<div class="form">
<fieldset>
	<legend>Display Images For</legend>
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'generic-image-bank-form',
		'enableAjaxValidation'=>false,
		'htmlOptions' => array('enctype' => 'multipart/form-data'),
	)); ?>		
	<div class="row">
		<?php echo $form->labelEx($model,'categoryid',array('class'=>'form_controller')); ?>
		<?php 
		$selID = (!empty($pcat) ? $pcat : '');
		echo $form->dropDownList($model,'categoryid',$model->getImageCategory(), array('options' => array($selID=>array('selected'=>true)), 'prompt'=>'Select Category')); ?>
		<?php echo $form->error($model,'categoryid'); ?>
	</div>
	<div id='ajax_subcat'></div>
	<div class="row buttons">
		<label class="form_controller">&nbsp;</label>
		<?php echo CHtml::submitButton('Search'); ?>
	</div>
	<?php $this->endWidget(); ?>
</fieldset>
</div>
<div id="ajax_content">
<?php 
$this->renderPartial('_ajaxContent', array(
	'model'=>$model,
	'page'=>'MGIB',
			)); 
	?>
</div>
<script type='text/javascript'>
	function loadSubCat() {
		$.ajax({
		  url: '/admincms/GenericImageBank/subcategory/',
		  data: {catid : ($('#GenericImageBank_cms_categoryid').val() ? $('#GenericImageBank_cms_categoryid').val() : 0), subcatid : <?=(!empty($subcat) ? $subcat : 0)?>},
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
	$('#generic-image-bank-form').submit(function(){
		$.ajax({
		  url: '/admincms/GenericImageBank/admin/',
		  data: $(this).serialize(),
		  beforeSend: function() {
			$('#ajax_content').html('<img src="/images/bodycss/icons/loading.gif" alt="" title="" style="float:left;"/><p style="width:90px; margin-top:27px; float:left;">Please wait....</p>');		
		  },
		  success: function(data) {
			$('#ajax_content').html(data);			
		  }
		});
		return false;
	})	
</script>
