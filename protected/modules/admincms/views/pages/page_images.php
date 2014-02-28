<?php
$this->breadcrumbs=array(
	'Pages',
);
//left menu
Yii::import('application.modules.admincms.views.pages.inc_leftmenu',true);
getAdminLeftMenuItems($this,"page_images");

Yii::app()->clientScript->registerCoreScript("jquery");
Yii::app()->clientScript->registerScript("category_image_view",
	"function loadCategoryImages() {
	$.ajax({
		type	: 'POST',
		cache	: false,
		url		: '" . Yii::app()->createUrl("/admincms/pages/assignimages/") . "',
		data	: 'categoryid='+$(\"#categoryid\").val()+'&pageid=" . $id . "',
		beforeSend: function() {
			$('#categoryimages').html('Loading............');
		},			
		success: function(data) {	
			$(\"#categoryimages\").html(data);
		}
	});
}
function getAssignedImages() {
	$.ajax({
		type	: 'POST',
		cache	: false,
		url		: '" . Yii::app()->createUrl("/admincms/pages/assignimages/") . "',
		data	: 'getassinged_images=1&pageid='+" . $id . ",
		beforeSend: function() {
			$('#assignedimages').html('Loading............');
		},			
		success: function(data) {	
			$(\"#assignedimages\").html(data);
		}
	});
}
function getAssignedCategory() {
	$.ajax({
		type	: 'POST',
		cache	: false,
		url		: '" . Yii::app()->createUrl("/admincms/pages/assignedimagecategories/") . "',
		data	: 'getassinged_categories=1&pageid='+" . $id . ",
		beforeSend: function() {
			$('#assignedcategoryimages').html('Loading............');
		},			
		success: function(data) {	
			$(\"#assignedcategoryimages\").html(data);
		}
	});
}
function doAction(obj) {
	var ajax_url = $(obj).attr('href');
	$.ajax({
		type	: 'GET',
		cache	: false,
		url		: ajax_url,
		beforeSend: function() {
			$('#assignedimages').html('Loading............');
		},	
		success: function(data) {	
			$(\"#assignedimages\").html(data);
		}
	});
}
function assignOrder(obj) {
	var imgID = $(obj).attr('href');
	var orderno = $('#ordernoimage'+imgID).val();
	var pageid = $('#ajaxPageid').val();
	if (orderno.length > 0) {
		$.ajax({
			type	: 'GET',
			cache	: false,
			url		: '" . Yii::app()->createUrl("/admincms/pages/assignimages/") . "',
			data	: 'assignOrderNo=1&pageid=' + pageid + '&imageid=' + imgID +'&orderno=' + orderno,
			beforeSend: function() {
				$('#assignedimages').html('Loading............');
			},	
			success: function(data) {	
				$(\"#assignedimages\").html(data);
			}
		});
	}
	else
		alert('Please enter order no');
}


$(function() {
 loadCategoryImages();
 getAssignedImages();
 getAssignedCategory()
});
",CClientScript::POS_END);	

?>
<h1>Assign Images for Page ID <?=$id?></h1>
<? 
print("
<form method='post' action='/admincms/pages/assignimagecategories/' onsubmit='if(!confirm(\"Are you sure you want to assing the category\")){return false;}'>
<select id='categoryid' name='categoryid' onchange='loadCategoryImages()'>");
foreach($category_arr as $row) {
	print("<option value='" . $row['categoryid'] . "'>" . $row['category_name'] ."</option>");
}
print("<input type='hidden' value='" . $id . "' name='pageid' />
<input type='submit' value='Assign category' style='margin-left:10px;' />
</select>
</form>");
?>
<div id="categoryimages" style="margin-top:10px;"></div>
<h6 style="padding:15px 0 0 0;">Assigned images</h6>
<form id="orderNoForm">
<input id="ajaxPageid" type="hidden" value="<?=$id?>"/>
<div width="300" id="assignedimages"></div>
<br/>
<h6 style="padding:15px 0 0 0;">Assigned Category</h6>
<div width="300" id="assignedcategoryimages"></div>
</form>