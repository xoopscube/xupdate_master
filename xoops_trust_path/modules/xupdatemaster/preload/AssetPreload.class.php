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

if(!defined('XUPDATEMASTER_TRUST_PATH'))
{
    define('XUPDATEMASTER_TRUST_PATH',XOOPS_TRUST_PATH . '/modules/xupdatemaster');
}

require_once XUPDATEMASTER_TRUST_PATH . '/class/XupdatemasterUtils.class.php';
require_once XUPDATEMASTER_TRUST_PATH . '/class/Enum.class.php';
/**
 * Xupdatemaster_AssetPreloadBase
**/
class Xupdatemaster_AssetPreloadBase extends XCube_ActionFilter
{
    public $mDirname = null;

    /**
     * prepare
     * 
     * @param   string  $dirname
     * 
     * @return  void
    **/
    public static function prepare(/*** string ***/ $dirname)
    {
        static $setupCompleted = false;
        if(!$setupCompleted)
        {
            $setupCompleted = self::_setup($dirname);
        }
    }

    /**
     * _setup
     * 
     * @param   void
     * 
     * @return  bool
    **/
    public static function _setup(/*** string ***/ $dirname)
    {
        $root =& XCube_Root::getSingleton();
        $instance = new self($root->mController);
        $instance->mDirname = $dirname;
        $root->mController->addActionFilter($instance);
        return true;
    }

    /**
     * preBlockFilter
     * 
     * @param   void
     * 
     * @return  void
    **/
    public function preBlockFilter()
    {
        $file = XUPDATEMASTER_TRUST_PATH . '/class/callback/DelegateFunctions.class.php';
        $this->mRoot->mDelegateManager->add('Module.xupdatemaster.Global.Event.GetAssetManager','Xupdatemaster_AssetPreloadBase::getManager');
        $this->mRoot->mDelegateManager->add('Legacy_Utils.CreateModule','Xupdatemaster_AssetPreloadBase::getModule');
        $this->mRoot->mDelegateManager->add('Legacy_Utils.CreateBlockProcedure','Xupdatemaster_AssetPreloadBase::getBlock');
        $this->mRoot->mDelegateManager->add('Module.'.$this->mDirname.'.Global.Event.GetNormalUri','Xupdatemaster_CoolUriDelegate::getNormalUri', $file);

        $this->mRoot->mDelegateManager->add('Legacy_CategoryClient.GetClientList','Xupdatemaster_CatClientDelegate::getClientList', XUPDATEMASTER_TRUST_PATH.'/class/callback/AccessClient.class.php');
        $this->mRoot->mDelegateManager->add('Legacy_CategoryClient.'.$this->mDirname.'.GetClientData','Xupdatemaster_CatClientDelegate::getClientData', XUPDATEMASTER_TRUST_PATH.'/class/callback/AccessClient.class.php');
        //Group Client
        $this->mRoot->mDelegateManager->add('Legacy_GroupClient.GetClientList','Xupdatemaster_GroupClientDelegate::getClientList', XUPDATEMASTER_TRUST_PATH.'/class/callback/AccessClient.class.php');
        $this->mRoot->mDelegateManager->add('Legacy_GroupClient.'.$this->mDirname.'.GetClientData','Xupdatemaster_GroupClientDelegate::getClientData', XUPDATEMASTER_TRUST_PATH.'/class/callback/AccessClient.class.php');
        $this->mRoot->mDelegateManager->add('Legacy_GroupClient.GetActionList','Xupdatemaster_GroupClientDelegate::getActionList', XUPDATEMASTER_TRUST_PATH.'/class/callback/AccessClient.class.php');
        $this->mRoot->mDelegateManager->add('Legacy_TagClient.GetClientList','Xupdatemaster_TagClientDelegate::getClientList', XUPDATEMASTER_TRUST_PATH.'/class/callback/TagClient.class.php');
        $this->mRoot->mDelegateManager->add('Legacy_TagClient.'.$this->mDirname.'.GetClientData','Xupdatemaster_TagClientDelegate::getClientData', XUPDATEMASTER_TRUST_PATH.'/class/callback/TagClient.class.php');  }

    /**
     * getManager
     * 
     * @param   Xupdatemaster_AssetManager  &$obj
     * @param   string  $dirname
     * 
     * @return  void
    **/
    public static function getManager(/*** Xupdatemaster_AssetManager ***/ &$obj,/*** string ***/ $dirname)
    {
        require_once XUPDATEMASTER_TRUST_PATH . '/class/AssetManager.class.php';
        $obj = Xupdatemaster_AssetManager::getInstance($dirname);
    }

    /**
     * getModule
     * 
     * @param   Legacy_AbstractModule  &$obj
     * @param   XoopsModule  $module
     * 
     * @return  void
    **/
    public static function getModule(/*** Legacy_AbstractModule ***/ &$obj,/*** XoopsModule ***/ $module)
    {
        if($module->getInfo('trust_dirname') == 'xupdatemaster')
        {
            require_once XUPDATEMASTER_TRUST_PATH . '/class/Module.class.php';
            $obj = new Xupdatemaster_Module($module);
        }
    }

    /**
     * getBlock
     * 
     * @param   Legacy_AbstractBlockProcedure  &$obj
     * @param   XoopsBlock  $block
     * 
     * @return  void
    **/
    public static function getBlock(/*** Legacy_AbstractBlockProcedure ***/ &$obj,/*** XoopsBlock ***/ $block)
    {
        $moduleHandler =& Xupdatemaster_Utils::getXoopsHandler('module');
        $module =& $moduleHandler->get($block->get('mid'));
        if(is_object($module) && $module->getInfo('trust_dirname') == 'xupdatemaster')
        {
            require_once XUPDATEMASTER_TRUST_PATH . '/blocks/' . $block->get('func_file');
            $className = 'Xupdatemaster_' . substr($block->get('show_func'), 4);
            $obj = new $className($block);
        }
    }
}

?>
