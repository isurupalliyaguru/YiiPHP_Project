<?php

/**
 * This is the model class for table "portfolio".
 *
 * The followings are the available columns in table 'portfolio':
 * @property integer $portfolio_id
 * @property integer $orderno
 * @property string $logo_image_filename
 * @property string $title
 * @property string $url
 * @property string $launch_date
 * @property string $short_desc
 * @property string $technology_desc
 * @property string $features_desc
 * @property string $comments
 * @property string $commentator
 * @property integer $published
 */
class Portfolio extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Portfolio the static model class
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
		return 'portfolio';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('orderno', 'numerical', 'integerOnly'=>true),
			array('logo_image_filename', 'length', 'max'=>50),
			array('title, commentator', 'length', 'max'=>100),
			array('url', 'length', 'max'=>255),
			array('title', 'required'), 
			array('launch_date', 'checkValidDate'),
			array('short_desc, technology_desc, features_desc, comments', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('portfolio_id, orderno, logo_image_filename, url, launch_date, short_desc, technology_desc, features_desc, commentator, published', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'portfolio_id' => 'Portfolio ID :',
			'orderno' => 'Order no :',
			'logo_image_filename' => 'Logo filename :',
			'title' => 'Title :',
			'url' => 'URL :',
			'launch_date' => 'Launch Date :',
			'short_desc' => 'Short Description :',
			'technology_desc' => 'Technology :',
			'features_desc' => 'Features :',
			'comments' => 'Comments :',
			'commentator' => 'Commentator :',
			'published' => 'Published on site :',
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

		$criteria=new CDbCriteria;

		$criteria->compare('portfolio_id',$this->portfolio_id);
		$criteria->compare('orderno',$this->orderno);
		$criteria->compare('logo_image_filename',$this->logo_image_filename,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('launch_date',$this->launch_date,true);
		$criteria->compare('short_desc',$this->short_desc,true);
		$criteria->compare('technology_desc',$this->technology_desc,true);
		$criteria->compare('features_desc',$this->features_desc,true);
		$criteria->compare('comments',$this->comments,true);
		$criteria->compare('commentator',$this->commentator,true);
		$criteria->compare('published',$this->published);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
			'Pagination' => array (
                  'pageSize' => 50, //edit your number items per page here
              ),

		));
	}
	public function checkValidDate($date) {
		//pre: format of day, month, year are digits as d/dd, m/mm, yyyy
		//post: returns tru if valid, returns false and sets an error message if invalid.
		if (!empty($this->launch_date)) {
			$date = $this->launch_date;
			$date_arr = explode("-",$date);
			$yyyy =(int)$date_arr[0];
			$mm = (int)$date_arr[1];
			$dd = (int)$date_arr[2];
			if (checkdate($mm, $dd, $yyyy))
				return true;
			else {
				$this->addError($this->launch_date, 'Date is invalid please insert in yyyy-mm-dd format');
				return false;
			}
		}
		else {
			$this->launch_date = null;
			return true;
		}
	}
}