<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<meta name="robots" content="noindex, nofollow">
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="/css/ie.css" media="screen, projection" />
	<![endif]-->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl;?>/admin/css/common.css" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body>
<div id="wrap">

	<div id="header">	
			<div class="logoblock"><img src="/admin/images/bodycss/logo.png" alt="3003-online logo" />
			<a href="http://www.3003online.com" class="home" target="_blank"><?php echo Yii::app()->request->baseUrl; ?></a></div>
			<div class="logged"><?php echo( Yii::app()->user->isGuest ?  "You are not logged in" : "Logged in as " . Yii::app()->user->user_name . "<br/>" . CHtml::link('Logout',array(Yii::app()->createUrl('admincms/default/logout')))); ?></div><!-- end .logged -->
	</div>
	<?php 
	if(!Yii::app()->user->isGuest) { // we are not displaying the main navigaton for the Guest?> 
	<div id="top_nav">
		<div class="icon"><a id="pages" href="<?php echo Yii::app()->request->baseUrl;?>/admincms/pages/index" class="<?php echo($this->id=='pages'?'sel':'')?>"><!--<img src="/admin/images/icons/pages_icon.png" alt="" />--><span>Pages</span></a></div>
		<div class="icon">
		<a id="users" href="<?php echo(empty(Yii::app()->user->content_man_un) ? Yii::app()->createUrl('admincms/adminuser/index') : Yii::app()->createUrl('admincms/adminuser/changepassword/' . Yii::app()->user->userid))?>" class="<?php echo($this->id=='adminuser'?'sel':'')?>"><!--<img src="/admin/images/icons/users_icon.png" alt="" />--><span>Users</span></a>
		</div>
		<div class="icon"><a id="images" href="<?php echo Yii::app()->request->baseUrl;?>/admincms/GenericImageBank/create" class="<?php echo($this->id=='genericImageBank' || $this->id=='genericImageBankCategory'?'sel':'')?>"><!--<img src="/admin/images/icons/images_icon.png" alt="" />--><span>Images</span></a></div>
		<div class="icon"><a id="config" href="<?php echo Yii::app()->request->baseUrl;?>/admincms/SiteConfiguration/update/1" class="<?php echo($this->id=='siteConfiguration'?'sel':'')?>"><!--<img src="/admin/images/icons/config_icon.png" alt="" />--><span>Configuration</span></a></div>
		<div class="icon"><a id="news_letter" href="<?php echo Yii::app()->request->baseUrl;?>/admincms/newsletterSignup/create" class="<?php echo($this->id=='newsletterSignup'?'sel':'')?>"><!--<img src="/admin/images/icons/news_icon.png" alt="" />--><span>News Letters</span></a></div>
	</div><!-- end #top-nav -->
	<div class='spacer_1px'></div>
	<?php } ?>
	<?php
		$this->widget('application.modules.admincms.customextentions.Breadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); 
	?><!-- breadcrumbs -->
	<?php
		$this->beginWidget('application.modules.admincms.customextentions.UserMenu', 
		array(
			'items'=>$this->menu,
			'htmlOptions'=>array('class'=>'operations'),
			'activeCssClass'=>'selected',
		));
		
		$this->endWidget();
	?>
			
	
	<div id="main_content">
	<?php echo $content; ?>
	</div>
	<div class='spacer_1px'></div>
	<div id="footer">
		Copyright &copy; 3003 Online. All Rights Reserved.
	</div><!-- end #footer -->
	
</div><!-- page -->

</body>
</html>