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

require_once XUPDATEMASTER_TRUST_PATH . '/class/AbstractFilterForm.class.php';

define('XUPDATEMASTER_STORE_SORT_KEY_STORE_ID', 1);
define('XUPDATEMASTER_STORE_SORT_KEY_TITLE', 2);
define('XUPDATEMASTER_STORE_SORT_KEY_CONTENTS', 3);
define('XUPDATEMASTER_STORE_SORT_KEY_ADDON_URL', 4);
define('XUPDATEMASTER_STORE_SORT_KEY_POSTTIME', 5);

define('XUPDATEMASTER_STORE_SORT_KEY_DEFAULT', XUPDATEMASTER_STORE_SORT_KEY_STORE_ID);

/**
 * Xupdatemaster_StoreFilterForm
**/
class Xupdatemaster_StoreFilterForm extends Xupdatemaster_AbstractFilterForm
{
    public /*** string[] ***/ $mSortKeys = array(
 	   XUPDATEMASTER_STORE_SORT_KEY_STORE_ID => 'store_id',
 	   XUPDATEMASTER_STORE_SORT_KEY_TITLE => 'title',
 	   XUPDATEMASTER_STORE_SORT_KEY_CONTENTS => 'contents',
 	   XUPDATEMASTER_STORE_SORT_KEY_ADDON_URL => 'addon_url',
 	   XUPDATEMASTER_STORE_SORT_KEY_POSTTIME => 'posttime',

    );

    /**
     * getDefaultSortKey
     * 
     * @param   void
     * 
     * @return  void
    **/
    public function getDefaultSortKey()
    {
        return XUPDATEMASTER_STORE_SORT_KEY_DEFAULT;
    }

    /**
     * fetch
     * 
     * @param   void
     * 
     * @return  void
    **/
    public function fetch()
    {
        parent::fetch();
    
        $root =& XCube_Root::getSingleton();
    
		if (($value = $root->mContext->mRequest->getRequest('store_id')) !== null) {
			$this->mNavi->addExtra('store_id', $value);
			$this->_mCriteria->add(new Criteria('store_id', $value));
		}
		if (($value = $root->mContext->mRequest->getRequest('title')) !== null) {
			$this->mNavi->addExtra('title', $value);
			$this->_mCriteria->add(new Criteria('title', $value));
		}
		if (($value = $root->mContext->mRequest->getRequest('contents')) !== null) {
			$this->mNavi->addExtra('contents', $value);
			$this->_mCriteria->add(new Criteria('contents', $value));
		}
		if (($value = $root->mContext->mRequest->getRequest('addon_url')) !== null) {
			$this->mNavi->addExtra('addon_url', $value);
			$this->_mCriteria->add(new Criteria('addon_url', $value));
		}
		if (($value = $root->mContext->mRequest->getRequest('posttime')) !== null) {
			$this->mNavi->addExtra('posttime', $value);
			$this->_mCriteria->add(new Criteria('posttime', $value));
		}

    
        $this->_mCriteria->addSort($this->getSort(), $this->getOrder());
    }
}

?>
