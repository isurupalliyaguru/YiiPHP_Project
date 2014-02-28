<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('subscribeid')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->subscribeid), array('view', 'id'=>$data->subscribeid)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_of_subscription')); ?>:</b>
	<?php echo CHtml::encode($data->date_of_subscription); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email_address')); ?>:</b>
	<?php echo CHtml::encode($data->email_address); ?>
	<br />


</div>