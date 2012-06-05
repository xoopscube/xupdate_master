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

require_once XUPDATEMASTER_TRUST_PATH . '/class/AbstractListAction.class.php';

/**
 * Xupdatemaster_ItemListAction
**/
class Xupdatemaster_ItemListAction extends Xupdatemaster_AbstractListAction
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
		return intval($this->mRoot->mContext->mRequest->getRequest('category_id'));
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
		if($this->_getCatId() > 0){
			return $this->mAccessController['main']->check($this->_getCatId(), Xupdatemaster_AbstractAccessController::VIEW, 'xupdatemaster');
		}
		return true;
	}
	/**
	 * getDefaultView
	 * 
	 * @param	void
	 * 
	 * @return	Enum
	**/
	public function getDefaultView()
	{
		$this->mFilter =& $this->_getFilterForm();
		$this->mFilter->fetch();
	
		$handler =& $this->_getHandler();
		$criteria=$this->mFilter->getCriteria();
	
		$tree = array();
		if(! $this->_getCatId()){
			$catCriteria = new CriteriaCompo();
		
			//get permitted categories to show
			$idList = $this->mAccessController['main']->getPermittedIdList(Xupdatemaster_AbstractAccessController::VIEW, $this->_getCatId());
			if(count($idList)>0 && $this->mAccessController['main']->getAccessControllerType()!='none'){
				$catCriteria->add(new Criteria('category_id', $idList, 'IN'));
				$criteria->add($catCriteria);
			}
		}
		$this->mObjects = $handler->getObjects($criteria);
	
		return XUPDATEMASTER_FRAME_VIEW_INDEX;
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
	 * executeViewIndex
	 * 
	 * @param	XCube_RenderTarget	&$render
	 * 
	 * @return	void
	**/
	public function executeViewIndex(/*** XCube_RenderTarget ***/ &$render)
	{
		$render->setTemplateName($this->mAsset->mDirname . '_item_list.html');
		$render->setAttribute('objects', $this->mObjects);
		$render->setAttribute('dirname', $this->mAsset->mDirname);
		$render->setAttribute('dataname', self::DATANAME);
		$render->setAttribute('pageNavi', $this->mFilter->mNavi);
		$render->setAttribute('accessController', $this->mAccessController['main']);
		$render->setAttribute('mainTitleList', $this->mAccessController['main']->getTitleList());
	}
}

?>
