<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('pageid')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->pageid), array('view', 'id'=>$data->pageid)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sef_url')); ?>:</b>
	<?php echo CHtml::encode($data->sef_url); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('menu_heading')); ?>:</b>
	<?php echo CHtml::encode($data->menu_heading); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('html_content')); ?>:</b>
	<?php echo CHtml::encode($data->html_content); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('html_content2')); ?>:</b>
	<?php echo CHtml::encode($data->html_content2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('html_h1')); ?>:</b>
	<?php echo CHtml::encode($data->html_h1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('html_title')); ?>:</b>
	<?php echo CHtml::encode($data->html_title); ?>
	<br />

	<!--
	<b><?php// echo CHtml::encode($data->getAttributeLabel('meta_keywords')); ?>:</b>
	<?php //echo CHtml::encode($data->meta_keywords); ?>
	<br />

	<b><?php //echo CHtml::encode($data->getAttributeLabel('meta_description')); ?>:</b>
	<?php// echo CHtml::encode($data->meta_description); ?>
	<br />

	<b><?php //echo CHtml::encode($data->getAttributeLabel('published')); ?>:</b>
	<?php //echo CHtml::encode($data->published); ?>
	<br />

	<b><?php //echo CHtml::encode($data->getAttributeLabel('parent_pageid')); ?>:</b>
	<?php //echo CHtml::encode($data->parent_pageid); ?>
	<br />
	-->

</div>