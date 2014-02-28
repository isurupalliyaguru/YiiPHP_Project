<?php 
class Pagecontent_cms extends Pagecontent {
	
	public $dataProvider_1;
	public $dataProvider_2;
	public $check_provider;

	public function parentpageID()
	{
		/*
			post: returns an array of published page ids
		*/
		$list = array();
		//The following query can be exceuted with a criteria object as well, the advantage is some query validations which prevents sql injections and so on and also supports Cgridview dataprovider
		//$result_arr = parent::model()->findAllBySql("SELECT pageid, menu_heading FROM page_content WHERE published=1 ORDER BY pageid");
		$criteria = new CDbCriteria;
		$criteria->select = 'pageid, menu_heading';
		$criteria->condition = 'published=:published';
		$criteria->params = array(':published'=>1);
		$criteria->order = 'pageid';
		$result_arr = parent::model()->findAll($criteria);
		foreach($result_arr as $row) {
			$list[$row["pageid"]] = $row["pageid"] . " - " . $row["menu_heading"];	
		}
        return $list;
	}
	
	public function getDataprovider_pages() {
		/*
			post: sets dataproviders($dataProvider_1, $dataProvider_2) which contains the data of all the pages. 
		*/
	
		$this->check_provider = false;
		$arr_published = array();
		$arr_unpublished = array();
		$result_arr = parent::model()->findAll();
		$sort = new CSort;
        $sort->defaultOrder = 'sef_url';
        $sort->attributes = array('pageid', 'sef_url','date_created', 'date_last_modified');
		
		foreach($result_arr as $row) {
			if($row["published"] == 1) {
				$arr_published[$row["pageid"]]["pageid"] = $row["pageid"];
				$arr_published[$row["pageid"]]["sef_url"] = $row["sef_url"];
				$arr_published[$row["pageid"]]["menu_heading"] = $row["menu_heading"];
				$arr_published[$row["pageid"]]["parent_pageid"] = $row["parent_pageid"];
				$arr_published[$row["pageid"]]["date_created"] = $row["date_created"];
				$arr_published[$row["pageid"]]["date_last_modified"] = $row["date_last_modified"];
				//$arr_published[$row["pageid"]]["published_on_news"] = $row["published_on_news"];
			}
			else
			{
				$arr_unpublished[$row["pageid"]]["pageid"] = $row["pageid"];
				$arr_unpublished[$row["pageid"]]["sef_url"] = $row["sef_url"];
				$arr_unpublished[$row["pageid"]]["menu_heading"] = $row["menu_heading"];
				$arr_unpublished[$row["pageid"]]["parent_pageid"] = $row["parent_pageid"];	
				$arr_unpublished[$row["pageid"]]["date_created"] = $row["date_created"];
				$arr_unpublished[$row["pageid"]]["date_last_modified"] = $row["date_last_modified"];
				//$arr_unpublished[$row["pageid"]]["published_on_news"] = $row["published_on_news"];
			}	
		}
		$this->dataProvider_1 = new CArrayDataProvider($arr_published, array(
						'keyField' => 'pageid', 
						'id'=>'sub_menu',
                        'pagination'=>array(
                                'pageSize'=>'50',
                        ),   
						'sort' => $sort
        ));
		if(!empty($arr_unpublished)) {
			$this->dataProvider_2 = new CArrayDataProvider($arr_unpublished, array(
							'keyField' => 'pageid', 
							'id'=>'sub_menu',
							'pagination'=>array(
									'pageSize'=>'50',
							), 
							'sort' => $sort							
			));
			$this->check_provider = true;
		}		
	}
	
	public function getXMLSitemapArray() {
		/* pre: called from createSitemap() in SiteConfiguration.php
		   post: this generates an array of sitemap data (see below for the fields) of all published pages
		*/
		$i = 0;
		
		$criteria=new CDbCriteria;
		$criteria->select = array("sef_url, date_last_modified");	
		$criteria->condition = 'published=:published';
		$criteria->params = array(':published'=>1);		
		$result_arr = parent::model()->findAll($criteria);
				
		foreach($result_arr as $row) {
			if ( $row['sef_url'] != "pagenotfound" ){
				$retarr[$i]["url_post_suffix"] = ( $row['sef_url']!="home" ? $row['sef_url'] . "/" : "");
				$retarr[$i]["changefreq"] = "monthly";
				$retarr[$i]["lastmod"] = ( $row["date_last_modified"]!="" ? Yii::app()->dateFormatter->format('yyyy-MM-dd', $row["date_last_modified"]) : "");
				$retarr[$i]["priority"] = ( $row['sef_url']=="home" ? 1.0 : 0.8 );
				$i++;
			}
		}		
		return $retarr;
	}
}

?>

