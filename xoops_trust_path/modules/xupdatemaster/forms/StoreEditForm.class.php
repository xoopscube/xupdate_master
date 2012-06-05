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

require_once XOOPS_ROOT_PATH . '/core/XCube_ActionForm.class.php';
require_once XOOPS_MODULE_PATH . '/legacy/class/Legacy_Validator.class.php';

/**
 * Xupdatemaster_StoreEditForm
**/
class Xupdatemaster_StoreEditForm extends XCube_ActionForm
{
	/**
	 * getTokenName
	 * 
	 * @param	void
	 * 
	 * @return	string
	**/
	public function getTokenName()
	{
		return "module.xupdatemaster.StoreEditForm.TOKEN";
	}

	/**
	 * prepare
	 * 
	 * @param	void
	 * 
	 * @return	void
	**/
	public function prepare()
	{
		//
		// Set form properties
		//
        $this->mFormProperties['store_id'] = new XCube_IntProperty('store_id');
        $this->mFormProperties['title'] = new XCube_StringProperty('title');
        $this->mFormProperties['contents'] = new XCube_StringProperty('contents');
        $this->mFormProperties['addon_url'] = new XCube_StringProperty('addon_url');
        $this->mFormProperties['posttime'] = new XCube_IntProperty('posttime');

	
		//
		// Set field properties
		//
       $this->mFieldProperties['store_id'] = new XCube_FieldProperty($this);
$this->mFieldProperties['store_id']->setDependsByArray(array('required'));
$this->mFieldProperties['store_id']->addMessage('required', _MD_XUPDATEMASTER_ERROR_REQUIRED, _MD_XUPDATEMASTER_LANG_STORE_ID);
       $this->mFieldProperties['title'] = new XCube_FieldProperty($this);
        $this->mFieldProperties['title']->setDependsByArray(array('required','maxlength'));
        $this->mFieldProperties['title']->addMessage('required', _MD_XUPDATEMASTER_ERROR_REQUIRED, _MD_XUPDATEMASTER_LANG_TITLE);
        $this->mFieldProperties['title']->addMessage('maxlength', _MD_XUPDATEMASTER_ERROR_MAXLENGTH, _MD_XUPDATEMASTER_LANG_TITLE, '255');
        $this->mFieldProperties['title']->addVar('maxlength', '255');
       $this->mFieldProperties['contents'] = new XCube_FieldProperty($this);
        $this->mFieldProperties['contents']->setDependsByArray(array('required','maxlength'));
        $this->mFieldProperties['contents']->addMessage('required', _MD_XUPDATEMASTER_ERROR_REQUIRED, _MD_XUPDATEMASTER_LANG_CONTENTS);
        $this->mFieldProperties['contents']->addMessage('maxlength', _MD_XUPDATEMASTER_ERROR_MAXLENGTH, _MD_XUPDATEMASTER_LANG_CONTENTS, '60');
        $this->mFieldProperties['contents']->addVar('maxlength', '60');
       $this->mFieldProperties['addon_url'] = new XCube_FieldProperty($this);
        $this->mFieldProperties['addon_url']->setDependsByArray(array('required','maxlength'));
        $this->mFieldProperties['addon_url']->addMessage('required', _MD_XUPDATEMASTER_ERROR_REQUIRED, _MD_XUPDATEMASTER_LANG_ADDON_URL);
        $this->mFieldProperties['addon_url']->addMessage('maxlength', _MD_XUPDATEMASTER_ERROR_MAXLENGTH, _MD_XUPDATEMASTER_LANG_ADDON_URL, '255');
        $this->mFieldProperties['addon_url']->addVar('maxlength', '255');
        $this->mFieldProperties['posttime'] = new XCube_FieldProperty($this);
	}

	/**
	 * load
	 * 
	 * @param	XoopsSimpleObject  &$obj
	 * 
	 * @return	void
	**/
	public function load(/*** XoopsSimpleObject ***/ &$obj)
	{
        $this->set('store_id', $obj->get('store_id'));
        $this->set('title', $obj->get('title'));
        $this->set('contents', $obj->get('contents'));
        $this->set('addon_url', $obj->get('addon_url'));
        $this->set('posttime', $obj->get('posttime'));
	}

	/**
	 * update
	 * 
	 * @param	XoopsSimpleObject  &$obj
	 * 
	 * @return	void
	**/
	public function update(/*** XoopsSimpleObject ***/ &$obj)
	{
        $obj->set('title', $this->get('title'));
        $obj->set('contents', $this->get('contents'));
        $obj->set('addon_url', $this->get('addon_url'));
	}

	/**
	 * _makeUnixtime
	 * 
	 * @param	string	$key
	 * 
	 * @return	void
	**/
	protected function _makeUnixtime($key)
	{
		$timeArray = explode('-', $this->get($key));
		return mktime(0, 0, 0, $timeArray[1], $timeArray[2], $timeArray[0]);
	}
}

?>
