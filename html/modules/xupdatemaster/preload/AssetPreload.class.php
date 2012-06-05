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

require_once XOOPS_TRUST_PATH . '/modules/xupdatemaster/preload/AssetPreload.class.php';
Xupdatemaster_AssetPreloadBase::prepare(basename(dirname(dirname(__FILE__))));

?>
