<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('portfolio_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->portfolio_id), array('view', 'id'=>$data->portfolio_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('orderno')); ?>:</b>
	<?php echo CHtml::encode($data->orderno); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('logo_image_filename')); ?>:</b>
	<?php echo CHtml::encode($data->logo_image_filename); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('url')); ?>:</b>
	<?php echo CHtml::encode($data->url); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('launch_date')); ?>:</b>
	<?php echo CHtml::encode($data->launch_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('short_desc')); ?>:</b>
	<?php echo CHtml::encode($data->short_desc); ?>
	<br />


	<b><?php echo CHtml::encode($data->getAttributeLabel('technology_desc')); ?>:</b>
	<?php echo CHtml::encode($data->technology_desc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('features_desc')); ?>:</b>
	<?php echo CHtml::encode($data->features_desc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('comments')); ?>:</b>
	<?php echo ($data->comments); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('commentator')); ?>:</b>
	<?php echo CHtml::encode($data->commentator); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('published')); ?>:</b>
	<?php echo CHtml::encode($data->published); ?>
	<br />
	

</div>