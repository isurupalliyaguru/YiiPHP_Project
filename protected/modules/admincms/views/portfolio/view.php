<?php
$this->breadcrumbs=array(
	'Portfolio'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'Manage Portfolio', 'url'=>array('index'),'active'=>($this->action->Id == 'index' ? true: false)),
	array('label'=>'Create Portfolio', 'url'=>array('create'),'active'=>($this->action->Id == 'create' ? true: false)),
);
?>

<h1>View Portfolio #<?php echo $model->portfolio_id; ?></h1>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'cssFile'=>false,// we are using our own CSS. Yii default styles are disabled and we are including the style in admin/common.css
	'attributes'=>array(
		'portfolio_id',
		'orderno',
		'logo_image_filename',
		'title',
		'url',
		'launch_date',
		'short_desc',
		'technology_desc',
		'features_desc',
		array(
		'name'=>'comments',
		'type'=>'raw',
        'value'=> $data->comments,
		),
		'commentator',
		array(
		'name'=>'Published',
		'value'=> ($model->published == "1" ? "Yes" : "No") ,
		 ),
	),
)); ?>
