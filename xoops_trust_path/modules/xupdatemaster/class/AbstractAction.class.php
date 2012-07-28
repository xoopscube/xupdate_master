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
        $this->jsonCacheFile = XOOPS_ROOT_PATH . '/uploads/' . $this->mAsset->mDirname . '/stores_json.txt';
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
    	$jsontime = XOOPS_ROOT_PATH . '/uploads/' . $this->mAsset->mDirname . '/json.time';
    	if (@ filemtime($jsontime) + $this->jsonCacheTTL < time()) {
    		$sObjects =& $this->sHandler->getObjects(null,null,null,true);
    		$data = array();
    		foreach($sObjects as $sObj) {
    			$this->setItem($sObj, false);
    		}
    		$this->makeJsonCache();
    		touch($jsontime);
    	}
    }
    
    protected function getItem($sObj) {
    	$sid = $sObj->get('store_id');
    	$criteria = new CriteriaCompo();
    	$criteria->add(new Criteria('store_id', $sid));
    	$iObj = $this->iHandler->getObjects($criteria);
    	return $iObj;
    }
    
    protected function setItem($sObj, $makeCache = true) {
    	$url = $sObj->get('addon_url');
    	if (preg_match('/\bjson\b/i', $url)) {
    		$ini = @ json_decode($this->UrlGetContents($url), true);
    	} else {
    		$ini = @ parse_ini_string($this->UrlGetContents($url), true);
    	}
    	$iObj = $this->getItem($sObj);
    	$exists = array();
    	foreach ($iObj as $id => $obj) {
    		$target_key = $obj->get('target_key');
    		$exists[$target_key] = $obj;
    	}
    	 
    	if ($ini) {
    		$uid = $this->mRoot->mContext->mXoopsUser->get('uid');
    		foreach ($ini as $item) {
    			if (isset($exists[$item['target_key']])) {
    				$oObj = $exists[$item['target_key']];
    				$addon_url = $oObj->get('addon_url');
    				unset($exists[$item['target_key']]);
    				if (   $item['dirname']    === $oObj->get('title')
    					&& $item['target_key'] === $oObj->get('target_key')
    					&& $item['addon_url']  === $oObj->get('addon_url')
    					&& ((empty($item['category'])? $this->mModuleConfig['default_catid'] : $item['category']) == $oObj->get('category_id')) ) {
    					continue;
    				}
    				$iobj = $this->iHandler->get($oObj->get('item_id'));
    				$iobj->unsetNew();
    				$iobj->assignVar('title', $item['dirname']);
    				$iobj->assignVar('target_key', $item['target_key']);
    				$iobj->assignVar('addon_url', $item['addon_url']);
    				$iobj->assignVar('category_id', $this->_getCategoryIdByIni($item, $oObj->get('category_id')));
    			} else {
    				$iobj = new $this->iHandler->mClass();
    				$iobj->setNew();
    				$iobj->assignVar('title', $item['dirname']);
    				$iobj->assignVar('target_key', $item['target_key']);
    				$iobj->assignVar('store_id', $sObj->get('store_id'));
    				$iobj->assignVar('approval', $this->isAdmin? 1 : 0);
    				$iobj->assignVar('addon_url', $item['addon_url']);
    				$iobj->assignVar('uid', $uid);
    				$iobj->assignVar('category_id', $this->_getCategoryIdByIni($item));
    			}
    			$this->iHandler->insert($iobj ,true);
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
    	$data = json_encode($data);
    	file_put_contents($this->jsonCacheFile, $data);
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
			curl_close($ch);
		}
		return $data;
	}
}

?>
