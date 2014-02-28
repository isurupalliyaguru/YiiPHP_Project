<?php

class Pagemenu extends CActiveRecord
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
		return 'pagemenu';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('menuid, menuname, published, is_subnavigation,special_id_text', 'safe')
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
			'menuItems' => array(self::HAS_MANY, 'PagemenuItems', 'menuid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'menuid' => 'Menu id',
			'menuname' => 'Menu name',
			'published' => 'Published',
			'is_subnavigation' => 'Is Subnavigation',
			'special_id_text' => 'Special template reference',
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

		$criteria->compare('menuid',$this->pageid);
		$criteria->compare('menuname',$this->sef_url,true);
		$criteria->compare('menu_heading',$this->menu_heading,true);
		$criteria->compare('published',$this->html_content,true);
		$criteria->compare('is_subnavigation',$this->html_content2,true);
		$criteria->compare('special_id_text',$this->html_h1,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
			'Pagination' => array (
                  'pageSize' => 50, //edit your number items per page here
            ),
		));
	}
}