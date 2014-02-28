<?php

/**
 * This is the model class for table "page_content".
 *
 * The followings are the available columns in table 'page_content':
 * @property integer $pageid
 * @property string $sef_url
 * @property string $menu_heading
 * @property string $html_content
 * @property string $html_content2
 * @property string $html_content3
 * @property string $html_h1
 * @property string $html_title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property integer $published
 * @property integer $parent_pageid
 *
 * The followings are the available model relations:
 * @property Pagecontent $parentPage
 * @property Pagecontent[] $pageContents
 * @property PagemenuItems[] $pagemenuItems
 */
class Hotel extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Pagecontent the static model class
	 */	
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'c_page_hotel';
	}

	public function getDetailContent($pageid) {
		//@pre : $pageid 
		//returns an array of page information
		$connection = Yii::app()->db;
		$sql = "SELECT address, price_rate_startfrom, star_rating, location_html, hotel_facilities, hotel_policies , hotel_extra_info, hotel_extra_info_title, client_email_address, video_url, gmap_longitude, gmap_latitude FROM " . $this->tableName() . " WHERE pageid = '" . $pageid . "'";
		$command = $connection->createCommand($sql);
		$data = $command->query();
		$rows=$data->read();
		if(empty($rows)) {
			return false;
		}
		else {
			return $rows;
		}
	}
	
	public function getLongitudeLatitude($pageid) {
		//@pre : $pageid current page
		//post : returns all the Longitude and Latitude informations of the hotel except current
		$connection = Yii::app()->db;
		$sql = "SELECT pc.html_content, pc.html_h1, pd.pageid, pd.gmap_longitude, pd.gmap_latitude FROM " . $this->tableName() . " pd INNER JOIN page_content pc ON pd.pageid = pc.pageid  WHERE pd.pageid != '" . $pageid . "'";
		$command = $connection->createCommand($sql);
		$data = $command->query();
		$rows=$data->readAll();
		if(empty($rows)) {
			return false;
		}
		else {
			return $rows;
		}
	}
	
	Public function getPageId() {
	/*
	pre: getPageContent() function shuld be calle before this
	Post: Give out the current page id
	*/
		if(!empty($this->pageid))
			return $this->pageid;
		else {
			return false;
		}
	}
	Public function getParentPageId() {
	/*
	pre:  getPageContent() function shuld be calle before this
	Post: Give out the current parent page id if available
	*/
		if(!empty($this->parent_pageid))
			return $this->parent_pageid;
		else {
			return false;
		}
	}
}