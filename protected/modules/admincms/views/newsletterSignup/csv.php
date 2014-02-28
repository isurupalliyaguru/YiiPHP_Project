<?php
$this->breadcrumbs=array(
	'Newsletter Signups'=>array('index'),
	'CSV',
);

//left menu items
Yii::import('application.modules.admincms.views.newsletterSignup.inc_leftmenu',true);
getAdminLeftMenuItems($this,"csv","");
?>

<h1>Export to CSV (Newsletter Signups)</h1>

<p><a href="/admincms/newsletterSignup/exportcsv?csv=true;">Click here to download the CSV</a></p>
</p>