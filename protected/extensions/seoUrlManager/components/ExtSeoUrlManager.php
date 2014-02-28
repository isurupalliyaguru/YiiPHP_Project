<?php

/**
 * seoUrlManager Application Component.
 *
 * Extend CUrlManager to make web application URLs more SEO friendly.
 *
 * @package ext.seoUrlManager.components
 * @author TeamTPG
 * @copyright Copyright &copy; 2011 TeamTPG
 * @license BSD 3-clause
 * @link http://code.teamtpg.ch/seourlmanager
 * @version 1.0.1
 */
class ExtSeoUrlManager extends CUrlManager {

	/**
	 * @var mixed Define if www should be stripped or added to URL. Deactivate by setting it to false.
	 * Available options: 'add', 'strip', false
	 */
	public $wwwMode = 'add';

	/**
	 * @var string Current URL.
	 */
	protected $_currentUrl;

	/**
	 * @var string Scheme of current URL.
	 */
	protected $_scheme;

	/**
	 * @var string Host of current URL.
	 */
	protected $_host;

	/**
	 * @var integer Port of current URL.
	 */
	protected $_port;

	/**
	 * @var string Path of current URL.
	 */
	protected $_path;

	/**
	 * Initialize the component, populate properties and run the handlers.
	 * @throws CException if URL cannot be parsed.
	 * @throws CException if no rules are set.
	 */
	public function init() {
		$this -> _currentUrl = Yii::app() -> request -> hostInfo . Yii::app() -> request -> requestUri;
		//Parse URL
		if(($urlParts = @parse_url($this -> _currentUrl)) === false) {
			Yii::log('URL cannot be parsed, falling back to standard urlManager', CLogger::LEVEL_ERROR, 'ext.seoUrlManager.components.ExtSeoUrlManager');
			parent::init();
			return;
		}
		if(empty($this -> rules) && empty($this -> urlRuleClass)) {
			throw new CException('ExtSeoUrlManager: rules/urlRuleClass setting required.');
		}
		$this -> _scheme = (!empty($urlParts['scheme'])) ? $urlParts['scheme'] : '';
		$this -> _host = (!empty($urlParts['host'])) ? $urlParts['host'] : '';
		$this -> _port = (!empty($urlParts['port'])) ? $urlParts['port'] : '';
		$this -> _path = (!empty($urlParts['path'])) ? $urlParts['path'] : '';
		//Process URL
		$this -> _wwwHandler();
		$this -> _entryScriptHandler();
		$this -> _slashHandler();
		$this -> _redirect();
		//Set urlManager settings
		$this -> useStrictParsing = true;
		$this -> urlFormat = 'path';
		$this -> showScriptName = false;
		$this -> urlSuffix = rtrim($this -> urlSuffix, '/') . '/';
		$this -> caseSensitive = true;
		$this -> appendParams = true;
		parent::init();
	}

	/**
	 * Add or strip www in URL to avoid duplicate content.
	 */
	protected function _wwwHandler() {
		$wwwMode = $this -> wwwMode;
		if($wwwMode !== false) {
			$host = $this -> _host;
			if($wwwMode === 'add' && strpos($host, 'www.') !== 0) {
				$host = 'www.' . $host;
			} else if($wwwMode === 'strip' && strpos($host, 'www.') === 0) {
				$host = substr($host, 4);
			}
			$this -> _host = $host;
		}
	}

	/**
	 * Hide entry script to avoid duplicate content.
	 */
	protected function _entryScriptHandler() {
		$path = $this -> _path;
		$baseUrl = Yii::app() -> baseUrl;
		$scriptName = basename(Yii::app() -> request -> scriptUrl);
		$entryScriptUrl = substr_replace($path, '', 0, strlen($baseUrl));
		if(strpos($entryScriptUrl, $scriptName) === 1) {
			$entryScriptUrl = substr_replace($entryScriptUrl, '', 0, strlen($scriptName) + 1);
			if(strpos($entryScriptUrl, '/') !== 0) {
				$entryScriptUrl = '/' . $entryScriptUrl;
			}
		}
		$this -> _path = $baseUrl . $entryScriptUrl;
	}

	/**
	 * Add trailing slash if necessary and replace multiple slashes with single slash
	 * to avoid duplicate content.
	 */
	protected function _slashHandler() {
		$path = $this -> _sanitizeSlashes($this -> _path);
		if(substr($path, -1) != '/') {
			$path .= '/';
		}
		$this -> _path = $path;
	}

	/**
	 * Connect individual URL parts.
	 * @return string Complete URL.
	 */
	protected function _connectUrlParts() {
		$scheme = $this -> _scheme . '://';
		$port = (!empty($this -> _port)) ? ':' . $this -> _port : '';
		return $scheme . $this -> _host . $port . $this -> _path;
	}

	/**
	 * Redirect to new URL if necessary.
	 */
	protected function _redirect() {
		$newUrl = $this -> _connectUrlParts();
		if($this -> _currentUrl != $newUrl) {
			Yii::app() -> request -> redirect($newUrl, true, 301);
		}
	}

	/**
	 * Replace multiple forward slashes with single slash.
	 * @param string $str String to sanitize.
	 * @return string Sanitized string.
	 */
	protected function _sanitizeSlashes($str) {
		if(strpos($str, '//') !== false) {
			return $this -> _sanitizeSlashes(str_replace('//', '/', $str));
		}
		return $str;
	}

}
