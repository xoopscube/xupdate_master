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

/**
 * Xupdatemaster_ItemObject
**/
class Xupdatemaster_ItemObject extends Legacy_AbstractObject
{
    const PRIMARY = 'item_id';
    const DATANAME = 'item';
    public $mParentList = array('store');

    /**
     * __construct
     * 
     * @param   void
     * 
     * @return  void
    **/
    public function __construct()
    {
        parent::__construct();  
        $this->initVar('item_id', XOBJ_DTYPE_INT, '', false);
        $this->initVar('title', XOBJ_DTYPE_STRING, '', false, 255);
        $this->initVar('store_id', XOBJ_DTYPE_INT, '', false);
        $this->initVar('uid', XOBJ_DTYPE_INT, '', false);
        $this->initVar('category_id', XOBJ_DTYPE_INT, '', false);
        $this->initVar('target_key', XOBJ_DTYPE_STRING, '', false, 60);
        $this->initVar('addon_url', XOBJ_DTYPE_STRING, '', false, 255);
        $this->initVar('approval', XOBJ_DTYPE_INT, '', false);
        $this->initVar('posttime', XOBJ_DTYPE_INT, time(), false);
   }

    /**
     * getShowStatus
     * 
     * @param   void
     * 
     * @return  string
    **/
    public function getShowStatus()
    {
        switch($this->get('status')){
            case Lenum_Status::DELETED:
                return _MD_LEGACY_STATUS_DELETED;
            case Lenum_Status::REJECTED:
                return _MD_LEGACY_STATUS_REJECTED;
            case Lenum_Status::POSTED:
                return _MD_LEGACY_STATUS_POSTED;
            case Lenum_Status::PUBLISHED:
                return _MD_LEGACY_STATUS_PUBLISHED;
        }
    }

	public function getImageNumber()
	{
		return 0;
	}

}

/**
 * Xupdatemaster_ItemHandler
**/
class Xupdatemaster_ItemHandler extends Legacy_AbstractClientObjectHandler
{
    public /*** string ***/ $mTable = '{dirname}_item';
    public /*** string ***/ $mPrimary = 'item_id';
    public /*** string ***/ $mClass = 'Xupdatemaster_ItemObject';

    /**
     * __construct
     * 
     * @param   XoopsDatabase  &$db
     * @param   string  $dirname
     * 
     * @return  void
    **/
    public function __construct(/*** XoopsDatabase ***/ &$db,/*** string ***/ $dirname)
    {
        $this->mTable = strtr($this->mTable,array('{dirname}' => $dirname));
        parent::XoopsObjectGenericHandler($db);
    }

	/**
	 * check if use Legacy_Activity
	 *
	 * @param mixed[]	$conf
	 *
	 * @return	bool
	 */
    protected function _isActivityClient(/*** mixed[] ***/ $conf)
    {
    	return false;
    }

}

?>
