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

require_once XUPDATEMASTER_TRUST_PATH . '/class/AbstractDeleteAction.class.php';

/**
 * Xupdatemaster_ItemDeleteAction
**/
class Xupdatemaster_ItemDeleteAction extends Xupdatemaster_AbstractDeleteAction
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
		return $this->mObject->get('category_id');
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
	 * @param	void
	 * 
	 * @return	bool
	**/
	public function prepare()
	{
		parent::prepare();
		$this->_setupAccessController('item');

		return true;
	}

	/**
	 * executeViewInput
	 * 
	 * @param	XCube_RenderTarget	&$render
	 * 
	 * @return	void
	**/
	public function executeViewInput(/*** XCube_RenderTarget ***/ &$render)
	{
		$render->setTemplateName($this->mAsset->mDirname . '_item_delete.html');
		$render->setAttribute('actionForm', $this->mActionForm);
		$render->setAttribute('object', $this->mObject);
		$render->setAttribute('accessController', $this->mAccessController['main']);
	}
}

?>
