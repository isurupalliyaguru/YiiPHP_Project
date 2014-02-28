<?php
$this->breadcrumbs=array(
	'Portfolio'=>array('index'),
	$model->title=>array('view','id'=>$model->portfolio_id),
	'Update',
);

$this->menu=array(
	array('label'=>'Manage Portfolio', 'url'=>array('index'),'active'=>($this->action->Id == 'index' ? true: false)),
	array('label'=>'Create Portfolio', 'url'=>array('create'),'active'=>($this->action->Id == 'create' ? true: false)),
);
?>

<h1>Update Portfolio <?php echo $model->portfolio_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>