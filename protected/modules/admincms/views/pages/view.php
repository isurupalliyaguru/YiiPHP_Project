<?php
$this->breadcrumbs=array(
	'Pages'=>array('index'),
);
//left menu
Yii::import('application.modules.admincms.views.pages.inc_leftmenu',true);
getAdminLeftMenuItems($this,"view");
?>

<h1>View Page Attributes <?php  ?></h1>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'cssFile'=>false,// we are using our own CSS. Yii default styles are disabled and we are including the style in admin/common.css
	'attributes'=>array(
		'pageid',
		'sef_url',
		'menu_heading',
		array(
		'name'=>'html_content',
		'type'=>'raw',
        'value'=> $model->html_content,
		),
		array(
		'name'=>'html_content2',
		'type'=>'raw',
        'value'=> $model->html_content2,
		),
		array(
		'name'=>'html_content3',
		'type'=>'raw',
        'value'=> $model->html_content3,
		),
		'html_h1',
		'html_title',
		'meta_keywords',
		'meta_description',
		array(
		'name'=>'published',
		'type'=>'raw',
        'value'=> ($model->published === "1" ? "Yes" : "No"),
		),
		'parent_pageid',
		'categoryid',
	),
)); ?>
