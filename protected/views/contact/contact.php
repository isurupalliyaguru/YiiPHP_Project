<div class="sub_content">
	<?php
	foreach($row as $key => $value) {
		if($key=="html_h1") $heading = $value;
		if($key=="html_content") $content1= $value;
		if($key=="html_content2") $content2= $value;
	}
	echo "<h1>$heading</h1>"; 
	if(!Yii::app()->user->hasFlash('contact')) { // we are hiding the  normal instructions once the form is submitted successfully. This flash message is giving the thankyou message upon successfull submittion of the form. Please see the ContactController.php
		echo "$content1";
	}
	?>
	<div class="sub_right_content">
		<?php echo "$content2"; ?>
	</div>

<?php 
$this->renderPartial('_form', array(
	'model'=>$model,
	'page'=>'index',
		)); 
?>	
</div>

