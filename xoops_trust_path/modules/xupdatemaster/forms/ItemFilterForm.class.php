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

define('XUPDATEMASTER_ITEM_SORT_KEY_ITEM_ID', 1);
define('XUPDATEMASTER_ITEM_SORT_KEY_TITLE', 2);
define('XUPDATEMASTER_ITEM_SORT_KEY_STORE_ID', 3);
define('XUPDATEMASTER_ITEM_SORT_KEY_UID', 4);
define('XUPDATEMASTER_ITEM_SORT_KEY_CATEGORY_ID', 5);
define('XUPDATEMASTER_ITEM_SORT_KEY_TARGET_KEY', 6);
define('XUPDATEMASTER_ITEM_SORT_KEY_APPROVAL', 7);
define('XUPDATEMASTER_ITEM_SORT_KEY_POSTTIME', 8);

define('XUPDATEMASTER_ITEM_SORT_KEY_DEFAULT', XUPDATEMASTER_ITEM_SORT_KEY_ITEM_ID);

/**
 * Xupdatemaster_ItemFilterForm
**/
class Xupdatemaster_ItemFilterForm extends Xupdatemaster_AbstractFilterForm
{
    public /*** string[] ***/ $mSortKeys = array(
 	   XUPDATEMASTER_ITEM_SORT_KEY_ITEM_ID => 'item_id',
 	   XUPDATEMASTER_ITEM_SORT_KEY_TITLE => 'title',
 	   XUPDATEMASTER_ITEM_SORT_KEY_STORE_ID => 'store_id',
 	   XUPDATEMASTER_ITEM_SORT_KEY_UID => 'uid',
 	   XUPDATEMASTER_ITEM_SORT_KEY_CATEGORY_ID => 'category_id',
 	   XUPDATEMASTER_ITEM_SORT_KEY_TARGET_KEY => 'target_key',
 	   XUPDATEMASTER_ITEM_SORT_KEY_APPROVAL => 'approval',
 	   XUPDATEMASTER_ITEM_SORT_KEY_POSTTIME => 'posttime',

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
        return XUPDATEMASTER_ITEM_SORT_KEY_DEFAULT;
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
    
		if (($value = $root->mContext->mRequest->getRequest('item_id')) !== null) {
			$this->mNavi->addExtra('item_id', $value);
			$this->_mCriteria->add(new Criteria('item_id', $value));
		}
		if (($value = $root->mContext->mRequest->getRequest('title')) !== null) {
			$this->mNavi->addExtra('title', $value);
			$this->_mCriteria->add(new Criteria('title', $value));
		}
		if (($value = $root->mContext->mRequest->getRequest('store_id')) !== null) {
			$this->mNavi->addExtra('store_id', $value);
			$this->_mCriteria->add(new Criteria('store_id', $value));
		}
		if (($value = $root->mContext->mRequest->getRequest('uid')) !== null) {
			$this->mNavi->addExtra('uid', $value);
			$this->_mCriteria->add(new Criteria('uid', $value));
		}
		if (($value = $root->mContext->mRequest->getRequest('category_id')) !== null) {
			$this->mNavi->addExtra('category_id', $value);
			$this->_mCriteria->add(new Criteria('category_id', $value));
		}
		if (($value = $root->mContext->mRequest->getRequest('target_key')) !== null) {
			$this->mNavi->addExtra('target_key', $value);
			$this->_mCriteria->add(new Criteria('target_key', $value));
		}
		if (($value = $root->mContext->mRequest->getRequest('approval')) !== null) {
			$this->mNavi->addExtra('approval', $value);
			$this->_mCriteria->add(new Criteria('approval', $value));
		}
		if (($value = $root->mContext->mRequest->getRequest('posttime')) !== null) {
			$this->mNavi->addExtra('posttime', $value);
			$this->_mCriteria->add(new Criteria('posttime', $value));
		}

    
        $this->_mCriteria->addSort($this->getSort(), $this->getOrder());
    }
}

?>
