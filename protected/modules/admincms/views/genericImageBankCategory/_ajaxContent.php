<?php
	switch ($page) {
		case 'MIC':
			$this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'generic-image-bank-category-grid',
				'dataProvider'=>$model->search(),
				'filter'=>$model,
				'pager' => array('cssFile' => false),//pagination styles moved to common.css
				'cssFile'=>false,// we are using our own CSS. Yii default styles are disabled and we are including the style in admin/common.css
				'columns'=>array(
					'categoryid',
					'category_name',
					'parentcatid',
					array(
						'class'=>'CButtonColumn',
						'template'=>'{update}',
						'updateButtonImageUrl'=>false,
						'updateButtonLabel' => false,		
						'buttons'=>array
								(
									'update' => array
									(
										'options'=> array('target'=>'_blank', 'class'=>'update', 'title' => 'Update'),
									),
								),						
					),
					array(
						'class'=>'CButtonColumn',
						'template'=>'{delete}',
						'deleteButtonImageUrl'=>false,
						'deleteButtonLabel' => false,										
						'buttons'=>array
						(
							'delete' => array
							(
								'url'=>'$data["categoryid"]. \'?\' .$data["category_name"]',
								'click'=>'function(){
									confirmDelete(this);
									return false;
								}',
								'options'=> array('target'=>'_blank', 'class'=>'delete', 'title' => 'Delete'),
							),
						),
					),
				),
			)); 
		break;
	}