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
				$key = $obj->get('item_id');
				if (isset($apps[$key])) {
					if (! $obj->get('approval')) {
						$obj->assignVar('approval', true);
						$this->iHandler->insert($obj ,true);
						$change = true;
					}
				} else {
					if ($obj->get('approval')) {
						$obj->assignVar('approval', false);
						$this->iHandler->insert($obj ,true);
						$change = true;
					}
				}
			}
			if ($change) {
				$this->makeJsonCache();
			}
		}
		
		$render->setTemplateName($this->mAsset->mDirname . '_store_view.html');
		$render->setAttribute('object', $this->mObject);
		$render->setAttribute('item', $this->getItem($this->mObject));
		$render->setAttribute('dirname', $this->mAsset->mDirname);
		$render->setAttribute('dataname', self::DATANAME);
		$render->setAttribute('isAdmin', $this->isAdmin);
	}
}

?>
