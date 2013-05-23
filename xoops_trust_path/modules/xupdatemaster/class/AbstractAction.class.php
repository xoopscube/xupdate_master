<?php
/**
 * @file
 * @package xupdatemaster
 * @version $Id$
**/

if(!defined('XOOPS_ROOT_PATH'))
{
    exit;
}

// Set include_path
if (!defined('PATH_SEPARATOR')) {
	define('PATH_SEPARATOR', (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN')? ':' : ';');
}
set_include_path(get_include_path() . PATH_SEPARATOR . dirname(dirname(__FILE__)) . '/PEAR');

// load compatibility code
require_once XUPDATEMASTER_TRUST_PATH . '/include/compat.php';

/**
 * Xupdatemaster_AbstractAction
**/
abstract class Xupdatemaster_AbstractAction
{
    public /*** XCube_Root ***/ $mRoot = null;

    public /*** Xupdatemaster_Module ***/ $mModule = null;
    public $mModuleConfig = null;

    public /*** Xupdatemaster_AssetManager ***/ $mAsset = null;

    public $mAccessController = array();

    protected $sHandler;
    protected $iHandler;
    protected $isAdmin;
    
    private $jsonCacheFile;
    private $jsonCacheTTL = 600;
    
    /**
     * __construct
     * 
     * @param   void
     * 
     * @return  void
    **/
    public function __construct()
    {
        $this->mRoot =& XCube_Root::getSingleton();
        $this->mModule =& $this->mRoot->mContext->mModule;
        $this->mModuleConfig =& $this->mRoot->mContext->mModuleConfig;
        $this->mAsset =& $this->mModule->mAssetManager;
        $this->sHandler =& $this->mAsset->getObject('handler', 'store', false);
        $this->iHandler =& $this->mAsset->getObject('handler', 'item', false);
        $this->isAdmin = $this->mRoot->mContext->mUser->isInRole('Module.'.$this->mAsset->mDirname.'.Admin');
        $this->jsonCacheFile = XOOPS_ROOT_PATH . '/uploads/' . $this->mAsset->mDirname . '/stores_json%s.txt';
    }

    /**
     * _getConst
     * 
     * @param   string  $key
     * @param   string  $action
     * 
     * @return  string
    **/
    protected function _getConst(/*** string ***/ $key, /*** string ***/ $action=null)
    {
        $action = isset($action) ? $action : $this->_getActionName();
        return constant(get_class($this).'::'. $key);
    }

    /**
     * _getHandler
     * 
     * @param   void
     * 
     * @return  Xupdatemaster_{Tablename}Handler
    **/
    protected function _getHandler()
    {
        $handler = $this->mAsset->getObject('handler', constant(get_class($this).'::DATANAME'));
        return $handler;
    }

    /**
     * getPageTitle
     * 
     * @param   void
     * 
     * @return  string
    **/
    public function getPagetitle()
    {
        ///XCL2.2 only
        return Legacy_Utils::formatPagetitle($this->mRoot->mContext->mModule->mXoopsModule->get('name'), $this->_getTitle(), $this->_getActionTitle());
    }

    /**
     * _getTitle
     * 
     * @param   void
     * 
     * @return  string
    **/
    protected function _getTitle()
    {
        if(! $this->mObject) return null;
        if($this->mObject->getShow('title')){
            return $this->mObject->getShow('title');
        }
        else{
            return null;
        }
    }

    /**
     * _getActionTitle
     * 
     * @param   void
     * 
     * @return  string
    **/
    protected function _getActionTitle()
    {
        return null;
    }

    /**
     * _getActionName
     * 
     * @param   void
     * 
     * @return  string
    **/
    protected function _getActionName()
    {
        return null;
    }


	/**
	 * _setupAccessController
	 * 
	 * @param	string	$dataname
	 * 
	 * @return	void
	**/
	protected function _setupAccessController(/*** string ***/ $dataname)
	{
		$this->mAccessController['main'] = Xupdatemaster_Utils::getAccessControllerObject($this->mAsset->mDirname, $dataname);
	}
    /**
     * _getDatePickerScript
     * 
     * @param   void
     * 
     * @return  String
    **/
    protected function _getDatePickerScript()
    {
        return '$(".datePicker").each(function(){$(this).datepicker({dateFormat: "'._JSDATEPICKSTRING.'"});});';
    }

    /**
     * _getStylesheet
     * 
     * @param   void
     * 
     * @return  String
    **/
    protected function _getStylesheet()
    {
        return $this->mRoot->mContext->mModuleConfig['css_file'];
    }

    /**
     * setHeaderScript
     * 
     * @param   void
     * 
     * @return  void
    **/
    public function setHeaderScript()
    {
        $headerScript = $this->mRoot->mContext->getAttribute('headerScript');
        $headerScript->addScript($this->_getDatePickerScript());
        $headerScript->addStylesheet($this->_getStylesheet());
    }

    /**
     * prepare
     * 
     * @param   void
     * 
     * @return  bool
    **/
    public function prepare()
    {
        return true;
    }

    /**
     * hasPermission
     * 
     * @param   void
     * 
     * @return  bool
    **/
    public function hasPermission()
    {
        return true;
    }

    /**
     * getDefaultView
     * 
     * @param   void
     * 
     * @return  Enum
    **/
    public function getDefaultView()
    {
        return XUPDATEMASTER_FRAME_VIEW_NONE;
    }

    /**
     * execute
     * 
     * @param   void
     * 
     * @return  Enum
    **/
    public function execute()
    {
        return XUPDATEMASTER_FRAME_VIEW_NONE;
    }

    /**
     * executeViewSuccess
     * 
     * @param   XCube_RenderTarget  &$render
     * 
     * @return  void
    **/
    public function executeViewSuccess(/*** XCube_RenderTarget ***/ &$render)
    {
    }

    /**
     * executeViewError
     * 
     * @param   XCube_RenderTarget  &$render
     * 
     * @return  void
    **/
    public function executeViewError(/*** XCube_RenderTarget ***/ &$render)
    {
    }

    /**
     * executeViewIndex
     * 
     * @param   XCube_RenderTarget  &$render
     * 
     * @return  void
    **/
    public function executeViewIndex(/*** XCube_RenderTarget ***/ &$render)
    {
    }

    /**
     * executeViewInput
     * 
     * @param   XCube_RenderTarget  &$render
     * 
     * @return  void
    **/
    public function executeViewInput(/*** XCube_RenderTarget ***/ &$render)
    {
    }

    /**
     * executeViewPreview
     * 
     * @param   XCube_RenderTarget  &$render
     * 
     * @return  void
    **/
    public function executeViewPreview(/*** XCube_RenderTarget ***/ &$render)
    {
    }

    /**
     * executeViewCancel
     * 
     * @param   XCube_RenderTarget  &$render
     * 
     * @return  void
    **/
    public function executeViewCancel(/*** XCube_RenderTarget ***/ &$render)
    {
    }

    /**
     * _getNextUri
     * 
     * @param   void
     * 
     * @return  string
    **/
    protected function _getNextUri($tableName, $actionName=null)
    {
        $handler = $this->_getHandler();
        if($this->mObject && $this->mObject->get($handler->mPrimary)>0){
            return Legacy_Utils::renderUri($this->mAsset->mDirname, $tableName, $this->mObject->get($handler->mPrimary), $actionName);
        }
        else{
            return Legacy_Utils::renderUri($this->mAsset->mDirname, $tableName, 0, $actionName);
        }
    }
    
    protected function checkJsonCache() {
    	$mydirname = $this->mAsset->mDirname;
    	$jsontime = XOOPS_ROOT_PATH . '/uploads/' . $mydirname . '/json.time';
    	if (@ filemtime($jsontime) + $this->jsonCacheTTL < time()) {
    		$userHandler =& xoops_gethandler('user');
    		$mid = $this->mModule->mXoopsModule->get('mid');
    		$sObjects =& $this->sHandler->getObjects(null,null,null,true);
    		$data = array();
    		$_isAdmin = $this->isAdmin;
    		foreach($sObjects as $sObj) {
    			$uid = $sObj->get('uid');
    			$user =& $userHandler->get($uid);
    			$this->isAdmin = $user->isAdmin($mid);
    			$this->setItem($sObj, false, $uid);
    			$user = null;
    		}
    		$this->isAdmin = $_isAdmin;
    		$this->makeJsonCache();
    		touch($jsontime);
    	}
    }
    
    protected function getItem($sObj) {
    	$sid = $sObj->get('store_id');
    	$criteria = new CriteriaCompo();
    	$criteria->add(new Criteria('store_id', $sid));
    	$criteria->setSort('title');
    	$criteria->setOrder('ASC');
    	$iObj = $this->iHandler->getObjects($criteria);
    	return $iObj;
    }
    
    protected function setItem($sObj, $makeCache = true, $uid = null) {
    	$url = $sObj->get('addon_url');
    	$data = $this->UrlGetContents($url);
    	if ($data === false) {
    		return;
    	}
    	if (preg_match('/\bjson\b/i', $url)) {
    		$ini = @ json_decode($data, true);
    	} else {
    		$ini = @ parse_ini_string($data, true);
    	}
    	$iObjs = $this->getItem($sObj);
    	$exists = array();
    	foreach ($iObjs as $id => $obj) {
    		$target_key = $obj->get('target_key');
    		$exists[$target_key] = $obj;
    	}
    	if ($ini) {
    		if (is_null($uid)) {
    			$uid = is_object($this->mRoot->mContext->mXoopsUser)? $this->mRoot->mContext->mXoopsUser->get('uid') : 0;
    		}
    		$isPackage = ($sObj->get('contents') == 3);
    		$noStrReg = '/[^#a-zA-Z0-9_-]$/';
    		$urlReg = '#^https?://#i';
    		foreach ($ini as $item) {
    			if (preg_match($noStrReg, @$item['dirname']) || preg_match($noStrReg, @$item['target_key'])) continue;
    			if ($isPackage) {
    				$item['addon_url'] = $this->_getAddonUrl(substr($item['dirname'], 1), $item['target_key']);
    			} else {
    				if (! preg_match($urlReg, @$item['addon_url']) ) continue;
    			}
    			if (isset($exists[$item['target_key']])) {
    				$iobj = $exists[$item['target_key']];
    				$addon_url = $iobj->get('addon_url');
    				unset($exists[$item['target_key']]);
    				$tagChange = false;
// @Todo tag support
//    				$iobj->loadTag();
//    				if (isset($item['tag'])) {
//   					if ($tags = explode(' ', trim($item['tag']))) {
//  						if ($newTag = array_diff($tags, $iobj->mTag)) {
//    							$iobj->mTag = array_merge($iobj->mTag, $newTag);
//    							$tagChange = true;
//    						}
//    					}
//    				}
    				if ( ! $tagChange
    					&& $item['dirname']    === $iobj->get('title')
    					&& $item['addon_url']  === $iobj->get('addon_url')
    					&& (empty($item['category']) || $item['category'] == $iobj->get('category_id'))
    				) {
    					unset($iobj);
    					continue;
    				}
    				$iobj->unsetNew();
    				$iobj->assignVar('title', $item['dirname']);
    				$iobj->assignVar('category_id', $this->_getCategoryIdByIni($item, $iobj->get('category_id')));
   					$iobj->assignVar('addon_url', $item['addon_url']);
   					if (! $isPackage) {
	    				if ($item['target_key'] !== $iobj->get('target_key') || $item['addon_url']  !== $iobj->get('addon_url')) {
	    					$iobj->assignVar('approval', $this->isAdmin? 1 : 0);
	    				}
    				} else {
    					$iobj->assignVar('approval', 0);
    				}
    			} else {
    				$iobj = new $this->iHandler->mClass();
    				$iobj->setNew();
    				$iobj->assignVar('title', $item['dirname']);
    				$iobj->assignVar('target_key', $item['target_key']);
    				$iobj->assignVar('uid', $uid);
    				$iobj->assignVar('store_id', $sObj->get('store_id'));
    				$iobj->assignVar('category_id', $this->_getCategoryIdByIni($item));
    				$iobj->assignVar('addon_url', $item['addon_url']);
    				if (! $isPackage) {
	    				$iobj->assignVar('approval', $this->isAdmin? 1 : 0);
    				} else {
    					$iobj->assignVar('approval', 0);
    				}
    			}
    			$this->iHandler->insert($iobj ,true);
    			unset($iobj);
    		}
    	}
    	if ($exists) {
    		foreach($exists as $obj) {
    			$this->iHandler->delete($obj, true);
    		}
    	}
    	if ($makeCache) {
    		$this->makeJsonCache();
    	}
    }
    
    private function _getCategoryIdByIni($ini, $savedId = null) {
    	$category_id = $savedId ? $savedId : $this->mModuleConfig['default_catid'];
    	if (! empty($ini['category']) && is_numeric($ini['category'])) {
    		if ($this->mAccessController['main']->check($ini['category'], Xupdatemaster_AbstractAccessController::POST, 'item')) {
    			$category_id = (int)$ini['category'];
    		}
    	}
    	return $category_id;
    }
    
    private function _getAddonUrl($sid, $target_key) {
    	$criteria = new CriteriaCompo();
    	$criteria->add(new Criteria('store_id', $sid));
    	$criteria->add(new Criteria('target_key', $target_key));
    	if ($iobj = $this->iHandler->getObjects($criteria)) {
    		return str_replace('%s', $iobj[0]->get('target_key'), $iobj[0]->get('addon_url'));
    	} else {
    		return '';
    	}
    	
    }
    
    protected function makeJsonCache() {
    	$sObjects =& $this->sHandler->getObjects(null,null,null,true);
    	$data = array();
    	foreach($sObjects as $sObj) {
    		$iObj = $this->getItem($sObj);
    		$items = array();
    		$i = 1;
    		foreach ($iObj as $item) {
    			$items[$i]['target_key'] = $item->get('target_key');
    			$items[$i]['category_id'] = $item->get('category_id');
    			$items[$i++]['approved'] = $item->get('approval')? true : false;
    		}
    		$sid = $sObj->get('store_id');
    		$data[$sid] = array(
    				'sid' => $sid,
    				'name' => $sObj->get('title'),
    				'contents' => $sObj->getContentsName(),
    				'setting_type' => 'ini',
    				'addon_url' => $sObj->get('addon_url'),
    				'items' => $items
    		);
    	}
    	
    	// non version
    	$_data = json_encode($data);
    	file_put_contents(sprintf($this->jsonCacheFile, ''), $_data);
    	
    	// V1
    	$this->_setupAccessController('item');
    	$tree = $this->mAccessController['main']->getTree('view');
    	$categories = array();
    	foreach($tree as $obj) {
    		$categories[$obj->get('cat_id')] = $obj->get('title');
    	}
    	$_data = json_encode(array('stores' => $data, 'categories' => $categories));
    	file_put_contents(sprintf($this->jsonCacheFile, '_V1'), $_data);
    }
    
	protected function UrlGetContents($url) {
		if (! function_exists('curl_init')) {
			die('xupdatestore require cUrl extention.');
		}
		$data = '';
		if ($ch= curl_init()) {
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$data = curl_exec($ch);
			$rc = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if ($rc != 200 && $rc != 404) {
				$data = false;
			}
			curl_close($ch);
		}
		return $data;
	}
}
