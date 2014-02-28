<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	protected $_canonicalUrl; // This will be set base on the controller functionlity (e.g. pages, places (in AL))

	public function getCanonicalUrl() {  return $this->_canonicalUrl; }
	
	public function getCanonicalTag() {  
		/* 
			Returns the Canonical tag if the canonicalUrl is set
		*/
		$tag = ''; 
		if (!empty($this->_canonicalUrl)) // All but home has no SEF URL
			$tag = '<link rel="canonical" href="' . getHTTPURL(). ($this->_canonicalUrl!='home' ? $this->_canonicalUrl . '/' : '') . '"/>';
		else if ($this->action->Id == 'error') //If this is the error page, print no index tag
			$tag = '<meta name="robots" content="noindex" />';		
		return $tag;
	}
	
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
}