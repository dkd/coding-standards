<?php
/**
 * Generic_Sniffs_PHP_ForbiddenFunctionsSniff.
 *
 * Discourages the use of deprecated functions that are kept in PHP for
 * compatibility with older versions.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @subpackage DkdCollection
 * @author Christian Trabold <christian.trabold@dkd.de>
 * @author Christoph Gerold <christoph.gerold@dkd.de>
 * @version $Id$
 * @link http://pear.php.net/package/PHP_CodeSniffer
 */
class DkdCollection_Sniffs_CodeAnalysis_ForbiddenFunctionsSniff extends Generic_Sniffs_PHP_ForbiddenFunctionsSniff {

	/**
	 * A list of forbidden functions with their alternatives.
	 *
	 * The value is NULL if no alternative exists. IE, the
	 * function should just not be used.
	 *
	 * @var array(string => string|null)
	 */
	protected $forbiddenFunctions = array(
									'mysql_query' =>'$GLOBALS[\'TYPO3_DB\']-> exec_INSERTquery or exec_UPDATEquery or exec_DELETEquery or exec_SELECTquery',
									'mysql_affected_rows' => 'Use TYPO3 wrapper function @t3lib_DB Class Reference',
									'mysql_client_encoding' => 'Use TYPO3 wrapper function @t3lib_DB Class Reference',
									'mysql_close' => 'Use TYPO3 wrapper function @t3lib_DB Class Reference',
									'mysql_connect' => 'Use TYPO3 wrapper function @t3lib_DB Class Reference',
									'mysql_create_db' => 'Use TYPO3 wrapper function @t3lib_DB Class Reference',
									'mysql_data_seek' => 'Use TYPO3 wrapper function @t3lib_DB Class Reference',
									'mysql_db_name' => 'Use TYPO3 wrapper function @t3lib_DB Class Reference',
									'mysql_db_query' => 'Use TYPO3 wrapper function @t3lib_DB Class Reference',
									'mysql_drop_db' => 'Use TYPO3 wrapper function @t3lib_DB Class Reference',
									'mysql_errno' => 'Use TYPO3 wrapper function @t3lib_DB Class Reference',
									'mysql_error' => 'Use TYPO3 wrapper function @t3lib_DB Class Reference',
									'mysql_escape_string' => 'Use TYPO3 wrapper function @t3lib_DB Class Reference',
									'mysql_fetch_array' => 'Use TYPO3 wrapper function @t3lib_DB Class Reference',
									'mysql_fetch_assoc' => 'Use TYPO3 wrapper function @t3lib_DB Class Reference',
									'mysql_fetch_field' => 'Use TYPO3 wrapper function @t3lib_DB Class Reference',
									'mysql_fetch_lengths' => 'Use TYPO3 wrapper function @t3lib_DB Class Reference',
									'mysql_fetch_object' => 'Use TYPO3 wrapper function @t3lib_DB Class Reference',
									'mysql_fetch_row' => 'Use TYPO3 wrapper function @t3lib_DB Class Reference',
									'mysql_field_flags' => 'Use TYPO3 wrapper function @t3lib_DB Class Reference',
									'mysql_field_len' => 'Use TYPO3 wrapper function @t3lib_DB Class Reference',
									'mysql_field_name' => 'Use TYPO3 wrapper function @t3lib_DB Class Reference',
									'mysql_field_seek' => 'Use TYPO3 wrapper function @t3lib_DB Class Reference',
									'mysql_field_table' => 'Use TYPO3 wrapper function @t3lib_DB Class Reference',
									'mysql_field_type' => 'Use TYPO3 wrapper function @t3lib_DB Class Reference',
									'mysql_free_result' => 'Use TYPO3 wrapper function @t3lib_DB Class Reference',
									'mysql_get_client_info' => 'Use TYPO3 wrapper function @t3lib_DB Class Reference',
									'mysql_get_host_info' => 'Use TYPO3 wrapper function @t3lib_DB Class Reference',
									'mysql_get_proto_info' => 'Use TYPO3 wrapper function @t3lib_DB Class Reference',
									'mysql_get_server_info' => 'Use TYPO3 wrapper function @t3lib_DB Class Reference',
									'mysql_info' => 'Use TYPO3 wrapper function @t3lib_DB Class Reference',
									'mysql_insert_id' => 'Use TYPO3 wrapper function @t3lib_DB Class Reference',
									'mysql_list_dbs' => 'Use TYPO3 wrapper function @t3lib_DB Class Reference',
									'mysql_list_fields' => 'Use TYPO3 wrapper function @t3lib_DB Class Reference',
									'mysql_list_processes' => 'Use TYPO3 wrapper function @t3lib_DB Class Reference',
									'mysql_list_tables' => 'Use TYPO3 wrapper function @t3lib_DB Class Reference',
									'mysql_num_fields' => 'Use TYPO3 wrapper function @t3lib_DB Class Reference',
									'mysql_num_rows' => 'Use TYPO3 wrapper function @t3lib_DB Class Reference',
									'mysql_pconnect' => 'Use TYPO3 wrapper function @t3lib_DB Class Reference',
									'mysql_ping' => 'Use TYPO3 wrapper function @t3lib_DB Class Reference',
									'mysql_query' => 'Use TYPO3 wrapper function @t3lib_DB Class Reference',
									'mysql_real_escape_string' => 'Use TYPO3 wrapper function @t3lib_DB Class Reference',
									'mysql_result' => 'Use TYPO3 wrapper function @t3lib_DB Class Reference',
									'mysql_select_db' => 'Use TYPO3 wrapper function @t3lib_DB Class Reference',
									'mysql_set_charset' => 'Use TYPO3 wrapper function @t3lib_DB Class Reference',
									'mysql_stat' => 'Use TYPO3 wrapper function @t3lib_DB Class Reference',
									'mysql_tablename' => 'Use TYPO3 wrapper function @t3lib_DB Class Reference',
									'mysql_thread_id' => 'Use TYPO3 wrapper function @t3lib_DB Class Reference',
									'mysql_unbuffered_query' => 'Use TYPO3 wrapper function @t3lib_DB Class Reference',
									);
}//end class

?>