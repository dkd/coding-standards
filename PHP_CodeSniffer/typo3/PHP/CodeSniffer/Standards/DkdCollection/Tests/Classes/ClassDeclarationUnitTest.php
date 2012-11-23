<?php
/**
 * Unit test class for the ClassDeclaration sniff.
 *
 * @category PHP
 * @package PHP_CodeSniffer
 * @author Timo Webler <timo.webler@dkd.de>

 */

/**
 * Unit test class for the ClassDeclaration sniff.
 *
 * A sniff unit test checks a .inc file for expected violations of a single
 * coding standard. Expected errors and warnings are stored in this class.
 *
 * @category PHP
 * @package PHP_CodeSniffer
 * @author Timo Webler <timo.webler@dkd.de>
 */
class DkdCollection_Tests_Classes_ClassDeclarationUnitTest extends AbstractSniffUnitTest {


	/**
	 * Returns the lines where errors should occur.
	 * The key of the array should represent the line number and the value
	 * should represent the number of errors that should occur on that line.
	 *
	 * @return array(int => int)
	 */
	public function getErrorList() {
		return array(
			19 => 1,
			21 => 1,
			23 => 1,
			26 => 1,
			30 => 1,
			34 => 1,
			38 => 1,
			62 => 1,
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