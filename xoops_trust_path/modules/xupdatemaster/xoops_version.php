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

//
// Define a basic manifesto.
//
$modversion['name'] = $myDirName;
$modversion['version'] = 0.01;
$modversion['description'] = _MI_XUPDATEMASTER_DESC_XUPDATEMASTER;
$modversion['author'] = _MI_XUPDATEMASTER_LANG_AUTHOR;
$modversion['credits'] = _MI_XUPDATEMASTER_LANG_CREDITS;
$modversion['help'] = 'help.html';
$modversion['license'] = 'GPL';
$modversion['official'] = 0;
$modversion['image'] = 'images/module_icon.png';
$modversion['dirname'] = $myDirName;
$modversion['trust_dirname'] = 'xupdatemaster';

$modversion['cube_style'] = true;
$modversion['legacy_installer'] = array(
    'installer'   => array(
        'class'     => 'Installer',
        'namespace' => 'Xupdatemaster',
        'filepath'  => XUPDATEMASTER_TRUST_PATH . '/admin/class/installer/XupdatemasterInstaller.class.php'
    ),
    'uninstaller' => array(
        'class'     => 'Uninstaller',
        'namespace' => 'Xupdatemaster',
        'filepath'  => XUPDATEMASTER_TRUST_PATH . '/admin/class/installer/XupdatemasterUninstaller.class.php'
    ),
    'updater' => array(
        'class'     => 'Updater',
        'namespace' => 'Xupdatemaster',
        'filepath'  => XUPDATEMASTER_TRUST_PATH . '/admin/class/installer/XupdatemasterUpdater.class.php'
    )
);
$modversion['disable_legacy_2nd_installer'] = false;

$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'] = array(
//    '{prefix}_{dirname}_xxxx',
##[cubson:tables]
    '{prefix}_{dirname}_store',
    '{prefix}_{dirname}_item',

##[/cubson:tables]
);

//
// Templates. You must never change [cubson] chunk to get the help of cubson.
//
$modversion['templates'] = array(
/*
    array(
        'file'        => '{dirname}_xxx.html',
        'description' => _MI_XUPDATEMASTER_TPL_XXX
    ),
*/
##[cubson:templates]
        array('file' => '{dirname}_store_delete.html','description' => _MI_XUPDATEMASTER_TPL_STORE_DELETE),
        array('file' => '{dirname}_store_edit.html','description' => _MI_XUPDATEMASTER_TPL_STORE_EDIT),
        array('file' => '{dirname}_store_list.html','description' => _MI_XUPDATEMASTER_TPL_STORE_LIST),
        array('file' => '{dirname}_store_view.html','description' => _MI_XUPDATEMASTER_TPL_STORE_VIEW),
        array('file' => '{dirname}_item_delete.html','description' => _MI_XUPDATEMASTER_TPL_ITEM_DELETE),
        array('file' => '{dirname}_item_edit.html','description' => _MI_XUPDATEMASTER_TPL_ITEM_EDIT),
        array('file' => '{dirname}_item_list.html','description' => _MI_XUPDATEMASTER_TPL_ITEM_LIST),
        array('file' => '{dirname}_item_view.html','description' => _MI_XUPDATEMASTER_TPL_ITEM_VIEW),
        array('file' => '{dirname}_item_inc.html','description' => _MI_XUPDATEMASTER_TPL_ITEM_INC),

##[/cubson:templates]
);

//
// Admin panel setting
//
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = 'admin/index.php?action=Index';
$modversion['adminmenu'] = array(
/*
    array(
        'title'    => _MI_XUPDATEMASTER_LANG_XXXX,
        'link'     => 'admin/index.php?action=xxx',
        'keywords' => _MI_XUPDATEMASTER_KEYWORD_XXX,
        'show'     => true,
        'absolute' => false
    ),
*/
##[cubson:adminmenu]
##[/cubson:adminmenu]
);

//
// Public side control setting
//
$modversion['hasMain'] = 1;
$modversion['hasSearch'] = 0;
$modversion['sub'] = array(
/*
    array(
        'name' => _MI_XUPDATEMASTER_LANG_SUB_XXX,
        'url'  => 'index.php?action=XXX'
    ),
*/
##[cubson:submenu]
##[/cubson:submenu]
);

//
// Config setting
//
$modversion['config'] = array(
/*
    array(
        'name'          => 'xxxx',
        'title'         => '_MI_XUPDATEMASTER_TITLE_XXXX',
        'description'   => '_MI_XUPDATEMASTER_DESC_XXXX',
        'formtype'      => 'xxxx',
        'valuetype'     => 'xxx',
        'options'       => array(xxx => xxx,xxx => xxx),
        'default'       => 0
    ),
*/

	array(
		'name'			=> 'access_controller',
		'title' 		=> '_MI_XUPDATEMASTER_LANG_ACCESS_CONTROLLER',
		'description'	=> '_MI_XUPDATEMASTER_DESC_ACCESS_CONTROLLER',
		'formtype'		=> 'server_module',
		'valuetype' 	=> 'text',
		'default'		=> '',
		'options'		=> array('none', 'cat', 'group')
	),
	array(
		'name'			=> 'auth_type' ,
		'title' 		=> "_MI_XUPDATEMASTER_LANG_AUTH_TYPE" ,
		'description'	=> "_MI_XUPDATEMASTER_DESC_AUTH_TYPE" ,
		'formtype'		=> 'textbox' ,
		'valuetype' 	=> 'text' ,
		'default'		=> 'viewer|poster|manager' ,
		'options'		=> array()
	) ,

	array(
		'name'			=> 'default_catid' ,
		'title'			=> '_MI_XUPDATEMASTER_LANG_DEF_CATID',
		'description'	=> '_MI_XUPDATEMASTER_DESC_DEF_CATID',
		'formtype'		=> 'textbox',
		'valuetype'		=> 'int',
		'default'		=> '0',
		'options'		=> array()
	) ,

    array(
        'name'          => 'tag_dirname' ,
        'title'         => '_MI_XUPDATEMASTER_LANG_TAG_DIRNAME' ,
        'description'   => '_MI_XUPDATEMASTER_DESC_TAG_DIRNAME' ,
        'formtype'      => 'server_module',
        'valuetype'     => 'text',
        'default'       => '',
        'options'       => array('none','tag')
    ) ,
                    
    array(
        'name'          => 'css_file' ,
        'title'         => "_MI_XUPDATEMASTER_LANG_CSS_FILE" ,
        'description'   => "_MI_XUPDATEMASTER_DESC_CSS_FILE" ,
        'formtype'      => 'textbox' ,
        'valuetype'     => 'text' ,
        'default'       => '/modules/'.$myDirName.'/style.css',
        'options'       => array()
    ) ,
##[cubson:config]
##[/cubson:config]
);

//
// Block setting
//
$modversion['blocks'] = array(
/*
    x => array(
        'func_num'          => x,
        'file'              => 'xxxBlock.class.php',
        'class'             => 'xxx',
        'name'              => _MI_XUPDATEMASTER_BLOCK_NAME_xxx,
        'description'       => _MI_XUPDATEMASTER_BLOCK_DESC_xxx,
        'options'           => '',
        'template'          => '{dirname}_block_xxx.html',
        'show_all_module'   => true,
        'visible_any'       => true
    ),
*/
##[cubson:block]
##[/cubson:block]
);

?>
