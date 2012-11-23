<?php
/**
 * Dkd_Sniffs_WhiteSpace_DisallowProtectedWhitespaceSniff.
 *
 * PHP version 5
 *
 * @category  Whitespace
 * @package   Dkd
 * @author    Timo Webler <timo.webler@dkd.de>
 * @copyright Copyright (c) 2010, Timo Webler
 * @license   http://www.gnu.org/copyleft/gpl.html GNU Public License
 * @version   SVN: $ID$
 * @link      http://dkd.typo3.org
 */

/**
 * Search protected whitespaces
 *
 * @category  Whitespace
 * @package   Dkd
 * @author    Timo Webler <timo.webler@dkd.de>
 * @copyright Copyright (c) 2010, Timo Webler
 * @license   http://www.gnu.org/copyleft/gpl.html GNU Public License
 * @version   Release: 0.4.0
 * @link      http://dkd.typo3.org
 */
class Dkd_Sniffs_WhiteSpace_DisallowProtectedWhitespaceSniff implements PHP_CodeSniffer_Sniff {

	/**
	 * A list of tokenizers this sniff supports
	 *
	 * @var array
	 */
	public $supportedTokenizes = array('PHP');

	/**
	 * Returns an array of tokens this test wants to listen for.
	 *
	 * @return array
	 */
	public function register() {
		return array(T_OPEN_TAG);
	}

	/**
	 * Processes this sniff, when one of its tokens is encountered.
	 *
	 * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
	 * @param int                  $stackPtr  The position of the current token in
	 *                                        the stack passed in $tokens.
	 *
	 * @return void
	 */
	public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr) {
			// We are only interested if this is the first open tag.
		if ($stackPtr !== 0) {
			if ($phpcsFile->findPrevious(T_OPEN_TAG, ($stackPtr - 1)) !== false) {
				return;
			}
		}
		$tokens = $phpcsFile->getTokens();
		// parse hole file
		foreach($tokens as $pointer => $token) {
			$content = $token['content'];
			// Search protected whitespace () ALT + "Leertaste"
			if (mb_strripos($content, chr(160)) !== FALSE) {
				$phpcsFile->addError(
					'Protected whitespaces not allowed"',
					$pointer
				);
			}
		}
	}
}
?>