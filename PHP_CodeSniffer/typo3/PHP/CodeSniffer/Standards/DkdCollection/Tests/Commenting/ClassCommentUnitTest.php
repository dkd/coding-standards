<?php
/**
 * Unit test class for ClassCommentSniff.
 *
 * @package PHP_CodeSniffer
 * @subpackage DkdCollection
 * @author Timo Webler <timo.webler@dkd.de>
 * @version $Id$
 * @link http://pear.php.net/package/PHP_CodeSniffer
 */

/**
 * Unit test class for ClassCommentSniff.
 *
 * @package PHP_CodeSniffer
 * @subpackage DkdCollection
 * @author Timo Webler <timo.webler@dkd.de>
 * @version $Id$
 * @link http://pear.php.net/package/PHP_CodeSniffer
 */
class DkdCollection_Tests_Commenting_ClassCommentUnitTest extends AbstractSniffUnitTest {


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
			4 => 1,
			14 => 1,
			20 => 1,
			38 => 1,
			56 => 1,
			65 => 1,
			74 => 1
		 );

	}//end getErrorList()


	/**
	 * Returns the lines where warnings should occur.
	 * The key of the array should represent the line number and the value
	 * should represent the number of warnings that should occur on that line.
	 *
	 * @return array(int => int)
	 */
	public function getWarningList() {
		return array();

	}//end getWarningList()


}//end class

?>
