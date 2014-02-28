<?php 
class Pagemenu_cms extends Pagemenu {
	
	public $dataProvider_1;
	public $dataProvider_2;
	public $check_provider;
	
	public function getDataprovider_menu() {
		/*
			post: sets dataproviders($dataProvider_1, $dataProvider_2) which contains the data of all menus. 
		*/
	
		$arr_menu_subnav = array();
		$arr_menu_main = array();
		$this->check_provider = false;
		$result_arr = parent::model()->findAll();
		$sort = new CSort;
        $sort->defaultOrder = 'menuname';
        $sort->attributes = array('menuid', 'menuname');
		
		foreach ($result_arr as $row) {
			if ($row["is_subnavigation"] == 1) {
				$arr_menu_subnav[$row["menuid"]]["menuid"] = $row["menuid"];
				$arr_menu_subnav[$row["menuid"]]["menuname"] = $row["menuname"];
				$arr_menu_subnav[$row["menuid"]]["published"] = ($row["published"] == 1 ? 'Yes' : 'No');
				$arr_menu_subnav[$row["menuid"]]["special_id_text"] = $row["special_id_text"];
			}
			else {
				$arr_menu_main[$row["menuid"]]["menuid"] = $row["menuid"];
				$arr_menu_main[$row["menuid"]]["menuname"] = $row["menuname"];
				$arr_menu_main[$row["menuid"]]["published"] = ($row["published"] == 1 ? 'Yes' : 'No');
				$arr_menu_main[$row["menuid"]]["special_id_text"] = $row["special_id_text"];		
			}	
		}
		$this->dataProvider_1 = new CArrayDataProvider($arr_menu_main, array(
						'keyField' => 'menuid', 
						'id'=>'main_menu',
                        'pagination'=>array(
                                'pageSize'=>'50',
                        ), 
						'sort' => $sort								
        ));
		//$dataProvider_menu_main = new ArrayDataProvider($arr_menu_main);
		if(!empty($arr_menu_subnav)) {
			$this->dataProvider_2 = new CArrayDataProvider($arr_menu_subnav, array(
						'keyField' => 'menuid', 
						'id'=>'sub_menu',
                        'pagination'=>array(
                                'pageSize'=>'50',
                        ),     
						'sort' => $sort								
			));
			//$dataProvider_menu_subnav = new ArrayDataProvider($arr_menu_subnav);
			$this->check_provider = true;
		}
	
	}
	
}

?>

