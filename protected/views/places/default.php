<?php
$sub_menus = Yii::app()->Navigation->getSubMenuItems();
?>
<?php
	Yii::app()->clientScript->registerCssFile(Yii::app()->request->getBaseUrl(true)."/css/jquery.fancybox-1.3.4.css");
	Yii::app()->clientScript->registerScriptFile(Yii::app()->request->getBaseUrl(true)."/js/jquery.mousewheel-3.0.4.pack.js",CClientScript::POS_HEAD);
	Yii::app()->clientScript->registerScriptFile(Yii::app()->request->getBaseUrl(true)."/js/jquery.fancybox-1.3.4.pack.js",CClientScript::POS_HEAD);
	Yii::app()->clientScript->registerScript("hide_show_map",
	"$('#map_show').click(function () {
	$('#map_canvas').toggle('slow');
	});"
    ,CClientScript::POS_END);
	Yii::app()->clientScript->registerScript("scroll",
	"$(document).ready(function($) {
		$('.scroll').click(function(event){		
			event.preventDefault();
			$('html,body').animate({scrollTop:$(this.hash).offset().top}, 500);
			});
	});"
    ,CClientScript::POS_END);
	Yii::app()->clientScript->registerScript("hide_show_review",
	"$('#review_show').click(function () {
		$('.review_more').toggle();
		$('.review').show();
	});
	$('#review_hide').click(function () {
		$('.review').toggle();
		$('.review_more').toggle();
	});"
    ,CClientScript::POS_END);
	Yii::app()->clientScript->registerScript("inquiry",
	"$('#Inquries').fancybox({
		'autoDimensions': true,
		'scrolling'		: 'no',
		'width'			: 500,
		'titleShow'		: false,
		'onClosed'		: function() {
			$('.errorSummary').empty();
			$('.errorSummary').hide();
		},
	});"
    ,CClientScript::POS_END);
	Yii::app()->clientScript->registerScript("inquiry2",
	"$('#Inquries2').fancybox({
		'autoDimensions': true,
		'scrolling'		: 'no',		
		'width'			: 500,
		'titleShow'		: false,
		'onClosed'		: function() {
			$('.errorSummary').empty();
			$('.errorSummary').hide();
		}
	});"
    ,CClientScript::POS_END);
	Yii::app()->clientScript->registerScript("tripadvisor_review",
	"$('#tripadvisor_review').fancybox({
		'autoDimensions': true,
		'scrolling'		: 'no',
		'titleShow'		: false,
		'onClosed'		: function() {
			//$('#inquiry_error').empty();
		}
	});"
    ,CClientScript::POS_END);
	Yii::app()->clientScript->registerScript("g_maps",
	"$('.various').fancybox({
		'transitionIn'	: 'none',
		'transitionOut'	: 'none'
	});"
    ,CClientScript::POS_END);
	Yii::app()->clientScript->registerScript("video",
	"$('.video').fancybox({
		'transitionIn'	: 'none',
		'transitionOut'	: 'none'
	});"
    ,CClientScript::POS_END);
?>
	
<div class="sub_content">
	<?php
	foreach($row as $key => $value) {
		if($key=="html_h1") $heading = $value;
		if($key=="html_content") $content1= $value;
		if($key=="html_content2") $content2= $value;
	}
	echo "<h1>$heading</h1>"; 
	echo "$content1";
	echo "$content2";
	?>
	<div class='main_content_spacer'> </div>
	<?php $this->widget('widget.inquiryForm'); ?>
<!-- end sub_content -->
</div>