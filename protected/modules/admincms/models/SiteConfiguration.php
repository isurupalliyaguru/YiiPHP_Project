<?php
/**
 * This is the model class for table "site_configuration".
 *
 * The followings are the available columns in table 'site_configuration':
 * @property string $configid
 * @property string $jscode_in_head
 * @property string $jscode_upper_body
 * @property string $jscode_lower_body
 * @property string $default_email_address
 */
class SiteConfiguration extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return SiteConfiguration the static model class
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
		return 'site_configuration';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('default_email_address', 'length', 'max'=>128),
			array('default_meta_description,default_meta_keywords,default_email_address', 'required'),
			array('jscode_in_head, jscode_upper_body, jscode_lower_body, default_meta_description, default_meta_keywords', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('configid, jscode_in_head, jscode_upper_body, jscode_lower_body, default_email_address, default_meta_description, default_meta_keywords', 'safe', 'on'=>'search'),
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
			'configid' => 'Configid',
			'jscode_in_head' => 'Javascript Code In Head',
			'jscode_upper_body' => 'Javascript Code Upper Body',
			'jscode_lower_body' => 'Javascript Code Lower Body',
			'default_email_address' => 'Default Email Address',
			'default_meta_description' => 'Default Meta Description',
			'default_meta_keywords' => 'Default Meta Keywords',			
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
		$criteria->compare('configid',$this->configid,true);
		$criteria->compare('jscode_in_head',$this->jscode_in_head,true);
		$criteria->compare('jscode_upper_body',$this->jscode_upper_body,true);
		$criteria->compare('jscode_lower_body',$this->jscode_lower_body,true);
		$criteria->compare('default_email_address',$this->default_email_address,true);
		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
/*	
	public function getConfigStatus($modelname) {
		/*
			@param $modelname =>  read the xml for this model
			post: return the array of site configuration
		*/
/*		$siteConfig = array();
		$xml = simplexml_load_file(Yii::app()->basePath."/config/site_config.xml");	//loading the xml file content
		foreach($xml->children() as $model) { 
			if($model->name == $modelname) { //creating siteConfig array
				$siteConfig['enabled'] = $model->enabled;
				if (!empty($model->attributes)) {
						foreach($model->attributes->children() as $attr_elem_name => $attr_elem) {
							foreach ($attr_elem->children() as $name => $val){  //if sub element of <attributes> has children, array generation continues
								$siteConfig[$attr_elem_name][$name] = $val;
							}
							if (!isset($siteConfig[$attr_elem_name])) //if element has no children, get the attribute value
								$siteConfig[$attr_elem_name] = $attr_elem;
						}
				}
			}
		}
	}
*/	
	public function createSitemap() {
		/*
			pre: Must be called from the SiteConfigurationController.php
			post: Generate the "sitemap.xml" for all published pages
		*/		
		
		$enabledModules = gGetEnabledModules();
		$retarr = array();	
		foreach($enabledModules as $moduleName=>$in_sitemap) {	
			try { // This Try-catch is used in case if the developer mistakenly enabled <insitemap>t</insitemap> and the model is not ready with getXMLSitemapArray(), the exception is handled
				if ($in_sitemap == 't') {
					$moduleName = ucwords($moduleName) . '_cms'; // Any module should have a model in CMS for this purpose
					$this_model = new $moduleName();
					$tempRet = $this_model->getXMLSitemapArray(); // Each model (in CMS) should have a getXMLSitemapArray(), for a sample, please follow portfolio model is enabled on 3003online development server. 
					$retarr =  array_merge($retarr, $tempRet);
				}
			} catch (Exception $e) {}
		}
		
		$model = new Pagecontent_cms(); //We assume that any site which has been integrated with CMS3003online has a pages module
		$retarr = $model->getXMLSitemapArray();
	
		$sitemap = "";		
		$sitemap .= "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
		$sitemap .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
		
		foreach($retarr as $row) {			
			$sitemap .= "\t<url>\n";
			$sitemap .= "\t\t<loc>" . Yii::app()->getBaseUrl(true) . "/" . $row["url_post_suffix"] . "</loc>\n";
			$sitemap .= "\t\t<priority>". $row['priority'] . "</priority>\n";
			$sitemap .= "\t\t<changefreq>" . $row['changefreq'] . "</changefreq>\n";
			$sitemap .= ($row['lastmod']!="" ? "\t\t<lastmod>" . $row['lastmod'] . "</lastmod>\n" : "");
			$sitemap .= "\t</url>\n";
		}
				
		$sitemap .= "</urlset>\n";		
		$sitemapxml = fopen(gGetBasePath() . "/sitemap.xml","w");
		fwrite($sitemapxml, $sitemap);
		fclose($sitemapxml);
	}	
}