<?php
/* ========================================== important note===================================================
Function defined in this will be available glabally anywhere in the application. 
When adding a new function please add it with prefix g (g stands for global). For eg: if you want to write a function called getImagePath
name it as "gGetImagePath". By adding this prefix any developer will be able to identify this function is from the shared functions and it will
avoid any confusion.
	========================================== important note===================================================*/
/**
 * This is the shortcut to DIRECTORY_SEPARATOR
 */
defined('DS') or define('DS',DIRECTORY_SEPARATOR);
include("country_array.php");
 
/**
 * This is the shortcut to Yii::app()
 */
function app()
{
    return Yii::app();
}
 
/**
 * This is the shortcut to Yii::app()->clientScript
 */
function cs()
{
    // You could also call the client script instance via Yii::app()->clientScript
    // But this is faster
    return Yii::app()->getClientScript();
}
 
/**
 * This is the shortcut to Yii::app()->user.
 */
function user() 
{
    return Yii::app()->getUser();
}
 
/**
 * This is the shortcut to Yii::app()->createUrl()
 */
function url($route,$params=array(),$ampersand='&')
{
    return Yii::app()->createUrl($route,$params,$ampersand);
}
 
/**
 * This is the shortcut to CHtml::encode
 */
function h($text)
{
    return htmlspecialchars($text,ENT_QUOTES,Yii::app()->charset);
}
 
/**
 * This is the shortcut to CHtml::link()
 */
function l($text, $url = '#', $htmlOptions = array()) 
{
    return CHtml::link($text, $url, $htmlOptions);
}
 
/**
 * This is the shortcut to Yii::t() with default category = 'stay'
 */
function t($message, $category = 'stay', $params = array(), $source = null, $language = null) 
{
    return Yii::t($category, $message, $params, $source, $language);
}


function getHTTPURL() {
	return "http://" . Yii::app()->request->getServerName() . "/";
}


function gGetEnabledModules() {
	/*
		pre:
		post:
			This function goes through each module in the site config XML and returns an array of all the enabled modules
	*/
	$modulesEnabled = array();
	$xml = simplexml_load_file(Yii::app()->basePath."/config/site_config.xml");	//loading the xml file content
	foreach($xml->children() as $module) {//Go through each module in the XML and prepare the array of enabled modules
		if ($module->enabled = 't') {
			$mod_name = trim($module->name);
			$modulesEnabled[$mod_name] = trim($module->insitemap);
		}
	}
	return $modulesEnabled;
}

function gGetConfigStatus($moduleName) {
	/*
		@param $modelname =>  read the xml for this model
		post: return the array of site configuration. This is used to enable/disable additional modules in the CMS - see site_config.xml
	*/
	$siteConfig = array();
	$xml = simplexml_load_file(Yii::app()->basePath."/config/site_config.xml");	//loading the xml file content
	//$siteConfig['enabled']=0;// By default let's assume that the module is not enabled
	foreach($xml->children() as $module) { 
		if($module->name == $moduleName) { //creating siteConfig array
			$siteConfig['enabled'] = $module->enabled;
			if (!empty($module->attributes)) {
				foreach($module->attributes->children() as $attr_elem_name => $attr_elem) {
					foreach ($attr_elem->children() as $name => $val){  //if sub element of <attributes> has children, array generation continues
						$siteConfig[$attr_elem_name][$name] = $val;
					}
					if (!isset($siteConfig[$attr_elem_name])) //if element has no children, get the attribute value
						$siteConfig[$attr_elem_name] = $attr_elem;
				}
			}
		}
	}
	return $siteConfig;
}

function gIsModelEnabled($modelname) {
	/*
		@param $modelname => module to be checked
		post: check if a given module is enabled
	*/
	$siteConfig = gGetConfigStatus($modelname);
	if ($siteConfig['enabled']=='t')
		return true;
	else
		return false;
}
 
/**
 * This is the shortcut to Yii::app()->request->baseUrl
 * If the parameter is given, it will be returned and prefixed with the app baseUrl.
 */
function baseUrl($url=null) 
{
    static $baseUrl;
    if ($baseUrl===null)
        $baseUrl=Yii::app()->getRequest()->getBaseUrl();
    return $url===null ? $baseUrl : $baseUrl.'/'.ltrim($url,'/');
}
 
/**
 * Returns the named application parameter.
 * This is the shortcut to Yii::app()->params[$name].
 */
function param($name) 
{
    return Yii::app()->params[$name];
}

function gGetImagePath($type, $getAbsolutePath=false, $categoryid="") {
	/* 	@param $type	1 = GIB, 2 = GIB Thumbnails
		post:	returns non-SSL/SSL static sub-domain depend on the page url (secure/non secure)
	*/
	if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=='on')) {
		switch ($type) {
			case 1:		$http_aux = "images/generic_image_bank/";
				break;
		}
		return  baseUrl() . $http_aux;
	}
	else {
		switch ($type) {
			case 1:	return ($getAbsolutePath ? gGetBasePath() : "")."/images/generic_image_bank/";
			case 2: return ($getAbsolutePath ? gGetBasePath()  : "")."/images/generic_image_bank/";			
		}
	}
}

function gGetBasePath() {
	//post: returns the basepath of the site
	return Yii::getPathOfAlias('webroot');
}

function gescapeJS($string) {
		/*	@params:
				$string (string) - String unscaped
			Post: escape the string to JavaScript
		*/

		// escape quotes and backslashes, newlines, etc.
		return strtr($string, array
			(
				'\\'=>'\\\\',
				"'"=>"\\'",
				'"'=>'\\"',
				"\r"=>'\\r',
				"\n"=>'\\n',
				'</'=>'<\/'
			));
}

?>