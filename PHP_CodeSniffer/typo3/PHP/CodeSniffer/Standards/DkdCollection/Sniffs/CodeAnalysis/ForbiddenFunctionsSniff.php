<?php
/**
 * DkdCollection_Sniffs_CodeAnalysis_ForbiddenFunctionsSniff.
 *
 * Discourages the use of forbidden functions that are kept in PHP for
 * compatibility with older versions.
 *
 * @category PHP
 * @package PHP_CodeSniffer
 * @subpackage DkdCollection
 * @author Christian Trabold <christian.trabold@dkd.de>
 * @author Christoph Gerold <christoph.gerold@dkd.de>
 * @version $Id$
 * @link http://pear.php.net/package/PHP_CodeSniffer
 */
class DkdCollection_Sniffs_CodeAnalysis_ForbiddenFunctionsSniff extends Generic_Sniffs_PHP_ForbiddenFunctionsSniff {
	/**
	 * If true, forbidden functions will be considered regular expressions.
	 *
	 * @var bool
	 */
	protected $patternMatch = true;

	/**
	 * A list of forbidden functions with their alternatives.
	 *
	 * The value is NULL if no alternative exists. IE, the
	 * function should just not be used.
	 *
	 * @var array(string => string|null)
	 */
	protected $forbiddenFunctions = array(
		'mysql_' =>'Use TYPO3 wrapper function @t3lib_DB Class Reference',
	);
}
?>