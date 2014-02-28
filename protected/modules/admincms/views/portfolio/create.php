<?php
$this->breadcrumbs=array(
	'Portfolio'=>array('index'),
	'Create',
);
$this->menu=array(
	array('label'=>'Manage Portfolio', 'url'=>array('index'),'active'=>($this->action->Id == 'index' ? true: false)),
	array('label'=>'Create Portfolio', 'url'=>array('create'),'active'=>($this->action->Id == 'create' ? true: false)),
);
?>

<h1>Create Portfolio</h1>

<?php echo(Yii::app()->request->baseUrl); ?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>