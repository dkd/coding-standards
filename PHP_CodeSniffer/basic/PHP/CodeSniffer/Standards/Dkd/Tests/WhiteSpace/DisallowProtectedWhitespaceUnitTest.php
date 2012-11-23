<?php
/**
 * Unit test class for the DisallowProtectedWhitespace sniff.
 *
 * @package PHP_CodeSniffer
 * @subpackage Dkd
 * @author Timo Webler <timo.webler@dkd.de>
 * @version $Id$
 * @link http://pear.php.net/package/PHP_CodeSniffer
 */

/**
 * Unit test class for the DisallowProtectedWhitespace sniff.
 *
 * A sniff unit test checks a .inc file for expected violations of a single
 * coding standard. Expected errors and warnings are stored in this class.
 *
 * @package PHP_CodeSniffer
 * @subpackage Dkd
 * @author Timo Webler <timo.webler@dkd.de>
 * @version $Id$
 * @link http://pear.php.net/package/PHP_CodeSniffer
 */
class Dkd_Tests_WhiteSpace_DisallowProtectedWhitespaceUnitTest extends AbstractSniffUnitTest {


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
			'2' => 1,
			'4' => 1,
			'6' => 1,
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
		return array();

	}//end getWarningList()


}//end class

?>
