<?php

/**
 * This is the model class for table "newsletter_signup".
 *
 * The followings are the available columns in table 'newsletter_signup':
 * @property integer $subscribeid
 * @property string $date_of_subscription
 * @property string $email_address
 */
class NewsletterSignup extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return NewsletterSignup the static model class
	public $newsletter_errors
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
		return 'newsletter_signup';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email_address', 'required'),
			array('email_address', 'email'),
			//array('subscribeid', 'numerical', 'integerOnly'=>true),
			array('email_address', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('subscribeid, date_of_subscription, email_address', 'safe', 'on'=>'search'),
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
			'subscribeid' => 'Subscribe ID',
			'date_of_subscription' => 'Date Of Subscription',
			'email_address' => 'Email Address',
		);
	}
}