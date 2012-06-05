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

interface Xupdatemaster_AuthType
{
    const VIEW = "view";
    const POST = "post";
    const MANAGE = "manage";
}

?>
