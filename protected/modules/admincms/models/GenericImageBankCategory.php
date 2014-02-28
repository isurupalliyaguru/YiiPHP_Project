<?php

/**
 * This is the model class for table "generic_image_bank_category".
 *
 * The followings are the available columns in table 'generic_image_bank_category':
 * @property integer $categoryid
 * @property string $category_name
 */
class GenericImageBankCategory extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return GenericImageBankCategory the static model class
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
		return 'generic_image_bank_category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		if(empty(Yii::app()->user->super_user_un))
			$rules[] = array('category_name, parentcatid', 'required');
		$rules[] = array('category_name', 'length', 'max'=>100);
		$rules[] = array('categoryid, category_name, parentcatid, sef_url, thumbnail_width, thumbnail_height', 'safe');	
		$rules[] =  array('sef_url', 'unique');
		return $rules;
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'children' => array(self::HAS_MANY, 'GenericImageBankCategory', 'parentcatid'),
		);

	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'categoryid' => 'Category ID',
			'category_name' => 'Category Name',
			'parentcatid' => 'Parent Category',
			'sef_url' => 'Sef Url',
			'thumbnail_width' => 'Thumbnail Width',
			'thumbnail_height' => 'Thumbnail Height',
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
		
		if(empty(Yii::app()->user->super_user_un)) /// Allow Super user to edit main category
			$criteria->condition = "t.parentcatid IS NOT NULL";

		$criteria->compare('categoryid',$this->categoryid);
		$criteria->compare('category_name',$this->category_name,true);
			
		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	public function parentcatID()
	{
		/*
			post: returns an array of category ids
		*/
		$list = array();
		//The following query can be exceuted with a criteria object as well, the advantage is some query validations which prevents sql injections and so on and also supports Cgridview dataprovider
		//$result_arr = parent::model()->findAllBySql("SELECT pageid, menu_heading FROM page_content WHERE published=1 ORDER BY pageid");
		$criteria = new CDbCriteria;
		$criteria->select = 'categoryid, category_name';
		$criteria->order = 'categoryid';
		$criteria->condition = 'parentcatid IS NULL';
		$result_arr = $this->model()->findAll($criteria);
		foreach($result_arr as $row) {
			$list[$row["categoryid"]] = $row["categoryid"] . " - " . $row["category_name"];	
		}
        return $list;
	}
	
	public function getSubCat($catid, $subcatid) {
		/*
			pre:
				$catid => Parent Category ID
				$subcat => Sub category ID
			post:
				returns array for 
		*/
		$list = '';
		$criteria = new CDbCriteria;
		$criteria->select = 'categoryid, category_name, thumbnail_width, thumbnail_height';
		$criteria->order = 'categoryid';
		$criteria->condition = 'parentcatid='.$catid;
		$result_arr = $this->model()->findAll($criteria);	
		foreach($result_arr as $row) {
			$list .= '<option' . ($subcatid == $row["categoryid"] ? ' selected="selected"' : '') . ' value="' . $row["categoryid"] . '">' . $row["category_name"] . ' (Thumb - ' . $row["thumbnail_width"] . 'x' . $row["thumbnail_height"] . ')</option>';	
		}
		return $list;
		
	}
	
	public function getAllCategories(){
		
		$connection = Yii::app()->db;
		$result = array();
		$sql = 'SELECT gc.categoryid, gc.parentcatid, gc.category_name, gc2.category_name AS parentcat FROM generic_image_bank_category gc
					LEFT JOIN generic_image_bank_category gc2 ON gc2.categoryid = gc.parentcatid';
					
		$command = $connection->createCommand($sql);
		$data = $command->query();
		$result_arr = $data->readAll();
		
		foreach($result_arr as $row) {

			if(!empty($row["parentcatid"])){
				$result[] =  array('id'=>$row["categoryid"],'text'=>$row["category_name"],'group'=>$row["parentcat"]);
			} else {
				$result[] =  array('id'=>$row["categoryid"],'text'=>$row["category_name"]);
			}
		}

		return $result;
		
	}
	
	public function getCategoryByCategoryId($catid){
		if(is_numeric($catid)){
			$criteria=new CDbCriteria;
			$criteria->select = 'categoryid, parentcatid, category_name ';
			$criteria->condition = 'categoryid='.$catid;
			return new CActiveDataProvider(get_class($this), array(
				'criteria'=>$criteria
			));
		}
		else
			return new CArrayDataProvider (array());
		

	}
	
	public function getCategoryDropdown()
	{
		/*
		 * Return a array of image categories, gouped by parent categories. & Listing no child parents in a goupe called array
		 * $data can be used with Yii CActiveForm eg: dropDownList($model, property_type, $data);
		 */
		$parents = GenericImageBankCategory::model()->findAll('parentcatid IS NULL'); //quering all parent categories
		$data = array();
		$nochild = array();
		foreach($parents as $parent)
		{
			$sub_data = array();				
			if (empty($parent->children)) { // seperating parent categories those have no children
				$nochild [$parent->categoryid] = $parent->category_name;
			}
			else {	
				foreach($parent->children as $child) // grouping child categories with parent category heading
				{
					$sub_data[$child->categoryid] = $child->category_name;
				}
				$data[$parent->category_name] = $sub_data;
			}
			$data["Main"] = $nochild;
		}
		return $data;
	}
}