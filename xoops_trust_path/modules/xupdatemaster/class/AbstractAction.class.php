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

    public /*** Xupdatemaster_AssetManager ***/ $mAsset = null;

    public $mAccessController = array();

    protected $sHandler;
    protected $iHandler;
    protected $isAdmin;
    protected $contents_name = array(
    		0 => 'disabled',
    		1 => 'module',
    		2 => 'theme' );
    
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
        $this->mAsset =& $this->mModule->mAssetManager;
        $this->sHandler =& $this->mAsset->getObject('handler', 'store', false);
        $this->iHandler =& $this->mAsset->getObject('handler', 'item', false);
        $this->isAdmin = $this->mRoot->mContext->mUser->isInRole('Module.'.$this->mAsset->mDirname.'.Admin');
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
    
    
    protected function getItem($sObj) {
    	$sid = $sObj->get('store_id');
    	$criteria = new CriteriaCompo();
    	$criteria->add(new Criteria('store_id', $sid));
    	$iObj = $this->iHandler->getObjects($criteria);
    	return $iObj;
    }
    
    protected function setItem($sObj) {
    	$url = $sObj->get('addon_url');
    	//if ($sObj->get('setting_type') === 0) {
    		$ini = @ parse_ini_string(@file_get_contents($url), true);
    	//} else {
    	//	$ini = @ json_decode(@file_get_contents($url), true);
    	//}
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
    				$content_id = $exists[$item['target_key']]->get('content_id');
    				$addon_url = $exists[$item['target_key']]->get('addon_url');
    				unset($exists[$item['target_key']]);
    				if ($item['addon_url'] === $addon_url) {
    					continue;
    				}
    				$iobj = $this->iHandler->get($item_id);
    				$iobj->unsetNew();
    				$iobj->assignVar('addon_url', $item['addon_url']);
    			} else {
    				$iobj = new $this->iHandler->mClass();
    				$iobj->setNew();
    				$iobj->assignVar('title', $item['dirname']);
    				$iobj->assignVar('target_key', $item['target_key']);
    				$iobj->assignVar('store_id', $this->mObject->get('store_id'));
    				$iobj->assignVar('approval', $this->isAdmin? 1 : 0);
    				$iobj->assignVar('addon_url', $item['addon_url']);
    				$iobj->assignVar('uid', $uid);
    			}
    			if ($this->iHandler->insert($iobj ,true)) {
    				//echo('<pre>');var_dump($iobj);
    			}
    			//echo('<pre>');var_dump($iobj);
    		}
    	}
    	if ($exists) {
    		foreach($exists as $obj) {
    			$this->iHandler->delete($obj, true);
    		}
    	}
    	$this->makeJsonCache();
    }
    
    protected function makeJsonCache() {
    	$file = XOOPS_ROOT_PATH . '/uploads/'.$this->mAsset->mDirname.'/stores_json.txt';
    	$sObjects =& $this->sHandler->getObjects(null,null,null,true);
    	$data = array();
    	foreach($sObjects as $sObj) {
    		$iObj = $this->getItem($sObj);
    		$items = array();
    		$i = 1;
    		foreach ($iObj as $item) {
    			$items[$i]['target_key'] = $item->get('target_key');
    			$items[$i++]['approved'] = $item->get('approval')? true : false;
    		}
    		$sid = $sObj->get('store_id');
    		$data[$sid] = array(
    				'sid' => $sid,
    				'name' => $sObj->get('title'),
    				'contents' => $sObj->get('contents'),
    				'setting_type' => 'ini',
    				'addon_url' => $sObj->get('addon_url'),
    				'items' => $items
    		);
    	}
    	$data = json_encode($data);
    	file_put_contents($file, $data);
    }
}

?>
