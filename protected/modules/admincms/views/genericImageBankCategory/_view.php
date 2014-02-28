<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('categoryid')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->categoryid), array('view', 'id'=>$data->categoryid)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('category_name')); ?>:</b>
	<?php echo CHtml::encode($data->category_name); ?>
	<br />


</div>