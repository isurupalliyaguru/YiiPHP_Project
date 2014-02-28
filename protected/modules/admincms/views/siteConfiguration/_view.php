<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('configid')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->configid), array('view', 'id'=>$data->configid)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jscode_in_head')); ?>:</b>
	<?php echo CHtml::encode($data->jscode_in_head); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jscode_upper_body')); ?>:</b>
	<?php echo CHtml::encode($data->jscode_upper_body); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jscode_lower_body')); ?>:</b>
	<?php echo CHtml::encode($data->jscode_lower_body); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('default_email_address')); ?>:</b>
	<?php echo CHtml::encode($data->default_email_address); ?>
	<br />


</div>