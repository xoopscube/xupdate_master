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
 * Xupdatemaster_StoreListAction
**/
class Xupdatemaster_StoreListAction extends Xupdatemaster_AbstractListAction
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
	 * executeViewIndex
	 * 
	 * @param	XCube_RenderTarget	&$render
	 * 
	 * @return	void
	**/
	public function executeViewIndex(/*** XCube_RenderTarget ***/ &$render)
	{
		if ($this->mRoot->mContext->mRequest->getRequest('checkjson')) {
			$this->checkJsonCache();
			while( ob_get_level() && @ ob_end_clean() ){}
			header('Content-type: image/gif');
			header('Last-Modified: '.gmdate( 'D, d M Y H:i:s' ).' GMT');
			header('pragma: no-cache');
			header('Cache-Control: no-cache, must-revalidate');
			header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
			readfile(XOOPS_ROOT_PATH . '/modules/' . $this->mAsset->mDirname . '/images/blank.gif');
			exit();
		}
		$render->setTemplateName($this->mAsset->mDirname . '_store_list.html');
		$render->setAttribute('objects', $this->mObjects);
		$render->setAttribute('dirname', $this->mAsset->mDirname);
		$render->setAttribute('dataname', self::DATANAME);
		$render->setAttribute('pageNavi', $this->mFilter->mNavi);
	}
}

?>
