<?php
class SiteConfiguration extends CApplicationComponent {	
	/* 	
		Class note - IMPORTANT!! 
		If you want to use SiteConfiguration attributes anywhere in the site ,
			say, defaultMetaDescription - 
				** call it as app()->siteConfig->defaultMetaDescription 
				** DO NOT call it as app()->siteConfig->getDefaultMetaDescription() because the component object(instance) is fully controlled by get/set methods, once you call an attribute(e.g. app()->siteConfig->defaultMetaDescription ) relevent get method will automatically be called and return the value. 
				** Once you call an attribute of this class a component object will be created and in another words, init(); query runs once in the application
		Developed by: Ashan c Perera		
	*/

	private $_jscodeInHead;	//component attibutes are caseInsensitive
	private $_jscodeUpperBody;	
	private $_jscodeLowerBody;	
	private $_defaultEmailAddress;	
	private $_defaultMetaDescription;	
	private $_defaultMetaKeywords;

    public function init() {		
		$sql = "SELECT * FROM site_configuration";	
		$connection = Yii::app()->db;
		$command = $connection->createCommand($sql);		
		$data = $command->query();		
		$row_meta_data=$data->read();		
		$this->_jscodeInHead = $row_meta_data['jscode_in_head'];		
		$this->_jscodeUpperBody = $row_meta_data['jscode_upper_body'];		
		$this->_jscodeLowerBody = $row_meta_data['jscode_lower_body'];		
		$this->_defaultEmailAddress = $row_meta_data['default_email_address'];		
		$this->_defaultMetaDescription = $row_meta_data['default_meta_description'];		
		$this->_defaultMetaKeywords = $row_meta_data['default_meta_keywords'];
    }	
	//get method naming convention: get{attribute name without "_"}
	
	public function getJscodeInHead() { return $this->_jscodeInHead; }	
	public function getJscodeUpperBody() { return $this->_jscodeUpperBody; }	
	public function getJscodeLowerBody() { return $this->_jscodeLowerBody; }		
	public function getDefaultEmailAddress() { return $this->_defaultEmailAddress; }			
	public function getDefaultMetaDescription() { return $this->_defaultMetaDescription; }		
	public function getDefaultMetaKeywords() { return $this->_defaultMetaKeywords; }

	/* example set method */
	//public function setJscodeInHead() { return $this->_jscodeInHead; }	
	
}
?>