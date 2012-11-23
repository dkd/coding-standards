<?php

// fault
define('DkdCollection_test',1);

require_once(PATH_tslib . 'test.php');


TYPO3_OS;
TYPO3_MODE;
PATH_thisScript;
TYPO3_mainDir;
PATH_TYPO3;
PATH_TYPO3_mod;
PATH_site;
PATH_t3lib;
PATH_tslib;
PATH_TYPO3conf;
TYPO3_db;
TYPO3_db_username;
TYPO3_db_password;
TYPO3_db_host;
TYPO3_tables_script;
TYPO3_extTableDef_script;
TYPO3_languages;
TYPO3_DLOG;
TYPO3_MOD_PATH;
TYPO3_enterInstallScript;
TYPO3_PROCEED_IF_NO_USER;
TYPO3_cliMode;
TYPO3_version;

// fault
TYPO3_test;

list ($host, $port) = t3lib_div::trimExplode(':', TYPO3_db_host);
$config = array(
	'dbname' => TYPO3_db,
	'username' => TYPO3_db_username,
	'password' => TYPO3_db_password,
	'host' => $host,
);

/**
 * FE-Plugin für DWH-Info GUI
 *
 * @package	TYPO3
 * @subpackage	tx_tcdwhinfo
 * @author	Nils Dehl <nils.dehl@dkd.de>
 * @version	$Id$
 */

require_once(PATH_tslib . 'class.tslib_pibase.php');
?>