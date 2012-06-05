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
 * Xupdatemaster_ItemDeleteForm
**/
class Xupdatemaster_ItemDeleteForm extends XCube_ActionForm
{
    /**
     * getTokenName
     * 
     * @param   void
     * 
     * @return  string
    **/
    public function getTokenName()
    {
        return "module.xupdatemaster.ItemDeleteForm.TOKEN";
    }

    /**
     * prepare
     * 
     * @param   void
     * 
     * @return  void
    **/
    public function prepare()
    {
        //
        // Set form properties
        //
        $this->mFormProperties['item_id'] = new XCube_IntProperty('item_id');
    
        //
        // Set field properties
        //
        $this->mFieldProperties['item_id'] = new XCube_FieldProperty($this);
        $this->mFieldProperties['item_id']->setDependsByArray(array('required'));
        $this->mFieldProperties['item_id']->addMessage('required', _MD_XUPDATEMASTER_ERROR_REQUIRED, _MD_XUPDATEMASTER_LANG_ITEM_ID);
    }

    /**
     * load
     * 
     * @param   XoopsSimpleObject  &$obj
     * 
     * @return  void
    **/
    public function load(/*** XoopsSimpleObject ***/ &$obj)
    {
        $this->set('item_id', $obj->get('item_id'));
    }

    /**
     * update
     * 
     * @param   XoopsSimpleObject  &$obj
     * 
     * @return  void
    **/
    public function update(/*** XoopsSimpleObject ***/ &$obj)
    {
        $obj->set('item_id', $this->get('item_id'));
    }
}

?>
