<?php
$this->html_title=Yii::app()->name . ' - Error ' . $code;
$this->breadcrumbs=array(
	'Error',
);
?>
<div class="sub_content">
	<h1>Oops! That page does not exist. (<?php echo $code; ?>)</h1>

	<div class="error_http">
		Please use the links around this page, or you can <a href='/'>start from our home page</a>.<br/><br/>
		If you continue to see this message please <a href='/contact/'>contact us</a>. Thank you!<br/><br/>
		
		The team @ 3003 Online
		<?php //echo CHtml::encode($message); ?>
	</div>
</div>