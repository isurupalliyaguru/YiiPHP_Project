<?php
Yii::import('application.modules.admincms.extensions.qtip.QTip');
//setting up qtip
Yii::import('application.modules.admincms.extensions.qtip.QTipSetup',true);// by passing the "true" parameter we are forcing the file including before execution of the code. (otherwise this will not function properly)
if($this->action->Id == 'createmenuitem' && Yii::app()->user->hasFlash('actionUpdatemenuitems')) { 
		print "
		<script type='text/javascript'>
			$(function() {
				$('#pagecontent-formmenu').hide('slow');
			});
		</script>
		<a href='javascript:;' onclick=\"$('#status_div').hide();$('#pagecontent-formmenu').show('slow');\">Create new menu item</a><br />
		";
?>

    <div id='status_div' class="success">
        <br /><?php echo Yii::app()->user->getFlash('actionUpdatemenuitems'); ?>
    </div>
<?php } ?>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pagecontent-formmenu',
	'enableAjaxValidation'=>false,
)); ?>
	<br />
	<fieldset>
		<legend><?= ($this->action->Id == 'createmenuitem' ? 'Add new' : 'Edit') . ' - menu items for ' . $menuname ?></legend>
		<p class="note">Fields with <span class="required">*</span> are required.</p>

		<?php echo $form->errorSummary($model); 
		$menu_id = (empty($_GET['menuid'])? $_GET['id'] : $_GET['menuid']);
		echo $form->hiddenField($model, 'menuid', array('value'=>$menu_id)); ?>
		
		<div class="row">
			<?php echo $form->labelEx($model,'is_header', array('class'=>'form_controller')); ?>
			<?php echo $form->checkBox($model,'is_header'); ?><a class="help" href="javascript:;" title="Set this item as a heading - useful for vertical (left / footer) navigation where a column requires a heading. You can also specify a content managed page or URL for the heading below (optional).">Help</a> <br />
			<?php echo $form->error($model,'is_header'); ?>
		</div>		
		
		<fieldset>
		<div class="row">
			<?php echo $form->labelEx($model,'pageid', array('class'=>'form_controller')); ?>
			<?php echo $form->dropDownList($model,'pageid', Pagecontent_cms::parentpageID(), array('prompt'=>'none')); ?><br />
			<?php echo $form->error($model,'pageid'); ?>
		</div>
		OR
		<div class="row">
			<?php echo $form->labelEx($model,'absolute_url', array('class'=>'form_controller')); ?>
			<?php echo $form->textField($model,'absolute_url',array('size'=>50,'maxlength'=>50)); ?><a class="help" href="javascript:;" title="Include the full http:// domain if you are pointing this link outside your site.">Help</a> <br />
			<?php echo $form->error($model,'absolute_url'); ?>
		</div>
		</fieldset>
		<div class="row">
			<?php echo $form->labelEx($model,'menu_heading_override', array('class'=>'form_controller')); ?>
			<?php echo $form->textField($model,'menu_heading_override',array('size'=>50,'maxlength'=>50)); ?><a class="help" href="javascript:;" title="Override for the menu heading set in the 'Manage Pages' module">Help</a> <br />
			<?php echo $form->error($model,'menu_heading_override'); ?>
		</div>
		<div class="row">
			<?php echo $form->labelEx($model,'titletag', array('class'=>'form_controller')); ?>
			<?php echo $form->textField($model,'titletag',array('size'=>50,'maxlength'=>50)); ?><br />
			<?php echo $form->error($model,'titletag'); ?>
		</div>
		<div class="row">
			<?php echo $form->labelEx($model,'orderno', array('class'=>'form_controller')); ?>
			<?php echo $form->textField($model,'orderno',array('size'=>50,'maxlength'=>50)); ?><br />
			<?php echo $form->error($model,'orderno'); ?>
		</div>
		<div class="row">
			<?php echo $form->labelEx($model,'addon_class', array('class'=>'form_controller')); ?>
			<?php echo $form->textField($model,'addon_class',array('size'=>50,'maxlength'=>50)); ?><a class="help" href="javascript:;" title="(For template developers) Add CSS class for this menu item">Help</a><br />
			<?php echo $form->error($model,'addon_class');?>
		</div>
		<div class="row">
			<?php echo $form->labelEx($model,'published', array('class'=>'form_controller')); ?>
			<?php echo $form->checkBox($model,'published'); ?><br />
			<?php echo $form->error($model,'published'); ?>
		</div>
		<div class="row">
			<?php echo $form->labelEx($model,'use_is_blank', array('class'=>'form_controller')); ?>
			<?php echo $form->checkBox($model,'use_is_blank'); ?><br />
			<?php echo $form->error($model,'use_is_blank'); ?>
		</div>
		<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</div>
		</fieldset>
	<?php $this->endWidget(); ?>
</div><!-- form -->
<?php $this->widget('widget.confirmDelete', array('ItmName'=>'menu item', 'confirmText'=>'menu item', 'ajaxAction'=>'Createmenuitem', 'delete_item_id'=>'delete_menu_item_id', 'delete_item_name'=>'delete_menu_item_name')); ?>
<div id="ajax_content">
<?php
$this->renderPartial('_ajaxContent', array(
			'dataProvider'=>$dataProvider,
			'page' => 'menuitem',
		));
?>	
</div>