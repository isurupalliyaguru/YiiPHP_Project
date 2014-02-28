<?php 
if (Yii::app()->user->hasFlash('contact')){
	echo "<div class='success'>" 
		. Yii::app()->user->getFlash('contact'); 
	$donot_displayform = true;		
	echo "</div>";
}
else { // if the form is successfully submitted we are not showing the form again.
	echo "<fieldset>
		<div class='form'>";		
	$form=$this->beginWidget('CActiveForm', array(
		'id'=>'contact-form',
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
			),
		)); 
	echo "<p class='note'>Fields with <span class='required'>*</span> are required.</p>";
	echo $form->errorSummary($model,"<span>Please fix the following input errors and resubmit your form:</span>"); 
	$form_data = $model->contactUsFormData(); 
	foreach($form_data as $key=>$value) { // looping throug all array to get all fields of the form (see the model)
		switch($value['fieldtype']) {
			case 'textField':
				echo"<p>";
				echo $form->labelEx($model,$value['fieldname']);
				echo $form->textField($model,$value['fieldname'],array('placeholder'=>$value['placeholder'],'class'=>$value['cssClass']));
				echo"</p>";
				break;
			case 'textArea':
				echo"<p>";
				echo $form->labelEx($model,$value['fieldname']);
				echo $form->textArea($model,$value['fieldname'],array('rows'=>$value['rows'], 'cols'=>$value['cols'],'placeholder'=>$value['placeholder'],'class'=>$value['cssClass']));
				echo"</p>";
				break;
			case 'dropDownList':
				echo"<p>";
				echo $form->labelEx($model,$value['fieldname']); 
				echo $form->dropDownList($model,$value['fieldname'],$value['data'],array('class'=>$value['cssClass']));
				echo"</p>";
				break;
			case 'spamFilter':
				echo"<div style='visibility:hidden; height:1px;overflow:hidden;'>";
				echo $form->textField($model,$value['fieldname'],$value['data'],array('class'=>$value['cssClass']));
				echo"</div>";
				break;
		}
	}
	echo "<p>" . CHtml::submitButton('Submit',array('class'=>'submit_button')) . "</p>";
	$this->endWidget();
	echo "</div><!-- form -->
	</fieldset>";
} //endif (empty($donot_displayform))
?>