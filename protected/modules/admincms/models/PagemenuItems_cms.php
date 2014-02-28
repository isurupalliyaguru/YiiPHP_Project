<?php 
class PagemenuItems_cms extends PagemenuItems {
	
	//public $orderno_isnull;
	public function rules()
	{
		return array(
			array('menuname', 'required', 'on'=>'scenarioCreateMenu'),
		);
	}
	public function getmenuitems($id)
	{             
		/*$result_arr = parent::model()->findAllBySql("
									SELECT	pi.pagemenu_itemid, pi.menuid, pi.menu_heading_override, pi.orderno, 
											pi.pageid, pi.absolute_url, pi.titletag, pi.published, pi.use_is_blank,
											pm.menuname, pc.menu_heading,
											ISNULL(pi.orderno) AS orderno_isnull
									FROM	pagemenu_items pi

									LEFT OUTER JOIN pagemenu pm
									ON pm.menuid = pi.menuid

									LEFT OUTER JOIN	page_content pc
									ON pc.pageid = pi.pageid
									
									WHERE	pi.menuid = $menuid
									
									ORDER BY orderno_isnull, pi.orderno, pi.pagemenu_itemid"); */
									
		/* 
			Since Object-Relational Mapping (ORM) is used on CMS with models we can easily query data efficiently with much easy CRUD operations
			-- The following is an example of fetching data easily using the models sinch tables(models) in the system is mapped correctly (one to one , one to many, .... relation ships)
			-- This mapping is used using the rules() in the model. Reference: PagemenuItems (frontend->models) => Rules()
			-- So make sure you map the table correctly using rules() whenever you create a new model
		*/	
		
		$criteria = new CDbCriteria;
		$criteria->select = 'pagemenu_itemid, menuid, orderno, pageid, absolute_url, published, menu_heading_override, ISNULL(orderno) AS orderno_isnull';
		$criteria->with = array(
			array(
					'page'=>array(
						'select' => 'menu_heading',
						'joinType' => 'LEFT OUTER JOIN',
						'condition' => 'page.pageid = t.pageid',
					), 
					'menu'=>array(
						'select' => 'menuname',
						'joinType' => 'LEFT OUTER JOIN',
						'condition' => 'menu.menuid = t.menuid',		
					),
			)
		);
		$criteria->condition = 'menuid=:id';
		$criteria->params = array(':id'=>$id);
		$criteria->together = true; 
		$criteria->order ='orderno_isnull, orderno, pagemenu_itemid';
		return new CActiveDataProvider('PagemenuItems', array( 
                'criteria'=>$criteria,
                'Pagination' => array (
                'pageSize' => 50, //edit your number items per page here (but this is not working for this model right now)
            ),
        ));
	}
}

?>

