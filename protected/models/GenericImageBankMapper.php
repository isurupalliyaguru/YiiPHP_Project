<?php
/*
This class is handling the model - "GenericImageBank" so that any function related to GenericImageBank can be managed 

Note: Mapper class for a given model should be used in case constructor parameters should be passed to the given models (there may be many constructor parameters for different purposes). That is because if you try to overload the existing model constructor, sometimes you will violate the actual purpose of the given model
Reference: fetchImages()

*/

class GenericImageBankMapper
{	 
	 function __construct($pageid) {
		//@param $pageid is the current page' pageid from the pagecontent table
		$this->pageid = $pageid; 
	 }	
	
	public function fetchImages($categoryid="", $limit="") {
		//@param 	$categoryid for assigned images to this page.
		//@limit 	$limit to get the limited images. 
		//post:		returns a array of "GenericImageBank" model objects
		$connection = Yii::app()->db;
		$sql= "
		SELECT 	gib.image_fileref, gib.image_height, gib.image_width, gib.image_alt, gib.image_title, gib.image_version, gib.url, gib.image_html, gib.categoryid, gibc.parentcatid
		FROM 	generic_image_bank_page gibp, generic_image_bank gib
		INNER JOIN generic_image_bank_category gibc ON gib.categoryid = gibc.categoryid
		WHERE 	gibp.pageid = " . $this->pageid . " AND
				gib.categoryid=$categoryid AND
				gib.imageid=gibp.imageid
		ORDER BY isnull( gib.order_no ) , gib.order_no " . (!empty($limit) ? "LIMIT " . $limit : "" ) . "
		";
		$command = $connection->createCommand($sql);
		$dataReader = $command->query();
		$model_gib_arr = array();
		Yii::app()->getDb()->setActive(false);
		while(($row=$dataReader->read())!==false) { 
			$model_gib = new GenericImageBank;
			$model_gib->image_fileref = $row['image_fileref'];
			$model_gib->image_height = $row['image_height'];
			$model_gib->image_width = $row['image_width'];
			$model_gib->image_alt = $row['image_alt'];
			$model_gib->image_title = $row['image_title'];	
			$model_gib->image_version = $row['image_version'];	
			$model_gib->url = $row['url'];	
			$model_gib->parentcatid = $row['parentcatid'];
			$model_gib->categoryid = $row['categoryid'];
			$model_gib->image_html = $row['image_html'];
			$model_gib_arr[] = $model_gib;
		}
		return $model_gib_arr;
	}
	
	public function fetchCategory($categoryid="", $limit="") {
		//@param 	$categoryid - for a speciic assigned category (when an entire category update the fetchCategory function with the comment)
		//@limit 	$limit to get the limited images. 
		//post:		returns a array of "GenericImageBank" model objects where the page is assigned to this particular $categoryid, so we fetch all the images under this category in one go.
		$connection = Yii::app()->db;
		$sql= "
		SELECT 	gib.image_fileref, gib.image_height, gib.image_width, gib.image_alt, gib.image_title, gib.image_version, gib.url, gib.categoryid, gibc.parentcatid
		FROM 	generic_image_bank gib
		INNER JOIN generic_image_bank_category gibc ON gib.categoryid = gibc.categoryid
		WHERE 	gib.categoryid=$categoryid 
		ORDER BY isnull( gib.order_no ) , gib.order_no " . (!empty($limit) ? "LIMIT " . $limit : "" ) . "
		";

		$command = $connection->createCommand($sql);
		$dataReader = $command->query();
		$model_gib_arr = array();
		Yii::app()->getDb()->setActive(false);
		$arr_index = 1;
		while(($row=$dataReader->read())!==false) { 
			$model_gib = new GenericImageBank;
			$model_gib->image_fileref = $row['image_fileref'];
			$model_gib->image_height = $row['image_height'];
			$model_gib->image_width = $row['image_width'];
			$model_gib->image_alt = $row['image_alt'];
			$model_gib->image_title = $row['image_title'];	
			$model_gib->image_version = $row['image_version'];	
			$model_gib->url = $row['url'];	
			$model_gib->parentcatid = $row['parentcatid'];
			$model_gib->categoryid = $row['categoryid'];
			$model_gib_arr[$arr_index] = $model_gib;
			$arr_index++;
		}
		return $model_gib_arr;
	}
	
	
	public function getCategoryID($widget) {
		//@param 	$widget is the widget name for which the categoryid should be taken . 
		//post:		returns categoryid for the widget or '' if the widget is not valid
		$xml = simplexml_load_file(Yii::app()->basePath."/config/widget_category.xml");	//loading the xml file content	
		foreach($xml->children() as $widget) { 
			if($widget->name == $widget) { //obtaining the category id for this widget. 
				return $widget->categoryid;
			}
		}
		return '';
	}
	
	public function getCategoryDetailsByCategoryId($catid){
		//@catid 	$categoryid is a valid category from the page_content table. 
		//post:		returns a array of "GenericImageBank" model objects
		
		if(is_numeric($catid) && !empty($catid)){
		
			$sql = "select parentcatid, category_name, thumbnail_width, thumbnail_height FROM  generic_image_bank_category WHERE categoryid=" . $catid;
			$connection = Yii::app()->db;
			$command = $connection->createCommand($sql);
			$data = $command->query();
			$result_arr = $data->read();
			if(empty($result_arr)){
				return false;
			} else {
				return $result_arr;
			}
		}

	}
}