<?php

/***************************************************************************
 *
 * Constants needed for running tests
 *
 ***************************************************************************/

defined('UNITTEST_ROOT')    || define('UNITTEST_ROOT', __DIR__);
defined('DOCUMENT_ROOT')    || define('DOCUMENT_ROOT', __DIR__."../../../");
defined('VENDOR_ROOT')      || define('VENDOR_ROOT', __DIR__."../../../vendor");

/***************************************************************************
 *
 * Autoloader for vendor code and newer cc code
 *
 ***************************************************************************/
 
require_once VENDOR_ROOT.'/autoload.php';
