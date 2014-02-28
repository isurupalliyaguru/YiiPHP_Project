<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('username_email')); ?>:</b>
	<?php echo CHtml::encode($data->username_email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />
	
	<b><?php echo CHtml::label('Group name', 'groupname'); ?>:</b>
	<?php echo CHtml::encode($data->get_groupname($data->groupname)); ?>
	<br />


</div>