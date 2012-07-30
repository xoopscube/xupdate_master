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

require_once XUPDATEMASTER_TRUST_PATH . '/class/AbstractEditAction.class.php';

/**
 * Xupdatemaster_ItemEditAction
**/
class Xupdatemaster_ItemEditAction extends Xupdatemaster_AbstractEditAction
{
    const DATANAME = 'item';


	/**
	 * _getCatId
	 * 
	 * @param	void
	 * 
	 * @return	int
	**/
	protected function _getCatId()
	{
		return ($this->mObject->get('category_id')) ? $this->mObject->get('category_id') : intval($this->mRoot->mContext->mRequest->getRequest('category_id'));
	}

	/**
	 * hasPermission
	 * 
	 * @param	void
	 * 
	 * @return	bool
	**/
	public function hasPermission()
	{
		$catId = $this->_getCatId();
	
		if($catId>0){
			//is Manager ?
			$check = $this->mAccessController['main']->check($catId, Xupdatemaster_AbstractAccessController::MANAGE, 'item');
			if($check==true){
				return true;
			}
// 			//is new post and has post permission ?
// 			$check = $this->mAccessController['main']->check($catId, Xupdatemaster_AbstractAccessController::POST, 'item');
// 			if($check==true && $this->mObject->isNew()){
// 				return true;
// 			}
// 			//is old post and your post ?
// 			if($check==true && ! $this->mObject->isNew() && $this->mObject->get('uid')==Legacy_Utils::getUid() && $this->mObject->get('uid')>0){
// 				return true;
// 			}
		}
		else{
// 			$idList = array();
// 			$idList = $this->mAccessController['main']->getPermittedIdList(Xupdatemaster_AbstractAccessController::POST, $this->_getCatId());
// 			if(count($idList)>0 || $this->mAccessController['main']->getAccessControllerType()=='none'){
			if ($this->isAdmin) {
				return true;
			}
		}
	
		return false;
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
        parent::prepare();
        if($this->mObject->isNew()){
			if($this->mRoot->mContext->mUser->isInRole('Site.RegisteredUser')){
				$this->mObject->set('uid', $this->mRoot->mContext->mXoopsUser->get('uid'));
			}
			$this->mObject->set('category_id', $this->_getCatId());
        }
		$this->_setupAccessController('item');
		// load tags for form element
		$this->mObject->loadTag();
     return true;
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
        $render->setTemplateName($this->mAsset->mDirname . '_item_edit.html');
        $render->setAttribute('actionForm', $this->mActionForm);
        $render->setAttribute('object', $this->mObject);
        $render->setAttribute('dirname', $this->mAsset->mDirname);
        $render->setAttribute('dataname', self::DATANAME);

        //set tag usage
        $render->setAttribute('tag_dirname', $this->mRoot->mContext->mModuleConfig['tag_dirname']);
        
		$render->setAttribute('accessController',$this->mAccessController['main']);
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
		//$this->mRoot->mController->executeForward($this->_getNextUri($this->_getConst('DATANAME')));
		$this->mRoot->mController->executeForward(XOOPS_URL.'/modules/xupdatemaster/index.php?action=ItemList&store_id='.$this->mObject->get('store_id'));
	}


	/**
	 * executeViewCancel
	 *
	 * @param	XCube_RenderTarget	&$render
	 *
	 * @return	void
	 **/
	public function executeViewCancel(/*** XCube_RenderTarget ***/ &$render)
	{
		$this->mRoot->mController->executeForward('./index.php?action=ItemList&store_id='.$this->mObject->get('store_id'));
	}

	/**
	 * _doExecute
	 *
	 * @param   void
	 *
	 * @return  Enum
	 **/
	protected function _doExecute()
	{
		if($this->mObjectHandler->insert($this->mObject))
		{
			$this->makeJsonCache();
			return XUPDATEMASTER_FRAME_VIEW_SUCCESS;
		}
	
		return XUPDATEMASTER_FRAME_VIEW_ERROR;
	}
}
?>
