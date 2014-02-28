<?php
	switch ($page) {
		case 'index':
			$this->widget('zii.widgets.grid.CGridView', array(
			'id'=>'adminuser-grid',
			'dataProvider'=>$model->search(),
			'pager' => array('cssFile' => false),//pagination styles moved to common.css
			'cssFile'=>false,// we are using our own CSS. Yii default styles are disabled and we are including the style in admin/common.css
			'filter'=>$model,
			'columns'=>array(
				'username_email',
				'name',
				'groupname',
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
							'url'=>'$data["userid"]. \'?\' .$data["username_email"]',
							'click'=>'function(){
								confirmDelete(this);
								return false;
							}',
							'options'=>array('class'=>'delete', 'title' => 'Delete')
						),
					),
					'header'=>'Delete',
				),
				
			),
			));
		break;
	}