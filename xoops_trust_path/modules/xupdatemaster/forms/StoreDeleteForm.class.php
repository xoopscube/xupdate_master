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
 * Xupdatemaster_StoreDeleteForm
**/
class Xupdatemaster_StoreDeleteForm extends XCube_ActionForm
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
        return "module.xupdatemaster.StoreDeleteForm.TOKEN";
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
        $this->mFormProperties['store_id'] = new XCube_IntProperty('store_id');
    
        //
        // Set field properties
        //
        $this->mFieldProperties['store_id'] = new XCube_FieldProperty($this);
        $this->mFieldProperties['store_id']->setDependsByArray(array('required'));
        $this->mFieldProperties['store_id']->addMessage('required', _MD_XUPDATEMASTER_ERROR_REQUIRED, _MD_XUPDATEMASTER_LANG_STORE_ID);
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
        $this->set('store_id', $obj->get('store_id'));
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
        $obj->set('store_id', $this->get('store_id'));
    }
}

?>
