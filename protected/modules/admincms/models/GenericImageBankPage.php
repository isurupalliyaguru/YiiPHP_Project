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
class GenericImageBankPage extends CActiveRecord
{
	public $category_name;
	public $categoryid;
	public $image_fileref;
	public $imageid;
	public $image_thumbnail;
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
		return 'generic_image_bank_page';
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
			array('pageid, imageid, orderno', 'safe', 'on'=>'search'),
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
			//'pageContents' => array(self::MANY_MANY, 'PageContent', 'generic_image_bank_page(imageid, pageid)'),
			//'pageContents' => array(self::HAS_MANY, 'GenericImageBankCategory', 'categoryid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pageid' => 'Page id',
			'imageid' => 'Image id',
			'orderno' => 'Order no',
			'category_name' => 'Category'
		);
	}

	
	public function getAssignedImages($categoryid="") {
		/*
			pre:
			post: returns image list for assigned images
		*/
		$criteria=new CDbCriteria;
		$criteria->select = 'gibc.*,gib.image_fileref,gib.image_height,gib.image_width,t.orderno,t.pageid,t.imageid';
		$criteria->join = '
		INNER JOIN generic_image_bank gib ON gib.imageid = t.imageid
		INNER JOIN generic_image_bank_category gibc ON gibc.categoryid = gib.categoryid';//t is the Alias for the current table 
		$criteria->condition = 'pageid='.$this->pageid;
		$criteria->order='gib.categoryid, ISNULL(t.orderno) ,t.orderno';
		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
			'Pagination' => array (
                  'pageSize' => 50, //edit your number items per page here
              ),

		));
	}
}
