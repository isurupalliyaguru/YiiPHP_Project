<?php
$this->breadcrumbs=array(
	'Portfolio',
);

$this->menu=array(
	array('label'=>'Manage Portfolio', 'url'=>array('index'),'active'=>($this->action->Id == 'index' ? true: false)),
	array('label'=>'Create Portfolio', 'url'=>array('create'),'active'=>($this->action->Id == 'create' ? true: false)),
);
?>

<h1>Portfolios</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
