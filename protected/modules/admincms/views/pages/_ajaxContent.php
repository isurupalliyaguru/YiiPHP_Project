<?php
	switch ($page) {
		case 'index':
			echo "<h6>Published Pages</h6>";
			$this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'pagecontent-grid-index1',
				'pager' => array('cssFile' => false),//pagination styles moved to common.css
				'cssFile'=>false,// we are using our own CSS. Yii default styles are disabled and we are including the style in admin/common.css
				'dataProvider'=>$dataProvider_published,
				'columns'=>array(
					array(
					'name'=>'pageid',
					'header'=>'Page ID',
					),
					array(
					'name'=>'parent_pageid',
					'header'=>'Parent page ID',
					),					
					array(
							'class'=>'CButtonColumn',
							'template'=>'{update}{images}',
							'updateButtonImageUrl'=>false,
							'updateButtonLabel' => false,
							'buttons'=>array
								(
									'images' => array
									(
										'label'=>'images',
										'url'=>'Yii::app()->createUrl("/admincms/pages/assignimages/", array("id"=>$data["pageid"]))',
										'options'=>array('class'=>'link', 'title'=>'Update')
									),	
									'update' => array
									(
										'options'=>array('class'=>'update', 'title'=>'Update')
									),										
								),							
							'updateButtonUrl'=>'Yii::app()->createUrl("/admincms/pages/update/", array("id"=>$data["pageid"]))',
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
										'url'=>'$data["pageid"]. \'?\' .$data["sef_url"]',
										'click'=>'function(){
											confirmDelete(this);
											return false;
										}',
										'options'=>array('class'=>'delete', 'title'=>'Delete')
									),								
								),
					),					
					array(
					'name'=>'sef_url',
					'header'=>'SEF URL',
					),
					array(
					'name'=>'menu_heading',
					'header'=>'Menu heading',
					),
					array(
					'name'=>'date_created',
					'header'=>'Created date',
					),
					array(
					'name'=>'date_last_modified',
					'header'=>'Last modified date',
					),					
				),
				//'selectionChanged'=>'userClicks',

			));

			if($check_unpublised_pages) {
				echo "
				<h6>Unpublished Pages</h6>";
					$this->widget('zii.widgets.grid.CGridView', array(
						'id'=>'pagecontent-grid-index2',
						'dataProvider'=>$dataProvider_unpublised,
						'pager' => array('cssFile' => false),//pagination styles moved to common.css
						'cssFile'=>false,// we are using our own CSS. Yii default styles are disabled and we are including the style in admin/common.css
						'showTableOnEmpty'=>false,
						'columns'=>array(
							array(
							'name'=>'pageid',
							'header'=>'Page id',
							),
							array(
								'class'=>'CButtonColumn',
								'template'=>'{update}',
								'updateButtonImageUrl'=>false,
								'updateButtonLabel' => false,								
								'updateButtonUrl'=>'Yii::app()->createUrl("/admincms/pages/update/", array("id"=>$data["pageid"]))',
								'buttons'=>array
								(
									'update' => array
									(
										'options'=>array('class'=>'update', 'title'=>'Update')
									),
								)
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
										'url'=>'$data["pageid"]. \'?\' .$data["sef_url"]',
										'click'=>'function(){
											confirmDelete(this);
											return false;
										}',
										'options'=>array('class'=>'delete', 'title'=>'Delete')
									),
								)
							                  
							),
							array(
							'name'=>'sef_url',
							'header'=>'SEF URL',
							),							
							array(
							'name'=>'menu_heading',
							'header'=>'Menu heading',
							),
							array(
							'name'=>'parent_pageid',
							'header'=>'Parent page ID',
							),
							array(
							'name'=>'date_created',
							'header'=>'Created date',
							),
							array(
							'name'=>'date_last_modified',
							'header'=>'Last modified date',							
							),
						),
					));
			}
			break;
		case 'menu':
			if(!empty($delete_menuitem)) 
				echo $delete_menuitem;
			else {
				echo "
				<h6>Main Navigation Menus</h6>";
					$this->widget('zii.widgets.grid.CGridView', array(
						'id'=>'pagecontent-grid-index2',
						'pager' => array('cssFile' => false),//pagination styles moved to common.css
						'cssFile'=>false,// we are using our own CSS. Yii default styles are disabled and we are including the style in admin/common.css
						'dataProvider'=>$dataProvider_menu_main,
						'showTableOnEmpty'=>false,
						'columns'=>array(
							array(
								'name'=>'menuid',
								'header'=>'Menu ID',
								'htmlOptions'=>array('width'=>'10px'),
							),		
							array(
								'name'=>'menuname',
								'header'=>'Menu Name',
								'htmlOptions'=>array('width'=>'50px'),
							),
							array(
								'name'=>'published',
								'header'=>'Published',
								'htmlOptions'=>array('width'=>'60px'),
							),
							array(
								'name'=>'special_id_text',
								'header'=>'	Special template reference',
								'htmlOptions'=>array('width'=>'50px'),
							),	
							array(
								'class'=>'CButtonColumn',
								'template'=>'{update}',
								'updateButtonImageUrl'=>false,
								'updateButtonLabel' => false,									
								'updateButtonUrl'=>'Yii::app()->createUrl("/admincms/pages/updatemenu/", array("id"=>$data["menuid"]))', 
								'header'=>'Update',
								'buttons'=>array
								(
									'update' => array
									(
										'options'=>array('class'=>'update', 'title'=>'Update')
									),
								)								
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
											'url'=>'$data["menuid"]. \'?\' .$data["menuname"]',
											'click'=>'function(){
												confirmDelete(this);
												return false;
											}',
											'options'=>array('style'=>'margin-left: 3px', 'title'=>'Delete', 'class'=>'delete'),
										),
									), 
								'header'=>'Delete',
							),
							array(
								'class'=>'CButtonColumn',
								'template'=>'{menu_items}',
								'buttons'=>array
									(
										'menu_items' => array
										(
											'label'=>'Menu Items',
											'url'=>'Yii::app()->createUrl("/admincms/pages/createmenuitem/", array("id"=>$data["menuid"]))',
											'options'=>array('style'=>'margin-left: 3px', 'class' => 'link'),
										),
									), 
								'header'=>'Menu items',
							),			
						),
					));
				if ($check_menu_subnav) {
					echo "<h6>Sub Navigation Menus</h6>";
					$this->widget('zii.widgets.grid.CGridView', array(
						'id'=>'pagecontent-grid-index1',
						'pager' => array('cssFile' => false),//pagination styles moved to common.css
						'cssFile'=>false,// we are using our own CSS. Yii default styles are disabled and we are including the style in admin/common.css
						'dataProvider'=>$dataProvider_menu_subnav,
						'columns'=>array(
							array(
								'name'=>'menuid',
								'header'=>'Menu ID',
								'htmlOptions'=>array('width'=>'10px'),			
							),		
							array(
								'name'=>'menuname',
								'header'=>'Menu Name',
								'htmlOptions'=>array('width'=>'50px'),			
							),
							array(
								'name'=>'published',
								'header'=>'Published',
								'htmlOptions'=>array('width'=>'60px'),			
							),
							array(
								'name'=>'special_id_text',
								'header'=>'	Special template reference ',
								'htmlOptions'=>array('width'=>'70px'),			
							),		
							array(
								'class'=>'CButtonColumn',
								'template'=>'{update}',
								'updateButtonImageUrl'=>false,
								'updateButtonLabel' => false,									
								'updateButtonUrl'=>'Yii::app()->createUrl("/admincms/pages/updatemenu/", array("id"=>$data["menuid"]))', 'header'=>'Update',      
								'buttons'=>array
									(
										'delete' => array
										(
											'update' => array
											(
												'options'=>array('class'=>'update', 'title'=>'Update')
											),
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
											'url'=>'$data["menuid"]. \'?\' .$data["menuname"]',
											'click'=>'function(){
												var val_string = $(this).attr("href");
												var val_arr = val_string.split("?");
												$("#delete_item").show("fast"); 
												$("#delete_menu_id").val(val_arr[0]);
												$("#delete_menu_name").val(val_arr[1]);
												$("#info").html("Page ID: " + val_arr[0] + " - " + val_arr[1]);
												$("#menu_name").val(val_arr[1]);
												return false;
											}',
											'options'=>array('style'=>'margin-left: 3px', 'title'=>'Delete', 'class'=>'delete'),
										),
									),			
								'updateButtonUrl'=>'Yii::app()->createUrl("/admincms/pages/updatemenu/", array("id"=>$data["menuid"]))', 'header'=>'Delete',              
							),
							array(
								'class'=>'CButtonColumn',
								'template'=>'{menu_items}',
								'buttons'=>array
									(
										'menu_items' => array
										(
											'label'=>'Menu Items',
											'url'=>'Yii::app()->createUrl("/admincms/pages/createmenuitem/", array("id"=>$data["menuid"]))',
											'options'=>array('style'=>'margin-left: 3px', 'class' => 'link'),
											
										),
									),			
								'updateButtonUrl'=>'Yii::app()->createUrl("/admincms/pages/updatemenu/", array("id"=>$data["menuid"]))','header'=>'Menu items',
							),		
						),
					));
				}
			}
			break;
		case 'menuitem':
				$this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'pagecontent-grid-index2',
				'pager' => array('cssFile' => false),//pagination styles moved to common.css
				'cssFile'=>false,// we are using our own CSS. Yii default styles are disabled and we are including the style in admin/common.css
				'dataProvider'=>$dataProvider,
				'showTableOnEmpty'=>false,
				'columns'=>array(
				array(
				'header'=>'Page Menu Item ID',
				'name'=> 'pagemenu_itemid'
				),
				array(
					'class'=>'CButtonColumn',
					'template'=>'{update}',	
					'updateButtonImageUrl'=>false,
					'updateButtonLabel' => false,						
					'updateButtonUrl'=>'Yii::app()->createUrl("/admincms/pages/Updatemenuitems/", array("id"=>$data["pagemenu_itemid"], "menuid"=>$data["menuid"]))',
					'header'=>'Update',
					'buttons'=>array
					(
						'update' => array
						(
							'options'=>array('title'=>'Update', 'class'=>'update'),
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
							'label'=>'Delete',
							'url'=>'$data["pagemenu_itemid"]. \'?\' .$data["page"]["menu_heading"]',
							'click'=>'function(){
								confirmDelete(this);
								return false;
							}',
							'options'=>array('title'=>'Delete', 'class'=>'delete'),
						),
						
					),
					'header'=>'Delete',
					
				),
				array(
					'header'=>'Menu Heading',
					'name'=>'$data["page"]["menu_heading"]',
					'value'=>'(empty($data["menu_heading_override"]) ? $data["page"]["menu_heading"] : $data["menu_heading_override"])',
				 ),
				 array(
					'header'=>'Page ID',
					'name'=>'$data["pageid"]',
					'value'=>'$data["pageid"]',
				 ),
				 'absolute_url',
				 'orderno',
				array(
					'name'=>'Published',
					'value'=>'($data->published == 1 ? "Yes" : "No")',
				 ),
				),
				));
			break;
		case 'previewImages':
			$img_path = gGetImagePath(2);
			print("<div style='width: 300px;'>
			<fieldset><legend>Image Preview</legend>
			");
			$this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'image-preview',
				'pager' => array('cssFile' => false),//pagination styles moved to common.css
				'cssFile'=>false,// we are using our own CSS. Yii default styles are disabled and we are including the style in admin/common.css
				'dataProvider'=>$dataProvider,
				'showTableOnEmpty'=>false,
				'hideHeader'=>true,
				'columns'=>array(
					array(
						'name'=>'image_thumbnail',
						'header'=>'Image List',
						'type'=>'html',
						'value'=>'CHtml::image(\'/images/generic_image_bank/\' . (!empty($data->parentcatid) ?  $data->parentcatid . \'/\' . $data->categoryid : $data->categoryid) . \'/thumbs/\' . (!empty($data->thumb_image_fileref) ?  $data->thumb_image_fileref : $data->image_fileref) . \'\', \'\' . (!empty($data->thumb_image_fileref) ?  $data->thumb_image_fileref : $data->image_fileref) . \'\')',
						'headerHtmlOptions'=>array('style'=>'font-size:12px; width: 20px !important;'),
						'htmlOptions' => array('style'=>'font-size:12px,width:100px;height:50px,overflow:hidden;'),
					),
				array(
					'class'=>'CButtonColumn',
					'template'=>'{assign}',		
					'buttons'=>array
					(
						'assign' => array
						(
							'label'=>'Assign',
							'url'=>'Yii::app()->createUrl("/admincms/pages/assignimages/", array("assign_image"=>1, "pageid"=>' . $pageid . ', "imageid"=>$data["imageid"]))',
							'options' => array('onclick'=>'doAction(this);return false;', 'class'=>'link', 'title'=>'Assign'),
						),
						
					),
					
				),					
				),
			));
			print('</fieldset></div>');
			break;	
		case 'getAssignedImages':
			$img_path = gGetImagePath(2);
			$this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'view-assigned-images',
				'pager' => array('cssFile' => false),//pagination styles moved to common.css
				'cssFile'=>false,// we are using our own CSS. Yii default styles are disabled and we are including the style in admin/common.css
				'dataProvider'=>$dataProvider,
				'showTableOnEmpty'=>false,
				'columns'=>array(							
					'category_name',
					array(
                        'name'=>'orderno',
						'header'=>'Order no',
                        'value'=> 'Chtml::textField("ordernoimage".$data->imageid, $data->orderno, array("style"=>"font-size:12px; width: 30px !important;", "id" => "ordernoimage".$data->imageid))',
                        'type'=>'raw',
                        'headerHtmlOptions'=>array('width'=>'100px !important;'),

					),	
					array(
						'class'=>'CButtonColumn',
						'template'=>'{orderAssign}',		
						'buttons'=>array
						(
							'orderAssign' => array
							(
								'label'=>'Update',
								'url'=>'$data["imageid"]',
								'options' => array('onclick'=>'assignOrder(this);return false;', 'class'=>'link', 'title'=>'Update'),
							),
							
						),
						
					),						
					array(
						'name'=>'image_thumbnail',
						'header'=>'Preview',
						'type'=>'html',
						'value'=>'CHtml::image(\'/images/generic_image_bank/\' . (!empty($data->parentcatid) ?  $data->parentcatid . \'/\' . $data->categoryid : $data->categoryid) . \'/thumbs/\' . (!empty($data->thumb_image_fileref) ?  $data->thumb_image_fileref : $data->image_fileref) . \'\', \'\' . (!empty($data->thumb_image_fileref) ?  $data->thumb_image_fileref : $data->image_fileref) . \'\')',
						'htmlOptions' => array('style'=>'font-size:12px,width:100px;height:50px,overflow:hidden;'),
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
								'url'=>'Yii::app()->createUrl("/admincms/pages/assignimages/", array("delete_img"=>1,"imageid"=>$data["imageid"],"pageid"=>' . $pageid . '))',
								'options' => array('onclick'=>'doAction(this);return false;', 'title'=>'Delete', 'class'=>'delete'),
							),
							
						),
						
					),					
				),
			));	
			break;
			
			case 'getAssignedCategry':

			$this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'view-assigned-category',
				'pager' => array('cssFile' => false),//pagination styles moved to common.css
				'cssFile'=>false,// we are using our own CSS. Yii default styles are disabled and we are including the style in admin/common.css
				'dataProvider'=>$dataProvider,
				'showTableOnEmpty'=>false,
				'columns'=>array(							
					'category_name',
					'categoryid', 
					'parentcatid', 
					'category_name',		
					array(
						'class'=>'CButtonColumn',
						'template'=>'{delete}',		
						'deleteButtonImageUrl'=>false,
						'deleteButtonLabel' => false,								
						'buttons'=>array
						(
							'delete' => array
							(
								'url'=>'Yii::app()->createUrl("/admincms/pages/assignimages/", array("delete_cat"=>1,"id"=>' . $pageid . '))',
								'options' => array('title'=>'Delete', 'class'=>'delete'),
							),
							
						),
					
					),	
				),
			));	
			break;
	}

?>