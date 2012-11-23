<?php
/**
 * A test class for running TYPO3 PHP_CodeSniffer unit tests.
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Timo Webler <timo.webler@dkd.de>
 */

if (defined('PHPUnit_MAIN_METHOD') === false) {
	define('PHPUnit_MAIN_METHOD', 'PHP_CodeSniffer_TYPO3Tests::main');
}

require_once 'TestSuite.php';
require_once 'PHPUnit/TextUI/TestRunner.php';

require_once 'Standards/DkdSniffs.php';
require_once 'PHP/CodeSniffer.php';

/**
 * A test class for running all PHP_CodeSniffer unit tests.
 *
 * Usage: phpunit AllTests.php
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Timo Webler <timo.webler@dkd.de>
 */
class PHP_CodeSniffer_DkdTests {


		/**
		 * Prepare the test runner.
		 *
		 * @return void
		 */
		public static function main() {
				PHPUnit_TextUI_TestRunner::run(self::suite());

		}//end main()


		/**
		 * Add all PHP_CodeSniffer test suites into a single test suite.
		 *
		 * @return PHPUnit_Framework_TestSuite
		 */
		public static function suite() {

			// Use a special PHP_CodeSniffer test suite so that we can
			// unset our autoload function after the run.
			$suite = new PHP_CodeSniffer_TestSuite('PHP_CodeSniffer Dkd');
			$suite->addTest(PHP_CodeSniffer_Standards_DkdSniffs::suite());

			// Unregister this here because the PEAR tester loads
			// all package suites before running then, so our autoloader
			// will cause problems for the packages included after us.
			spl_autoload_unregister(array('PHP_CodeSniffer', 'autoload'));
			spl_autoload_unregister(array('PHP_CodeSniffer_Standards_DkdSniffs', 'autoload'));

			return $suite;

		}//end suite()


}//end class

if (PHPUnit_MAIN_METHOD == 'PHP_CodeSniffer_DkdTests::main') {
		PHP_CodeSniffer_DkdTests::main();
}
?>
