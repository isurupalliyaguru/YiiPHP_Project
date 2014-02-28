<?php 
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'newsletter-signup-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'pager' => array('cssFile' => false),//pagination styles moved to common.css
	'cssFile'=>false,// we are using our own CSS. Yii default styles are disabled and we are including the style in admin/common.css
	'columns'=>array(
		'subscribeid',
		'date_of_subscription',
		'email_address',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update}',
		),
		array(
			'class'=>'CButtonColumn',
			'template'=>'{items}',
			'buttons'=>array
			(
				'items' => array
				(
					'label'=>'Delete',
					'url'=>'$data["subscribeid"]. \'?\' .$data["email_address"]',
					'click'=>'function(){
									confirmDelete(this);
									return false;
								}',
					'imageUrl'=>'/admin/images/bodycss/delete.png',
				),
			),
		),
))); 
?>
