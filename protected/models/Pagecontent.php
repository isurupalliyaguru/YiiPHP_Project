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
 * @property integer $categoryid
 *
 * The followings are the available model relations:
 * @property Pagecontent $parentPage
 * @property Pagecontent[] $pageContents
 * @property PagemenuItems[] $pagemenuItems
 */
class Pagecontent extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Pagecontent the static model class
	 */
	 
	public $html_title = "";
	public $meta_keywords = "";
	public $meta_description = "";
	public $addon_css_class = "";
	public $pageid = "";
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'page_content';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('published, parent_pageid', 'numerical', 'integerOnly'=>true),
			array('sef_url','length', 'max'=>50),
			array('menu_heading', 'length', 'max'=>100),
			array('menu_heading', 'required'),
			array('sef_url', 'required'),
			array('html_h1, html_title', 'length', 'max'=>200),
			array('html_content, html_content2, html_content3, meta_keywords, meta_description, addon_class, categoryid', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pageid, sef_url, menu_heading, html_content, html_content2, html_content3, html_h1, html_title, meta_keywords, meta_description, published, parent_pageid, date_created, date_last_modified, published_on_news, categoryid', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'parentPage' => array(self::BELONGS_TO, 'Pagecontent', 'parent_pageid'),
			'pageContents' => array(self::HAS_MANY, 'Pagecontent', 'parent_pageid'),
			'pagemenuItems' => array(self::HAS_MANY, 'PagemenuItems', 'pageid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pageid' => 'Page ID',
			'sef_url' => 'SEF URL',
			'menu_heading' => 'Menu Heading',
			'html_content' => 'Content',
			'html_content2' => 'Content - secondary',
			'html_content3' => 'Content - third',
			'html_h1' => 'HTML Heading (h1)',
			'html_title' => 'HTML Title',
			'meta_keywords' => 'Meta Keywords',
			'meta_description' => 'Meta Description',
			'published' => 'Published',
			'parent_pageid' => 'Parent Page ID',
			'addon_class' => 'CSS Addon Class',			
			'date_created' => 'Created date',
			'date_last_modified' => 'Last modified date',
			'published_on_news' => 'Published on news',
			'categoryid' => 'Category',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		//This is a Yii function mainly used to get all data or search for data (like in CGridView)
		$criteria=new CDbCriteria;

		$criteria->compare('pageid',$this->pageid);
		$criteria->compare('sef_url',$this->sef_url,true);
		$criteria->compare('menu_heading',$this->menu_heading,true);
		$criteria->compare('html_content',$this->html_content,true);
		$criteria->compare('html_content2',$this->html_content2,true);
		$criteria->compare('html_content3',$this->html_content3,true);
		$criteria->compare('html_h1',$this->html_h1,true);
		$criteria->compare('html_title',$this->html_title,true);
		$criteria->compare('meta_keywords',$this->meta_keywords,true);
		$criteria->compare('meta_description',$this->meta_description,true);
		$criteria->compare('published',$this->published);
		$criteria->compare('parent_pageid',$this->parent_pageid);
		$criteria->compare('categoryid',$this->categoryid);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
			'Pagination' => array (
                  'pageSize' => 50, //edit your number items per page here
            ),
		));
	}
	
	public function getPageContent($query_value, $checkpublished=true) {
		//returns an array of page information
		if (empty($query_value)) $query_value="home"; //home page
		$connection = Yii::app()->db;
		$sql = "SELECT pageid,parent_pageid,html_content, html_content2, html_content3, html_h1, html_title, addon_class, meta_keywords, meta_description, categoryid,menu_heading FROM page_content WHERE sef_url = '" . $query_value . "' " . ($checkpublished ? "AND published=1" : "");
		$command = $connection->createCommand($sql);
		$data = $command->query();
		$rows=$data->read();
		if(empty($rows)) {
			return false;
		}
		else {
			$this->pageid = $rows['pageid'];
			$this->parent_pageid = $rows['parent_pageid'];
			return $rows;
		}
	}
	
	public function getCategoryByPageId($pageid){
	
		$sql= "SELECT categoryid FROM page_content WHERE pageid=".$pageid."";
		
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
	
	public function removeCategoryId($pageid){
		
		$sql = "UPDATE page_content SET categoryid=NULL WHERE pageid=". $pageid;
		
		$connection = Yii::app()->db;
		$command = $connection->createCommand($sql);
		$data = $command->query();
		
		return true;
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
	
	public function setPageAttributes($row) {
		/* @param $row contains all the page DB content
			post: Sets page attributes for this $row['pageid']  OR does nothing if the page is not found
		*/

		if(!empty($row['pageid'])) { //if the page id is empty in the database result the requested 'sef_url' is incorrect. So the page id should not be empty.		
			$this->html_title = $row['html_title'];
			$this->meta_description = (!empty($row['meta_description']) ? $row['meta_description'] : app()->SiteConfig->defaultMetaDescription);
			$this->meta_keywords = (!empty($row['meta_keywords']) ? $row['meta_keywords'] : app()->SiteConfig->defaultMetaKeywords);
			$this->addon_css_class = ( !empty($row['addon_class']) ? $row['addon_class'] : "");
			$this->pageid = $row['pageid'];	
		}
	}
	
	public function getBreadcrumbData($pageid){
	/*
	pre:  'getbreadcrumb' stored procedure should run in the datacase.
	Post: Give out the parent sef url for the breadcrumb
	*/
		$sql = "CALL getbreadcrumb(".$pageid.")";
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