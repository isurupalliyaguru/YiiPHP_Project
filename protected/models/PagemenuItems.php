<?php

class PagemenuItems extends CActiveRecord
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
		return 'pagemenu_items';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('orderno', 'numerical', 'integerOnly'=>true),
			array('pageid, absolute_url, pagemenu_itemid, menuid, menu_heading_override, published, titletag, use_is_blank, addon_class, is_header', 'safe')
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'menu' => array(self::BELONGS_TO, 'Pagemenu', 'menuid'),
			'page' => array(self::BELONGS_TO, 'Pagecontent', 'pageid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pagemenu_itemid' => 'Pagemenu Itemid',
			'menuid' => 'menu id',
			'pageid' => 'Content-managed Page',
			'menu_heading_override' => 'Menu Heading Override',
			'orderno' => 'Order no',
			'absolute_url' => 'Absolute Url',
			'published' => 'Published',
			'titletag' => 'Title tag',
			'meta_description' => 'Meta Description',
			'use_is_blank' => 'Open in new window (target is_blank)',
			'addon_class' => 'CSS Addon Class',
			'is_header' => 'Is Header',
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

		$criteria->compare('pagemenu_itemid',$this->pagemenu_itemid);
		$criteria->compare('menuid',$this->menuid,true);
		$criteria->compare('pageid',$this->pageid,true);
		$criteria->compare('menu_heading_override',$this->menu_heading_override,true);
		$criteria->compare('orderno',$this->orderno,true);
		$criteria->compare('absolute_url',$this->absolute_url,true);
		$criteria->compare('published',$this->published,true);
		$criteria->compare('titletag',$this->titletag,true);
		$criteria->compare('meta_description',$this->meta_description,true);
		$criteria->compare('use_is_blank',$this->use_is_blank,true);	
		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
			'Pagination' => array (
                  'pageSize' => 50, //edit your number items per page here
            ),
		));
	}
	
	public function validateAbsoluteurlandPageid() {
		//pre: pageid and absolute_url both are posted (we should only have one not both)
		//post: if both are available error message is given and "false" is returned else flase is returned.
		if (empty($this->pageid) && empty($this->absolute_url)) {
			$this->addError($this->absolute_url, 'Please select either a page from the dropdown or provide an absolute URL');
			return false;
		}
		else if (!empty($this->pageid) && !empty($this->absolute_url)) {
			$this->addError($this->absolute_url, 'You have chosen a page from the dropdown below AND entered an absolute URL. Please clear one of these, as a menu item link should either be a page OR an absolute link.');
			return false;
		}
		else 
			return true;
	}
		
	public function getMenuIdAndMenuName($this_pageid) {
		/*
		pre: This is accepting the ide of the page 
		Post: Returns the menu id and the menu name related to that page
		*/
		$connection = Yii::app()->db;	
		$result_submenu ="
						SELECT		m.menuid, m.menuname
						FROM 	pagemenu m, pagemenu_items mi						
						WHERE	mi.pageid=" . $this_pageid . "
						AND		mi.published=1
						AND		m.menuid=mi.menuid
						AND		m.published=1
						AND		m.is_subnavigation=1";
		$command = $connection->createCommand($result_submenu);
		$data = $command->query();
		$rows=$data->read();
		if(empty($rows))
			return false;
		else {
			return $rows;
		}
	}
	
	public function getDbResult_SubMenuItems($menuid) {
		/*
		pre: menuid of the submenu is passed, to display the items
		Post: Returns the submenu items related to the menu id
		*/
		$connection = Yii::app()->db;	
		$result_submenuitems ="
									SELECT	mi.menu_heading_override, mi.absolute_url, mi.titletag, mi.use_is_blank, mi.is_header, 
											p.pageid, p.sef_url, p.menu_heading, p.html_h1, 
											mi.pagemenu_itemid, ISNULL(mi.orderno) AS orderno_isnull
											
									FROM 	pagemenu_items mi
									LEFT OUTER JOIN	page_content p
									ON		mi.pageid=p.pageid
									
									WHERE	mi.menuid=".$menuid."
									AND		mi.published=1		
									AND 	(mi.pageid IS NULL OR (NOT(p.published=0)))
									
									ORDER BY	orderno_isnull, mi.orderno, mi.pagemenu_itemid
					";
		$command = $connection->createCommand($result_submenuitems);
		$data = $command->query();
		$rows=$data->readAll();
		if(empty($rows))
			return false;
		else {
			return $rows;
		}
	}
        
        public function getAllMenuItemsBySpecialId($spc_txt_arr) {
			/**
			* 
			* @param type $spc_txt_arr array of special text like array('t1','f1')
			* @return mix boolean or the arrya of data which with the index of given specil_text_ids
			*/
            $arr = array();
            $connection = Yii::app()->db;
            $str = "";
			
            if (!empty($spc_txt_arr)) {
                foreach ($spc_txt_arr as $value) {
					$str .=  (!empty($str) ? " OR " : "") . " pm.special_id_text = '".$value . "'";
                }
            }
            $sql = "SELECT pm.menuid, pm.menuname, pm.special_id_text, pm.published, pm.is_subnavigation, pi.pagemenu_itemid, pi.pageid, p.sef_url,
			p.html_h1, pi.is_header, pi.menu_heading_override, pi.orderno, pi.absolute_url, pi.published, pi.titletag, pi.use_is_blank, pi.addon_class,
			pi.is_header, ISNULL(pi.orderno) AS orderno_isnull, p.menu_heading
					FROM pagemenu_items AS pi
					INNER JOIN pagemenu AS pm ON pi.menuid = pm.menuid
					LEFT OUTER JOIN	page_content p ON pi.pageid=p.pageid
					WHERE ".$str . "
					AND		pm.published=1	
					AND		pi.published=1
					ORDER BY pm.special_id_text, orderno_isnull, pi.orderno, pi.pagemenu_itemid";
            $command = $connection->createCommand($sql);
            $data = $command->query();
            $rows=$data->readAll();
            
            if(empty($rows)){
                    return false;                
            }
            else {
                foreach ($rows as $value) {
                    $key = $value['special_id_text'];
                    $arr[$key][] = $value;
                }        
                return $arr;
            }            
        }
}