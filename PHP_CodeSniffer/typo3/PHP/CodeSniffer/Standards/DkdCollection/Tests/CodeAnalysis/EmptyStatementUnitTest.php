<?php
/**
 * Unit test class for FunctionCommentSniff.
 *
 * @package PHP_CodeSniffer
 * @subpackage DkdCollection
 * @author Timo Webler <timo.webler@dkd.de>
 * @version $Id$
 * @link http://pear.php.net/package/PHP_CodeSniffer
 */

/**
 * Unit test class for FunctionCommentSniff.
 *
 * @package PHP_CodeSniffer
 * @subpackage DkdCollection
 * @author Timo Webler <timo.webler@dkd.de>
 * @version $Id$
 * @link http://pear.php.net/package/PHP_CodeSniffer
 */
class DkdCollection_Tests_CodeAnalysis_EmptyStatementUnitTest extends AbstractSniffUnitTest {


	/**
	 * Returns the lines where errors should occur.
	 *
	 * The key of the array should represent the line number and the value
	 * should represent the number of errors that should occur on that line.
	 *
	 * @return array(int => int)
	 */
	public function getErrorList() {
		return array(
			2 => 1,
			9 => 1,
			13 => 1,
			15 => 1,
			19 => 1,
			21 => 1,
			25 => 1,
			27 => 1,
			32 => 1,
			36 => 1
		);

	}//end getErrorList()


	/**
	 * Returns the lines where warnings should occur.
	 *
	 * The key of the array should represent the line number and the value
	 * should represent the number of warnings that should occur on that line.
	 *
	 * @return array(int => int)
	 */
	public function getWarningList() {
		return array(
			5 => 1
		);

	}//end getWarningList()


}//end class

?>
