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

require_once XUPDATEMASTER_TRUST_PATH . '/class/AbstractViewAction.class.php';

/**
 * Xupdatemaster_ItemViewAction
**/
class Xupdatemaster_ItemViewAction extends Xupdatemaster_AbstractViewAction
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
	
		return $this->mObject ? $this->mObject->get('category_id') : null ;
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
		return $this->mAccessController['main']->check($this->_getCatId(), Xupdatemaster_AbstractAccessController::VIEW, 'xupdatemaster');
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
	 * executeViewSuccess
	 * 
	 * @param	XCube_RenderTarget	&$render
	 * 
	 * @return	void
	**/
	public function executeViewSuccess(/*** XCube_RenderTarget ***/ &$render)
	{
		$render->setTemplateName($this->mAsset->mDirname . '_item_view.html');
		$render->setAttribute('object', $this->mObject);
		$render->setAttribute('dirname', $this->mAsset->mDirname);
		$render->setAttribute('dataname', self::DATANAME);
		$render->setAttribute('accessController', $this->mAccessController['main']);
		$render->setAttribute('mainTitle', $this->mAccessController['main']->getTitle($this->mObject->get('category_id')));
	}
}

?>
