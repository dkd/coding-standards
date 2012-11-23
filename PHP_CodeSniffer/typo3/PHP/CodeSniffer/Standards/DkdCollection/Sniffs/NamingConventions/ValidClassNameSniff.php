<?php
/**
 * DkdCollection_Sniffs_NamingConventions_ValidClassNameSniff.
 *
 * @package PHP_CodeSniffer
 * @subpackage DkdCollection
 * @author Timo Webler <timo.webler@dkd.de>
 * @version $Id$
 * @link http://pear.php.net/package/PHP_CodeSniffer
 */

/**
 * DkdCollection_Sniffs_NamingConventions_ValidClassNameSniff.
 *
 * Ensures class and interface names start with a capital letter
 * and use _ separators.
 *
 * @package PHP_CodeSniffer
 * @subpackage DkdCollection
 * @author Timo Webler <timo.webler@dkd.de>
 * @version $Id$
 * @link http://pear.php.net/package/PHP_CodeSniffer
 */
class DkdCollection_Sniffs_NamingConventions_ValidClassNameSniff implements PHP_CodeSniffer_Sniff {


	/**
	 * Returns an array of tokens this test wants to listen for.
	 *
	 * @return array
	 */
	public function register() {
		return array(
			T_CLASS,
			T_INTERFACE,
		);

	}//end register()


	/**
	 * Processes this test, when one of its tokens is encountered.
	 *
	 * @param PHP_CodeSniffer_File $phpcsFile The current file being processed.
	 * @param int $stackPtr  The position of the current token
	 * in the stack passed in $tokens.
	 *
	 * @return void
	 */
	public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr) {
		$tokens = $phpcsFile->getTokens();

		$className = $phpcsFile->findNext(T_STRING, $stackPtr);
		$name = trim($tokens[$className]['content']);

		// Make sure the first letter is a capital.
		if (preg_match('/^(tx_|user_|ux_)/', $name) === 0) {
			$error = ucfirst($tokens[$stackPtr]['content']).' name must begin with tx_, ux_ or user_';
			$phpcsFile->addError($error, $stackPtr);
			return;
		}

		$nameParts = explode('_', $name);
		$name = end($nameParts);

		if (!PHP_CodeSniffer::isCamelCaps($name,true)) {
			$error = ucfirst($tokens[$stackPtr]['content']).' last Part of class name musst be UperCamelCaps';
			$phpcsFile->addError($error, $stackPtr);
		}

	}//end process()


}//end class


?>
