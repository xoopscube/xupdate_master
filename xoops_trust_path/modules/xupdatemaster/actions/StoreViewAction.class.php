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
 * Xupdatemaster_StoreViewAction
**/
class Xupdatemaster_StoreViewAction extends Xupdatemaster_AbstractViewAction
{
	const DATANAME = 'store';



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
		if (strtolower($_SERVER['REQUEST_METHOD']) === 'post') {
			$req = $this->mRoot->mContext->mRequest;
			if (!$apps = $req->getRequest('approval')) {
				$apps = array();
			}
			$apps = array_flip($apps);
			$iObj = $this->getItem($this->mObject);
			$change = false;
			foreach($iObj as $obj) {
				$obj->unsetNew();
				$key = $obj->get('item_id');
				$category_id = (int)$req->getRequest('category_id_'.$key);
				if ($category_id != $obj->get('category_id')) {
					$obj->assignVar('category_id', $category_id);
					$obj->setNew();
				}
				if (isset($apps[$key])) {
					if (! $obj->get('approval')) {
						$obj->assignVar('approval', 1);
						$obj->setNew();
					}
				} else {
					if ($obj->get('approval')) {
						$obj->assignVar('approval', 0);
						$obj->setNew();
					}
				}
				if ($obj->isNew()) {
					$change = true;
					$obj->unsetNew();
					$this->iHandler->insert($obj ,false);
				}
			}
			if ($change) {
				$this->makeJsonCache();
			}
		}
		
		$render->setTemplateName($this->mAsset->mDirname . '_store_view.html');
		$render->setAttribute('object', $this->mObject);
		$render->setAttribute('isPackage', ($this->mObject->get('contents') == 3));
		$render->setAttribute('item', $this->getItem($this->mObject));
		$render->setAttribute('dirname', $this->mAsset->mDirname);
		$render->setAttribute('dataname', self::DATANAME);
		$render->setAttribute('isAdmin', $this->isAdmin);
		$render->setAttribute('accessController',Xupdatemaster_Utils::getAccessControllerObject($this->mAsset->mDirname, 'item'));
		
	}
}

?>
