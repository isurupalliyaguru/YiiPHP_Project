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
			'logo_image_filename' => 'Logo filename ',
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
	public function getPortfolioContent() {
		/*
		pre: Function is called when the sefurl is "portfolio" 
			
		Post: Returns the menu id and the menu name related to that page
		*/
	
		$connection = Yii::app()->db;	
		$portfolio ="SELECT *, DATE_FORMAT(launch_date, '%b %Y') AS launch_date_f FROM portfolio WHERE published=1 
								ORDER BY orderno DESC, portfolio_id";
		$command = $connection->createCommand($portfolio);
		$data = $command->query();
		$rows=$data->readAll();
		if(empty($rows))
			return false;
		else {
			return $rows;
		}
	
	}
}