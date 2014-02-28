<?php
	switch ($page) {
		case 'index':
			$this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'portfolio-grid',
				'dataProvider'=>$model->search(),
				'pager' => array('cssFile' => false),//pagination styles moved to common.css
				'cssFile'=>false,// we are using our own CSS. Yii default styles are disabled and we are including the style in admin/common.css
				'htmlOptions' => array('style'=>'font-size:12px'),
				'filter'=>$model,
				'columns'=>array(
					array(
						'header'=>'Portfolio ID',
						'value'=>'($data->portfolio_id)',
						'name'=>'portfolio_id',
						'headerHtmlOptions'=>array('style'=>'font-size:12px; width: 20px !important;'),
						'htmlOptions' => array('style'=>'font-size:12px'),
					 ),
					array(
						'header'=>'Order no',
						'value'=>'($data->orderno)',
						'name'=>'orderno',
						'headerHtmlOptions'=>array('style'=>'font-size:12px; width: 20px !important;'),
						'htmlOptions' => array('style'=>'font-size:12px'),
					 ),
					array(
						'name'=>'logo_image_filename',
						'header'=>'Logo file name',
						'type'=>'html',
						'value'=>'CHtml::image(\'/images/userfiles/portfolio-logos/\' . $data->logo_image_filename . \'\', \'logo_\' . $data->portfolio_id . \'\')',
						'headerHtmlOptions'=>array('style'=>'font-size:12px; width: 20px !important;'),
						'htmlOptions' => array('style'=>'font-size:12px'),
						),
					array(
						'header'=>'Title',
						'value'=>'($data->title)',
						'name'=>'title',
						'headerHtmlOptions'=>array('style'=>'font-size:12px; width: 20px !important;'),
						'htmlOptions' => array('style'=>'font-size:12px'),
					 ),
					array(
						'header'=>'URL',
						'value'=>'($data->url)',
						'name'=>'url',
						'headerHtmlOptions'=>array('style'=>'font-size:12px; width: 20px !important;'),
						'htmlOptions' => array('style'=>'font-size:12px'),
					 ),
					 array(
						'header'=>'Launch date',
						'value'=>'($data->launch_date)',
						'name'=>'launch_date',
						'headerHtmlOptions'=>array('style'=>'font-size:12px; width: 20px !important;'),
						'htmlOptions' => array('style'=>'font-size:12px'),
					 ),
					array(
						'header'=>'Published',
						'value'=>'($data->published == 1 ? "Yes" : "No")',
						'headerHtmlOptions'=>array('style'=>'font-size:12px; width: 20px !important;'),
						'htmlOptions' => array('style'=>'font-size:12px'),
					 ),
					/*
					'short_desc',
					'technology_desc',
					'features_desc',
					'comments',
					'commentator',
					
					*/
					array(
						'class'=>'CButtonColumn',
						'template'=>'{update}',
						'updateButtonUrl'=>'Yii::app()->createUrl("/admincms/portfolio/update/", array("id"=>$data["portfolio_id"]))',
						'header'=>'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
					),
					array(
						'class'=>'CButtonColumn',
						'template'=>'{items}',
						'buttons'=>array
						(
							'items' => array
							(
								'label'=>'Delete',
								'url'=>'$data["portfolio_id"]. \'?\' .$data["title"]',
								'click'=>'function(){
									confirmDelete(this);
									return false;
								}',
								'imageUrl'=>'/admin/images/bodycss/delete.png',
							),
						),
						//'deleteButtonUrl'=>'Yii::app()->createUrl("/admincms/portfolio/delete/", array("id"=>$data["portfolio_id"]))',
						'updateButtonUrl'=>'Yii::app()->createUrl("/admincms/portfolio/update/", array("id"=>$data["portfolio_id"]))',
						'header'=>'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
					),
				),
			));
		break;
	}