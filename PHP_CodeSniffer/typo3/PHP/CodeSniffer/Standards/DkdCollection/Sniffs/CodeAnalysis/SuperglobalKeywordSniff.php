<?php
/**
 * Generic_Sniffs_PHP_SuperglobalKeywordSniff.
 *
 * Discourages the use of superglobals
 *
 * @category PHP
 * @package PHP_CodeSniffer
 * @subpackage DkdCollection
 * @author Christoph Gerold <christoph.gerold@dkd.de>
 * @version $Id$
 * @link http://pear.php.net/package/PHP_CodeSniffer
 */
class DkdCollection_Sniffs_CodeAnalysis_SuperglobalKeywordSniff implements PHP_CodeSniffer_Sniff {
	/**
	 * Returns an array of tokens this test wants to listen for.
	 *
	 * @return array
	 */
	public function register() {
		return array(T_VARIABLE);
	}

	/**
	 * A list of forbidden superglobals with their alternatives.
	 *
	 * The value is NULL if no alternative exists. IE, the
	 * variable should just not be used.
	 *
	 * @var array(string => string|null)
	 */
	public $flawedSuperglobals = array(
		'$_SERVER' => 't3lib_div::getIndpEnv',
		'$_GET' => 't3lib_div::_GET',
		'$_POST' => 't3lib_div::_POST',
		'$_REQUEST'=> 't3lib_div::_GP',
		'$_ENV' => 't3lib_div::getIndpEnv'
	);

	/**
	 * A list of admonitory superglobals
	 *
	 * @var array(string => string|null)
	 */
	public $admonitorySuperglobals = array(
		'$_FILES' => 'Beware of security issues',
		'$_COOKIE' => 'Beware of security issues',
		'$_SESSION' => 'Beware of security issues'
	);

	/**
	 * Processes this test, when one of its tokens is encountered.
	 *
	 * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
	 * @param int $stackPtr The position of the current token in the
	 * stack passed in $tokens.
	 *
	 * @return void
	 */
	public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr) {
		$tokens = $phpcsFile->getTokens();
		$nextVar = $tokens[$phpcsFile->findNext(array(T_VARIABLE), $stackPtr)];
		$varName = $nextVar['content'];
		$data = array($varName);

			// Check forbidden superglobals
		if (array_key_exists($varName, $this->flawedSuperglobals)) {
			$error = $this->flawedSuperglobals[$varName];
			$phpcsFile->addError($error, $stackPtr, 'NotAllowed', $data);
		} else if (array_key_exists($varName, $this->admonitorySuperglobals)) {
			$warning = $this->admonitorySuperglobals[$varName];
			$phpcsFile->addWarning($warning, $stackPtr, 'NotAllowed', $data);
		}
	}
}
?>
