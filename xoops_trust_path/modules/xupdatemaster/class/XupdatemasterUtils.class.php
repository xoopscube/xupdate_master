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
 * Xupdatemaster_Utils
**/
class Xupdatemaster_Utils
{
    /**
     * getModuleConfig
     * 
     * @param   string  $name
     * @param   bool  $optional
     * 
     * @return  XoopsObjectHandler
    **/
    public static function getModuleConfig(/*** string ***/ $dirname, /*** mixed ***/ $key)
    {
    	$handler = self::getXoopsHandler('config');
    	$conf = $handler->getConfigsByDirname($dirname);
    	return (isset($conf[$key])) ? $conf[$key] : null;
    }

    /**
     * &getXoopsHandler
     * 
     * @param   string  $name
     * @param   bool  $optional
     * 
     * @return  XoopsObjectHandler
    **/
    public static function &getXoopsHandler(/*** string ***/ $name,/*** bool ***/ $optional = false)
    {
        // TODO will be emulated xoops_gethandler
        return xoops_gethandler($name,$optional);
    }

    /**
     * getPermittedIdList
     * 
     * @param   string  $dirname
     * @param   string  $action
     * @param   int     $categeoryId
     * 
     * @return  XoopsObjectHandler
    **/
    public static function getPermittedIdList(/*** string ***/ $dirname, /*** string ***/ $action=null, /*** int ***/ $categoryId=0)
    {
        $action = isset($action) ? $action : Xupdatemaster_AuthType::VIEW;
    
        $accessController = self::getAccessControllerModule($dirname);
    
        if(! is_object($accessController)) return;
    
        $role = $accessController->get('role');
        $idList = array();
        if($role=='cat'){
            $delegateName = 'Legacy_Category.'.$accessController->dirname().'.GetPermittedIdList';
            XCube_DelegateUtils::call($delegateName, new XCube_Ref($idList), $accessController->dirname(), self::getActor($dirname, Xupdatemaster_AuthType::VIEW), Legacy_Utils::getUid(), $categoryId);
        }
        elseif($role=='group'){
            $delegateName = 'Legacy_Group.'.$accessController->dirname().'.GetGroupIdListByAction';
            XCube_DelegateUtils::call($delegateName, new XCube_Ref($idList), $accessController->dirname(), $dirname, 'page', Xupdatemaster_AuthType::VIEW);
        }
        else{   //has user group permission ?
            ///TODO
        }
        return $idList;
    }

    /**
     * getAccessControllerModule
     * 
     * @param   string  $dirname
     * 
     * @return  XoopsModule
    **/
    public static function getAccessControllerModule(/*** string ***/ $dirname)
    {
        $handler = self::getXoopsHandler('module');
        return $handler->getByDirname(self::getModuleConfig($dirname, 'access_controller'));
    }

    /**
     * getAccessControllerObject
     * 
     * @param   string  $dirname
     * @param   string  $dataname
     * 
     * @return  Xupdatemaster_AbstractAccessController
    **/
	public static function getAccessControllerObject(/*** string ***/ $dirname, /*** string ***/ $dataname)
	{
		$server = self::getModuleConfig($dirname, 'access_controller');
	
		//get server's role
		$handler = self::getXoopsHandler('module');
		$module = $handler->getByDirname($server);
		if(! $module){
			require_once XUPDATEMASTER_TRUST_PATH . '/class/NoneAccessController.class.php';
			$accessController = new Xupdatemaster_NoneAccessController($server, $dirname, $dataname);
			return $accessController;
		}
		$role = $module->get('role');
	
		switch($role){
		case 'cat':
			require_once XUPDATEMASTER_TRUST_PATH . '/class/CatAccessController.class.php';
			$accessController = new Xupdatemaster_CatAccessController($server, $dirname, $dataname);
			break;
		case 'group':
			require_once XUPDATEMASTER_TRUST_PATH . '/class/GroupAccessController.class.php';
			$accessController = new Xupdatemaster_GroupAccessController($server, $dirname, $dataname);
			break;
		case 'none':
		default:
			require_once XUPDATEMASTER_TRUST_PATH . '/class/NoneAccessController.class.php';
			$accessController = new Xupdatemaster_NoneAccessController($server, $dirname, $dataname);
			break;
		}
		return $accessController;
	}

    /**
     * getActor
     * 
     * @param   string  $dirname
     * @param   string  $action
     * 
     * @return  string
    **/
    public static function getActor(/*** string ***/ $dirname, /*** string ***/ $action)
    {
        $authSetting = self::getModuleConfig($dirname, 'auth_type');
        $authType = isset($authSetting) ? explode('|', $authSetting) : array('viewer', 'poster', 'manager', 'manager');
        switch($action){
            case Xupdatemaster_AuthType::VIEW:
                return trim($authType[0]);
                break;
            case Xupdatemaster_AuthType::POST:
                return trim($authType[1]);
                break;
            case Xupdatemaster_AuthType::MANAGE:
                return trim($authType[3]);
                break;
        }
    }

    /**
     * getListCriteria
     * 
     * @param   string  $dirname
     * @param   int     $categoryId
     * @param   int     $order
     * @param   Lenum_Status    $status
     * 
     * @return  XoopsObjectHandler
    **/
    public static function getListCriteria(/*** string ***/ $dirname, /*** int ***/ $categoryId=null, /*** int ***/ $order=null, /*** int ***/ $status=Lenum_Status::PUBLISHED)
    {
        $accessController = self::getAccessControllerModule($dirname);
    
        $cri = new CriteriaCompo();
    
        //category
        if(isset($categoryId)){
            $cri->add(new Criteria('category_id', $categoryId));
        }
        else{
            //get permitted categories to show
            if($accessController instanceof XoopsModule && ($accessController->get('role')=='cat' || $accessController->get('role')=='group')){
                $idList = self::getPermittedIdList($dirname);
                if(count($idList)>0){
                    $cri->add(new Criteria('category_id', $idList, 'IN'));
                }
            }
        }
    
        return $cri;
    }
}

?>
