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
 * Xupdatemaster_ItemEditForm
**/
class Xupdatemaster_ItemEditForm extends XCube_ActionForm
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
		return "module.xupdatemaster.ItemEditForm.TOKEN";
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
        $this->mFormProperties['item_id'] = new XCube_IntProperty('item_id');
        $this->mFormProperties['title'] = new XCube_StringProperty('title');
        $this->mFormProperties['store_id'] = new XCube_IntProperty('store_id');
        $this->mFormProperties['uid'] = new XCube_IntProperty('uid');
        $this->mFormProperties['category_id'] = new XCube_IntProperty('category_id');
        $this->mFormProperties['target_key'] = new XCube_StringProperty('target_key');
        $this->mFormProperties['approval'] = new XCube_IntProperty('approval');
        $this->mFormProperties['posttime'] = new XCube_IntProperty('posttime');
        $this->mFormProperties['tags'] = new XCube_TextProperty('tags');

	
		//
		// Set field properties
		//
       $this->mFieldProperties['item_id'] = new XCube_FieldProperty($this);
$this->mFieldProperties['item_id']->setDependsByArray(array('required'));
$this->mFieldProperties['item_id']->addMessage('required', _MD_XUPDATEMASTER_ERROR_REQUIRED, _MD_XUPDATEMASTER_LANG_ITEM_ID);
       $this->mFieldProperties['title'] = new XCube_FieldProperty($this);
        $this->mFieldProperties['title']->setDependsByArray(array('required','maxlength'));
        $this->mFieldProperties['title']->addMessage('required', _MD_XUPDATEMASTER_ERROR_REQUIRED, _MD_XUPDATEMASTER_LANG_TITLE);
        $this->mFieldProperties['title']->addMessage('maxlength', _MD_XUPDATEMASTER_ERROR_MAXLENGTH, _MD_XUPDATEMASTER_LANG_TITLE, '255');
        $this->mFieldProperties['title']->addVar('maxlength', '255');
       $this->mFieldProperties['store_id'] = new XCube_FieldProperty($this);
$this->mFieldProperties['store_id']->setDependsByArray(array('required'));
$this->mFieldProperties['store_id']->addMessage('required', _MD_XUPDATEMASTER_ERROR_REQUIRED, _MD_XUPDATEMASTER_LANG_STORE_ID);
        $this->mFieldProperties['uid'] = new XCube_FieldProperty($this);
       $this->mFieldProperties['category_id'] = new XCube_FieldProperty($this);
$this->mFieldProperties['category_id']->setDependsByArray(array('required'));
$this->mFieldProperties['category_id']->addMessage('required', _MD_XUPDATEMASTER_ERROR_REQUIRED, _MD_XUPDATEMASTER_LANG_CATEGORY_ID);
       $this->mFieldProperties['target_key'] = new XCube_FieldProperty($this);
        $this->mFieldProperties['target_key']->setDependsByArray(array('required','maxlength'));
        $this->mFieldProperties['target_key']->addMessage('required', _MD_XUPDATEMASTER_ERROR_REQUIRED, _MD_XUPDATEMASTER_LANG_TARGET_KEY);
        $this->mFieldProperties['target_key']->addMessage('maxlength', _MD_XUPDATEMASTER_ERROR_MAXLENGTH, _MD_XUPDATEMASTER_LANG_TARGET_KEY, '60');
        $this->mFieldProperties['target_key']->addVar('maxlength', '60');
       $this->mFieldProperties['approval'] = new XCube_FieldProperty($this);
$this->mFieldProperties['approval']->setDependsByArray(array('required'));
$this->mFieldProperties['approval']->addMessage('required', _MD_XUPDATEMASTER_ERROR_REQUIRED, _MD_XUPDATEMASTER_LANG_APPROVAL);
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
        $this->set('item_id', $obj->get('item_id'));
        $this->set('title', $obj->get('title'));
        $this->set('store_id', $obj->get('store_id'));
        $this->set('uid', $obj->get('uid'));
        $this->set('category_id', $obj->get('category_id'));
        $this->set('target_key', $obj->get('target_key'));
        $this->set('approval', $obj->get('approval'));
        $this->set('posttime', $obj->get('posttime'));
      $tags = is_array($obj->mTag) ? implode(' ', $obj->mTag) : null;
        if(count($obj->mTag)>0) $tags = $tags.' ';
        $this->set('tags', $tags);
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
        $obj->set('store_id', $this->get('store_id'));
        $obj->set('category_id', $this->get('category_id'));
        $obj->set('target_key', $this->get('target_key'));
        $obj->set('approval', $this->get('approval'));
        $obj->mTag = explode(' ', trim($this->get('tags')));
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
