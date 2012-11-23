<?php
/**
 * Class Declaration Test.
 *
 * @package PHP_CodeSniffer
 * @subpackage DkdCollection
 * @author Timo Webler <timo.webler@dkd.de>
 * @version $Id$
 * @link http://pear.php.net/package/PHP_CodeSniffer
 */

/**
 * Class Declaration Test.
 *
 * Checks the declaration of the class is correct.
 *
 * @package PHP_CodeSniffer
 * @subpackage DkdCollection
 * @author Timo Webler <timo.webler@dkd.de>
 * @version $Id$
 * @link http://pear.php.net/package/PHP_CodeSniffer
 */
class DkdCollection_Sniffs_Classes_ClassDeclarationSniff implements PHP_CodeSniffer_Sniff {


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
	 * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
	 * @param int $stackPtr  The position of the current token in the
	 * stack passed in $tokens.
	 *
	 * @return void
	 */
	public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr) {
		$tokens = $phpcsFile->getTokens();

		if (isset($tokens[$stackPtr]['scope_opener']) === false) {
			$error  = 'Possible parse error: ';
			$error .= $tokens[$stackPtr]['content'];
			$error .= ' missing opening or closing brace';
			$phpcsFile->addWarning($error, $stackPtr);
			return;
		}


		$curlyBrace  = $tokens[$stackPtr]['scope_opener'];
		$lastContent = $phpcsFile->findPrevious(T_WHITESPACE, ($curlyBrace - 1), $stackPtr, true);
		$classLine   = $tokens[$lastContent]['line'];
		$braceLine   = $tokens[$curlyBrace]['line'];
		if ($braceLine !== $classLine) {
			$error  = 'Opening brace of a ';
			$error .= $tokens[$stackPtr]['content'];
			$error .= ' must be on same line of definition';
			$phpcsFile->addError($error, $curlyBrace);
			return;
		}

		if ($tokens[($curlyBrace + 1)]['content'] !== $phpcsFile->eolChar) {
			$type  = strtolower($tokens[$stackPtr]['content']);
			$error = "Opening $type brace must be on line end";
			$phpcsFile->addError($error, $curlyBrace);
		}

		if ($tokens[($curlyBrace - 1)]['code'] !== T_WHITESPACE) {
			$error = 'Expected 1 spaces before opening brace';
			$phpcsFile->addError($error, $curlyBrace);
		}
		else if (strlen($tokens[($curlyBrace - 1)]['content'] > 1)) {
			$error = 'Expected 1 spaces before opening brace';
			$phpcsFile->addError($error, $curlyBrace);
		}

	}//end process()

}//end class
?>
