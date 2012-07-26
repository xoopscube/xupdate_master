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
 * Xupdatemaster_StoreEditAction
**/
class Xupdatemaster_StoreEditAction extends Xupdatemaster_AbstractEditAction
{
    const DATANAME = 'store';


	/**
	 * hasPermission
	 * 
	 * @param	void
	 * 
	 * @return	bool
	**/
	public function hasPermission()
	{
		return $this->mRoot->mContext->mUser->isInRole('Site.RegisteredUser') ? true : false;
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
    	if($this->mRoot->mContext->mUser->isInRole('Site.RegisteredUser')){
			$uid = $this->mRoot->mContext->mXoopsUser->get('uid');
			if($this->mObject->isNew()){
				$this->mObject->set('uid', $uid);
			} else if (!$this->isAdmin && $uid != $this->mObject->get('uid')) {
				return false;
			}
    	}
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
    	$render->setTemplateName($this->mAsset->mDirname . '_store_edit.html');
        $render->setAttribute('actionForm', $this->mActionForm);
        $render->setAttribute('object', $this->mObject);
        $render->setAttribute('dirname', $this->mAsset->mDirname);
        $render->setAttribute('dataname', self::DATANAME);

        //set tag usage
        $render->setAttribute('tag_dirname', $this->mRoot->mContext->mModuleConfig['tag_dirname']);
        
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
  		$this->setItem($this->mObject);
  		return XUPDATEMASTER_FRAME_VIEW_SUCCESS;
  	}
  
  	return XUPDATEMASTER_FRAME_VIEW_ERROR;
  }
}
?>
