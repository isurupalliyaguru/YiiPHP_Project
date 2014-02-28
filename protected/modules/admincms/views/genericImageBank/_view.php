<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('imageid')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->imageid), array('view', 'id'=>$data->imageid)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('image_fileref')); ?>:</b>
	<?php echo CHtml::encode($data->image_fileref); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('image_height')); ?>:</b>
	<?php echo CHtml::encode($data->image_height); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('image_width')); ?>:</b>
	<?php echo CHtml::encode($data->image_width); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('image_version')); ?>:</b>
	<?php echo CHtml::encode($data->image_version); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('image_type')); ?>:</b>
	<?php echo CHtml::encode($data->image_type); ?>
	<br />


</div>