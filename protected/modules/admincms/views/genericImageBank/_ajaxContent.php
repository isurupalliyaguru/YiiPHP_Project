<?php
	switch ($page) {
		case 'MGIB':
			$this->widget('widget.confirmDelete', array('ItmName'=>'image', 'confirmText'=>'image', 'ajaxAction'=>'admin', 'delete_item_id'=>'delete_image_id', 'delete_item_name'=>'delete_image_name'));
			$this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'generic-image-bank-grid',
				'dataProvider'=>$model->search(),
				'pager' => array('cssFile' => false),//pagination styles moved to common.css
				'cssFile'=>false,// we are using our own CSS. Yii default styles are disabled and we are including the style in admin/common.css
				'filter'=>$model,
				'columns'=>array(
					'image_fileref',
					array(
						'name'=>'image_thumbnail',
						'header'=>'Image',
						'type'=>'html',
						'value'=>'CHtml::image(\'/images/generic_image_bank/\' . (!empty($data->parentcatid) ?  $data->parentcatid . \'/\' . $data->categoryid : $data->categoryid) . \'/thumbs/\' . (!empty($data->thumb_image_fileref) ?  $data->thumb_image_fileref : $data->image_fileref) . \'\', \'\' . (!empty($data->thumb_image_fileref) ?  $data->thumb_image_fileref : $data->image_fileref) . \'\')',
						'headerHtmlOptions'=>array('style'=>'font-size:12px; width: 20px !important;'),
						'htmlOptions' => array('style'=>'font-size:12px'),
						'filter' => false
					),
					'category_name',
					'order_no',
					array(
						'name'=>'image_alt',
						'htmlOptions' => array('style'=>'width:100px;'),
						'filter' => false						
					),
					array(
						'name'=>'image_title',
						'htmlOptions' => array('style'=>'width:100px;'),
						'filter' => false						
					),
					array(
						'name'=>'url',
						'htmlOptions' => array('style'=>'width:100px;'),
						'filter' => false						
					),
					/*array(
						'name'=>'advanced_options',
						'htmlOptions' => array('style'=>'width:100px;'),
					),*/
					array(
						'class'=>'CButtonColumn',
						'template'=>'{view}',
						'viewButtonImageUrl'=>false,
						'viewButtonLabel' => false,							
						'buttons'=>array
								(
									'view' => array
									(
										'url'=>'\'/images/generic_image_bank/\' . (!empty($data->parentcatid) ?  $data->parentcatid . \'/\' . $data->categoryid : $data->categoryid) . \'/\' . $data->image_fileref . \'\'',
										'options'=> array('target'=>'_blank', 'class'=>'view', 'title' => 'View'),
									),
								),
						'header'=>'View',
					),
					array(
						'class'=>'CButtonColumn',
						'template'=>'{update}',
						'updateButtonImageUrl'=>false,
						'updateButtonLabel' => false,								
						'header'=>'Update',
						'buttons'=>array
								(
									'update' => array
									(
										'options'=> array('target'=>'_self', 'class'=>'update', 'title' => 'Update'),
									),
								),						
					),
					/*array(
						'class'=>'CButtonColumn',
						'template'=>'{delete}',
						'header'=>'Delete'
					),*/
					array(
						'class'=>'CButtonColumn',
						'template'=>'{delete}',
						'deleteButtonImageUrl'=>false,
						'deleteButtonLabel' => false,								
						'buttons'=>array
						(
							'delete' => array
							(
								'url'=>'$data["imageid"]. \'?\' .$data["image_fileref"]',
								'options' => array('title' => 'Delete'),
							),
						),
						'header'=>'Delete',
					),
					array(
						'class'=>'CButtonColumn',
						'template'=>'{thumb}',
						'buttons'=>array
						(
							'thumb' => array
							(
								'label'=>'',
								'url'=>'\'/admincms/genericImageBank/change_thumbnail/?imgid=\' .$data["imageid"]',
								'options'=>array('class'=>'thumb', 'title' => 'Update Thumbnail')
							),
						),
						'header'=>'Change Thumbnail',
					),						
				),
			)); 
		break;
	}