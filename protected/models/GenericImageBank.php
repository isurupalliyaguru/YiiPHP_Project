<?php

/**
 * This is the model class for table "generic_image_bank".
 *
 * The followings are the available columns in table 'generic_image_bank':
 * @property integer $imageid
 * @property string $image_fileref
 * @property integer $image_height
 * @property integer $image_width
 * @property integer $image_version
 * @property integer $image_type
 *
 * The followings are the available model relations:
 * @property PageContent[] $pageContents
 */
class GenericImageBank extends CActiveRecord
{
	public $upload_image;
	public $category_name;
	public $image_thumbnail;
	public $parentcatid;
	/**
	 * Returns the static model of the specified AR class.
	 * @return GenericImageBank the static model class
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
		return 'generic_image_bank';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('image_type', 'required'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('imageid, image_fileref, thumb_image_fileref, image_height, image_width, image_version, categoryid, category_name, image_alt, image_title, url, advanced_options, image_html', 'safe', 'on'=>'search'),
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
			'pageContents' => array(self::MANY_MANY, 'PageContent', 'generic_image_bank_page(imageid, pageid)'),
			'pageContents' => array(self::HAS_MANY, 'GenericImageBankCategory', 'categoryid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'imageid' => 'Image id',
			'image_fileref' => 'Image File Reference',
			'thumb_image_fileref' => 'thumb_image_fileref',
			'image_height' => 'Image Height',
			'image_width' => 'Image Width',
			'image_version' => 'Image Version',
			'categoryid' => 'Image Category',
			'image_alt' => 'Image Alternative Text',
			'image_title' => 'Image Title',
			'url' => 'URL',
			'image_html' => 'Image HTML',
			'advanced_options' => 'Advanced Options',
			'upload_image' => 'Upload Image',
		);
	}
	
	public function getImgpath(){
		/* 
		 * post:	returns the image directory path
		 */ 
		$basePath = gGetImagePath(1, false);
		return $basePath . (empty($this->parentcatid) ? "" : $this->parentcatid . "/") . (empty($this->categoryid) ? "" : $this->categoryid . "/");
	}
	
	public function getImgUrl(){
		/*
		* post:	returns the completely prepeared image file path
		*/
		return $this->getImgpath() . $this->image_fileref;
	}
	
	public function getImageTag($class_css="") {
		//pre: all the model attributes used on this tag should be used before the function call
		//post:	returns the image tag
		if ($this->url) { //assume the URL is a full one with http:// or an absolute /aboutus/ for example.
			$alink_open = "<a href='" . $this->url . "'>";
			$alink_close = "</a>";
		}
		else {
			$alink_open = "";
			$alink_close = "";
		}
		return $alink_open . "<img "  . (!empty($class_css) ? "class='" . $class_css . "'" : "") .  " src='" . $this->getImgUrl() . "?". $this->image_version . "' width='" . $this->image_width . "' height='" . $this->image_height   . "' alt='" . $this->image_alt . "' title='" . $this->image_title . "' />" . $alink_close;
	}	
}
