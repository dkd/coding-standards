<?php
/**
 * DkdCollection_Sniffs_Strings_ConcatenationSpacingSniff.
 *
 * Throws errors if tabs are used for indentation.
 *
 * @package PHP_CodeSniffer
 * @subpackage DkdCollection
 * @author Timo Webler <timo.webler@dkd.de>
 * @version $Id$
 * @link http://pear.php.net/package/PHP_CodeSniffer
 */

/**
 * T3_DkdCollectionCGL_Sniffs_Strings_ConcatenationSpacingSniff.
 *
 * Makes sure there are spaces between the concatenation operator (.) and
 * the strings being concatenated.
 *
/**
 * DkdCollection_Sniffs_Strings_ConcatenationSpacingSniff.
 *
 * Throws errors if tabs are used for indentation.
 *
 * @package PHP_CodeSniffer
 * @subpackage DkdCollection
 * @author Timo Webler <timo.webler@dkd.de>
 * @version $Id$
 * @link http://pear.php.net/package/PHP_CodeSniffer
 */
class DkdCollection_Sniffs_Strings_ConcatenationSpacingSniff implements PHP_CodeSniffer_Sniff {


	/**
	 * Returns an array of tokens this test wants to listen for.
	 *
	 * @return array
	 */
	public function register() {
		return array(T_STRING_CONCAT);

	}//end register()


	/**
	 * Processes this test, when one of its tokens is encountered.
	 *
	 * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
	 * @param int $stackPtr The position of the current token in the stack passed in $tokens.
	 *
	 * @return void
	 */
	public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr) {
		$tokens = $phpcsFile->getTokens();

		$found = '';
		$expected = '';
		$error = FALSE;

		if ($tokens[($stackPtr - 1)]['code'] === T_WHITESPACE) {
			$expected .= '...' . substr($tokens[($stackPtr - 2)]['content'], -5) . ' ' . $tokens[$stackPtr]['content'];
			$found .= '...' . substr($tokens[($stackPtr - 2)]['content'], -5) . $tokens[($stackPtr - 1)]['content'] . $tokens[$stackPtr]['content'];
		} else {
			$found    .= '...' . substr($tokens[($stackPtr - 1)]['content'], -5) . $tokens[$stackPtr]['content'];
			$expected .= '...' . substr($tokens[($stackPtr - 1)]['content'], -5) . ' ' . $tokens[$stackPtr]['content'];
			$error     = TRUE;
		}

		if ($tokens[($stackPtr + 1)]['code'] === T_WHITESPACE) {
			$expected .= ' ' . substr($tokens[($stackPtr + 2)]['content'], 0, 5) . '...';
			$found    .= $tokens[($stackPtr + 1)]['content'] . substr($tokens[($stackPtr + 2)]['content'], 0, 5) . '...';
		} else {
			$found    .= $tokens[($stackPtr + 1)]['content'];
			$expected .= ' ' . $tokens[($stackPtr + 1)]['content'];
			$error     = TRUE;
		}

		if ($error === TRUE) {
			$found    = str_replace("\r\n", '\n', $found);
			$found    = str_replace("\n", '\n', $found);
			$found    = str_replace("\r", '\n', $found);
			$expected = str_replace("\r\n", '\n', $expected);
			$expected = str_replace("\n", '\n', $expected);
			$expected = str_replace("\r", '\n', $expected);

			$message = "Concat operator must be surrounded by spaces. Found \"$found\"; expected \"$expected\"";
			$phpcsFile->addError($message, $stackPtr);
		}

	}//end process()


}//end class

?>