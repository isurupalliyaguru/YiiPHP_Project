<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="DESCRIPTION" content="<?= $this->meta_description ?>" />
	<meta name="KEYWORDS" content="<?= $this->meta_keywords ?>" />
	<meta name="RATING" content="General" />
	<meta name="REVISIT-AFTER" content="30 days" />
	<meta name="author" content="apartments lanka" />
	<?=$this->getCanonicalTag()?>
	<link type="image/x-icon" rel="shortcut icon" href="/images/bodycss/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="/css/common.css" />
	<!--[if lt IE 9]>  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>  <![endif]--> 
	<!--[if lt IE 9]> <link rel="stylesheet" type="text/css" href="/css/override/ie8.css" /><![endif]-->
    <!--[if IE 7]> <link rel="stylesheet" type="text/css" href="/css/override/ie7.css" /><![endif]-->
	<?php echo Yii::app()->SiteConfig->getJscodeInHead(); ?>
	<title><?php echo $this->html_title; ?></title>
</head>

<body <?=(!empty($this->addon_css_class) ? "class='". $this->addon_css_class ."'" : "" ) ?>>
<?php echo Yii::app()->SiteConfig->getJscodeUpperBody(); ?>
	<div class="wrapper">
        <div class="spacer"> </div>

        <div id="header_wrap">
            <div id="logo">presents:</div>
            <div id="top">
                <div class="topheading">Purely Personal</div>
                <h2>recommendations of places to stay in Sri Lanka</h2>				
            </div>
            <nav id="topnav">
               <?php
			   // getting the needed generating menu items (header menus)
				$menuArr = array('t1', 'l1'); // specifying required special menu IDs
				$menuHTML = "#content#"; // specifying base wrapping HTML elements and nesting tags, content inside ## will be replaced.
				$options_arr = array(); // to specyfy extra classes, use the array index ['ext_classes'] / specify seperator, use array index ['seperator']  
				$menuItemHTML = "#content#"; // specifying nesting tags, content inside ## will be replaced.
				$menuLinkHTML = "<a #class# title='#title#' href='#link#' #target#>#link_content#</a>";
				$menu_set = Yii::app()->Navigation->getSpecifiedMenus ($menuArr, $menuHTML, $menuItemHTML, $menuLinkHTML, $options_arr);
				echo $menu_set['t1'];
			   ?>
            </nav>			
        <!-- end #header_wrap -->
        </div>
		<div id="content">
			<div id="left_nav_parent"><!-- start #left_nav -->
				<nav id="left_nav">
					<?php
					echo $menu_set['l1'];
					?>
				</nav><!-- end #left_nav-->
			</div><!-- end #left_nav_parent -->
			<div id="main_content"> 
				<?php echo $content; ?>
				<div class="addthis_button">
					<!-- AddThis Button BEGIN -->
					<div class="addthis_toolbox addthis_default_style ">
					<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
					<a class="addthis_button_tweet"></a>
					<a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
					<a class="addthis_counter addthis_pill_style"></a>
					</div>
					<script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4ef43c345d593118&async=1"></script>
					<!-- AddThis Button END -->
				</div>
				<?php
					Yii::app()->clientScript->registerCoreScript('jquery');
					Yii::app()->clientScript->registerScript("addthis_load",
					"
					var addthis_config =
					{
					  ui_click: true
					}
					var addthis_share =
					{
					   width:100
					}
					$(document).ready(function(){	
						addthis.init();
					});"
					,CClientScript::POS_END);
				?>
				<div class="spacer_1px"></div>
				<footer class="footer"><!--start .footer-->					
					<?php
					//getting the needed generating menu items (footer menus)
					$menuArr = array('f1', 'f3', 'f5'); // specifying required special menu IDs
					$menuHTML = "#content#"; // specifying base wrapping HTML elements and nesting tags, content inside ## will be replaced.
					$options_arr = array(); // to specyfy extra classes, use the array index ['ext_classes'] / specify seperator, use array index ['seperator']  
					$menuItemHTML = "#content#"; // specifying nesting tags, content inside ## will be replaced.
					$menuLinkHTML = "<a #class# title='#title#' href='#link#' #target#>#link_content#</a>";
					$menu_set = Yii::app()->Navigation->getSpecifiedMenus ($menuArr, $menuHTML, $menuItemHTML, $menuLinkHTML, $options_arr);
					?>
					<div class='footer_column'>
						<?php
						echo $menu_set['f1'];
						?>
					</div>
					<div class='footer_column'>
						<?php
						echo $menu_set['f3'];
						?>
					</div>
					<!--<div class='footer_column'>
						<?php
						//echo $menu_set['f4'];
						?>
					</div>-->
					<div class='footer_column'>
						<?php
						echo $menu_set['f5'];
						?>
					</div>
					<div class="spacer"> </div>
					<p> Copyright ©
						<?php $currentyear = date("Y");
							$startyear = "2011";
							if ($currentyear > $startyear)	$yeartext = $startyear . "-" . $currentyear;
							else $yeartext =  $startyear;
							echo '&nbsp;'.$yeartext.'&nbsp;';
						?>
						- apartmentslanka.com &nbsp;&nbsp; <span class="subfooter">A project by <a href="http://www.3003online.com">3003 Online</a>.</span>
					</p>
				</footer><!--end .footer-->
			</div><!-- end main_content -->
		</div><!-- end #content -->
	</div><!-- end #wrapper -->
    <div class="footer_spacer"></div>
	<?php echo Yii::app()->SiteConfig->getJscodeLowerBody(); ?>
</body>
</html>