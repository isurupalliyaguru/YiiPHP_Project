 <?php 
 class photoGallery extends CWidget { 
 //Class name should be defined with the same name which is in the /config/widget_category.xml
 //the following class variables should be passed with the same name, whereever this widget is called. 
 //E.g.   array('ItmName'=>'image category', 'confirmText'=>'image category','delete_item_id'=>'delete_page_id', 'delete_item_name'=>'delete_page_name')
 //Optional field 'ajaxAction'=>'adminCategory', 
 
	public $widgetName; 
	public $pageid;
	public $video_url;
	public $categoryid;
	
    public function init()
    {
        // this method is called by CController::beginWidget()
    }
 
    public function run()
    {
		$model_gib_mapper = new GenericImageBankMapper($this->pageid);
		$catInfo = $model_gib_mapper->getCategoryDetailsByCategoryId($this->categoryid);
		/*$xml = simplexml_load_file(Yii::app()->basePath."/config/widget_category.xml");	//loading the xml file content	
		foreach($xml->children() as $widget) { 
			if($widget->name == __class__) { //obtaining the category id for this widget. 
				$categoryid = $widget->categoryid;
			}
		}*/

		$model_gib_arr = $model_gib_mapper->fetchCategory($this->categoryid);
		$model_gib_middle = $model_gib_mapper->fetchCategory($this->categoryid, 1);
		//for now we only need the first banner - so get only the first element of the array

		if (!empty($model_gib_arr)) {
			$litag = '<section class="image_gallery">
						<figure class="lowlineheight"> ';
							while(list($key, $model_gib) = each($model_gib_middle)){ //assume here only ONE image is defined (i.e. the primary image for the property)
			$litag .= '			<a href="javascript: void(0)" id="single_image">
									<img  src="http://www.apartmentslanka.com/images/generic_image_bank/'. $catInfo["parentcatid"].'/'. $this->categoryid .'/' . $model_gib->image_fileref . '" alt="' . $model_gib->image_alt . '" class="gallery_large_img"/>
								</a>
								<p>'. $model_gib->image_alt .'</p>';
							}
			$litag .='	</figure>';
					
			$litag .= '<section class="thumbnail_area">								
						<section class="thumbnails" id="slider">
							<a class="arrow_previous buttons prev" href="#" > </a>
							<div class="viewport">
								<ul class="overview"> ';
			$count = 1;
			while(list($key, $model_gib) = each($model_gib_arr)){
				$litag .= '<li>
							<a rel="img_gallery" href="http://www.apartmentslanka.com/images/generic_image_bank/' . $catInfo["parentcatid"]. '/' . $this->categoryid . '/' . $model_gib->image_fileref . '" class="thumb_img img_gallery" '. ($count == 1 ? 'id="thumb_image_first"' : "" ) . ' title="'. $model_gib->image_title .'">
								<img src="http://www.apartmentslanka.com/images/generic_image_bank/' . $catInfo["parentcatid"]. '/'. $this->categoryid .'/thumbs/' . $model_gib->image_fileref . '" alt="' . $model_gib->image_alt . '" width="' . $catInfo["thumbnail_width"]. '" height="' . $catInfo["thumbnail_height"]. '" class="thumbnail_img" />
							</a>
						  </li>';
				$count++;
			}
			
			if (!empty($this->video_url)) {
				$litag .= '<li>
							<a class="thumb_img various fancybox.iframe"  href="'. $this->video_url .'"> 
								<img src="/images/video_thumb/video_thumb.jpg" alt="" class="thumbnail_img img_gallery" />
							</a>
						</li>';
			}
																		
			$litag .='	</ul>
					  </div>									
					<a class="arrow_next buttons next" href="#" > </a>
					</section>
				</section>
			</section>';

			print ($litag);
		}
			
    }
}