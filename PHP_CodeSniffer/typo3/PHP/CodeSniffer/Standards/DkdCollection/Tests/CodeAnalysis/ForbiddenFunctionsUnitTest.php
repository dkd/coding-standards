<?php
/**
 * Unit test class for SuperglobalKeywordSniff.
 *
 * @package PHP_CodeSniffer
 * @subpackage DkdCollection
 * @author Christoph Gerold <christoph.gerold@dkd.de>
 * @version $Id$
 * @link http://pear.php.net/package/PHP_CodeSniffer
 */
class DkdCollection_Tests_CodeAnalysis_ForbiddenFunctionsUnitTest extends AbstractSniffUnitTest {

	/**
	 * Returns the lines where errors should occur.
	 *
	 * The key of the array should represent the line number and the value
	 * should represent the number of errors that should occur on that line.
	 *
	 * @return array(int => int)
	 */
	public function getErrorList() {

		$sqlStandaloneErrors = array();
		$sqlStandaloneErrors = array_fill(12,48,1);
		
		$sqlContextErrors = array(
			61 => 1,
			68 => 1,
			69 => 1,
			71 => 1,
			72 => 1,
			74 => 1,
			80 => 0,
			82 => 0,
			84 => 0
		);
		
		return ($sqlStandaloneErrors + $sqlContextErrors);
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