<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'adminuser-form2',
	'enableAjaxValidation'=>false,
)); ?>
<?php
    Yii::app()->clientScript->registerScript('hideShowDiv',"
		function viewDivAfterSubmit() {
		if ($(\"#reset_password\").is(\":checked\")) {
				//show the hidden div
				$(\"#password_section\").show(\"fast\");
			}
			else {	   
				//otherwise, hide it 
				$(\"#password_section\").hide(\"slow\");
			}
		}
		$(document).ready(function(){
			$(\"#reset_password\").click(function(){
			// If checked
			if ($(\"#reset_password\").is(\":checked\")) {
				//show the hidden div
				$(\"#password_section\").show(\"fast\");
			}
			else {	   
				//otherwise, hide it 
				$(\"#password_section\").hide(\"slow\");
			}
			});
		});
		$(document).load(viewDivAfterSubmit());
    ",CClientScript::POS_READY);
?>
<?php if(Yii::app()->user->hasFlash('actionUpdate')):?>
    <div class="success">
        <?php echo Yii::app()->user->getFlash('actionUpdate'); ?>
    </div>
<?php endif; ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model);
	echo (!empty($error)? $error : "");
	
	?>

	<div class="row">
		<?php echo $form->labelEx($model,'username_email', array('class'=>'form_controller')); ?>
		<?php echo $form->textField($model,'username_email',array('size'=>60,'maxlength'=>128)); ?><br />
		<?php echo $form->error($model,'username_email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name', array('class'=>'form_controller')); ?>
		<?php echo $form->textField($model,'name',array('size'=>30,'maxlength'=>30)); ?><br />
		<?php echo $form->error($model,'name'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'adminuser_groupid', array('class'=>'form_controller')); ?>
		<?php echo $form->dropDownList($model,'adminuser_groupid', Adminuser::get_groupname()); ?>
		<?php echo $form->error($model,'adminuser_groupid'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'Reset Password', array('class'=>'form_controller')); ?>
		<?php echo $form->checkbox($model,'reset_password',array('id'=>'reset_password')); ?><br />
		<?php echo $form->error($model,'reset_password'); ?>
	</div>
	<div id ="password_section" style="display:none;">
	<div class="row">
		<?php $model->password="";?>
		<?php echo $form->labelEx($model,'Password', array('class'=>'form_controller'));?>
		<?php echo "<input type=\"password\" id=\"Adminuser_password\" name=\"Adminuser[password]\" value=\"\" maxlength=\"100\" size=\"60\">"; 
		?><br />
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Confirm password', array('class'=>'form_controller')); ?>
		<?php echo $form->passwordField($model,'confirm_password',array('size'=>60,'maxlength'=>100,'value' =>'')); ?><br />
		<?php echo $form->error($model,'confirm_password'); ?>
	</div>
	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->