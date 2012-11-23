<?php
/**
 * This file is part of the CodeAnalysis addon for PHP_CodeSniffer.
 *
 * PHP version 5
 *
 * @package PHP_CodeSniffer
 * @subpackage DkdCollection
 * @author Timo Webler <timo.webler@dkd.de>
 * @version $Id$
 * @link http://pear.php.net/package/PHP_CodeSniffer
 */

/**
 * This sniff class detected empty statement.
 *
 * This sniff implements the common algorithm for empty statement body detection.
 * A body is considered as empty if it is completely empty or it only contains
 * whitespace characters and|or comments.
 *
 * <code>
 * stmt {
 *   // foo
 * }
 * stmt (conditions) {
 *   // foo
 * }
 * </code>
 *
 * Statements covered by this sniff are <b>catch</b>, <b>do</b>, <b>else</b>,
 * <b>elsif</b>, <b>for</b>, <b>foreach<b>, <b>if</b>, <b>switch</b>, <b>try</b>
 * and <b>while</b>.
 *
 * @package PHP_CodeSniffer
 * @subpackage DkdCollection
 * @author Timo Webler <timo.webler@dkd.de>
 * @version $Id$
 * @link http://pear.php.net/package/PHP_CodeSniffer
 */
class DkdCollection_Sniffs_CodeAnalysis_EmptyStatementSniff extends Generic_Sniffs_CodeAnalysis_EmptyStatementSniff {

	/**
	 * List of block tokens that this sniff covers.
	 *
	 * The key of this hash identifies the required token while the boolean
	 * value says mark an error or mark a warning.
	 *
	 * @var array
	 */
	protected $checkedTokens = array(
		T_CATCH   => false,
		T_DO      => true,
		T_ELSE    => true,
		T_ELSEIF  => true,
		T_FOR     => true,
		T_FOREACH => true,
		T_IF      => true,
		T_SWITCH  => false,
		T_TRY     => true,
		T_WHILE   => true,
	);

}//end class

?>