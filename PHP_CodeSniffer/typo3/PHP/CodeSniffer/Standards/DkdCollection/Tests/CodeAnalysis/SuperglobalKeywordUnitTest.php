<?php
/**
 * Unit test class for DeprecatedFunctionsSniff.
 *
 * @package PHP_CodeSniffer
 * @subpackage DkdCollection
 * @author Christian Trabold <christian.trabold@dkd.de>
 * @author Christoph Gerold <christoph.gerold@dkd.de>
 * @version $Id$
 * @link http://pear.php.net/package/PHP_CodeSniffer
 */
class DkdCollection_Tests_CodeAnalysis_SuperglobalKeywordUnitTest extends AbstractSniffUnitTest {

	/**
	 * Returns the lines where errors should occur.
	 *
	 * The key of the array should represent the line number and the value
	 * should represent the number of errors that should occur on that line.
	 *
	 * @return array(int => int)
	 */
	public function getErrorList() {
		$superglobalErrors = array();
		$superglobalErrors = array_fill(6,5,1);
		
		return $superglobalErrors;
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
		$superglobalWarnings = array();
		$superglobalWarnings = array_fill(11,3,1);
		
		return $superglobalWarnings;
	}//end getWarningList()

}//end class

?>