<?php
/**
 * A test class for testing all sniffs for installed standards.
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @author    Marc McIntyre <mmcintyre@squiz.net>
 * @copyright 2006 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @version   CVS: $Id$
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */

// Require this here so that the unit tests don't have to try and find the
// abstract class once it is installed into the PEAR tests directory.
require_once dirname(__FILE__).'/AbstractSniffUnitTest.php';

/**
 * A test class for testing all sniffs for TYPO3 standard.
 *
 * Usage: phpunit TYPO3Sniffs.php
 *
 * This test class loads all unit tests for all installed standards into a
 * single test suite and runs them. Errors are reported on the command line.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Timo Webler <timo.webler@dkd.de>
 */
class PHP_CodeSniffer_Standards_DkdSniffs {


	/**
	 * Prepare the test runner.
	 *
	 * @return void
	 */
	public static function main()
	{
		PHPUnit_TextUI_TestRunner::run(self::suite());

	}//end main()


	/**
	 * Add all sniff unit tests into a test suite.
	 *
	 * Sniff unit tests are found by recursing through the 'Tests' directory
	 * of each installed coding standard.
	 *
	 * @return PHPUnit_Framework_TestSuite
	 */
	public static function suite() {
		$suite = new PHPUnit_Framework_TestSuite('PHP CodeSniffer Standard TYPO3');

		$standardsDir = realpath(dirname(__FILE__).'/../../CodeSniffer/Standards');

		$standards = array('Dkd');

		foreach ($standards as $standard) {

			$standardDir = realpath($standardsDir.'/'.$standard.'/Tests/');

			$di = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($standardDir));

			foreach ($di as $file) {
				// Skip hidden files.
				if (substr($file->getFilename(), 0, 1) === '.') {
					continue;
				}

				// Tests must have the extention 'php'.
				$parts = explode('.', $file);
				$ext   = array_pop($parts);
				if ($ext !== 'php') {
					continue;
				}

				$filePath = realpath($file->getPathname());

				$className = str_replace($standardDir.DIRECTORY_SEPARATOR, '', $filePath);
				$className = substr($className, 0, -4);
				$className = str_replace(DIRECTORY_SEPARATOR, '_', $className);
				$className = $standard.'_Tests_'.$className;

				include_once $filePath;
				$class = new $className('getErrorList');
				$suite->addTest($class);
			}//end foreach
		}//end foreach

		return $suite;

	}//end suite()


	/**
	 * Autoload static method for loading classes and interfaces.
	 *
	 * @param string $className The name of the class or interface.
	 * @return void
	 */
	public static function autoload($className) {

		$path = str_replace('_', '/', $className).'.php';
		$file = dirname(dirname(dirname(__FILE__))) . '/CodeSniffer/Standards/' . $path;
		if (is_file($file) === true) {
			// Check standard file locations based on class name.
			require_once($file);
		}
	}


}//end class

?>
