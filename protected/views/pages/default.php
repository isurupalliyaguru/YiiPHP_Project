<?php
//SUB Menu Genration. uncomment below code for add subnavigations per page.
//$menuHTML = "<ul>#content#</ul>"; // specifying base wrapping HTML elements and nesting tags, content inside ## will be replaced.
//$options_arr = array(); // to specyfy extra classes, use the array index ['ext_classes'] / specify seperator, use array index ['seperator']  
//$menuItemHTML = "<li>#content#</li>"; // specifying nesting tags, content inside ## will be replaced.
//$menuLinkHTML = "<a #class# title='#title#' href='#link#' #target#>#link_content#</a>"; // default anchor tag
//$sub_menus = Yii::app()->Navigation->getSubMenuItems($menuHTML, $menuItemHTML, $menuLinkHTML, $options_arr);
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
<!-- end sub_content -->
</div>
		
		