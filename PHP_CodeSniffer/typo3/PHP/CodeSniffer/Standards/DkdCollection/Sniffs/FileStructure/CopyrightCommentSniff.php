<?php

/**
 * DkdCollection_Sniffs_FileStructure_CopyrightCommentSniff.
 *
 * @package PHP_CodeSniffer
 * @subpackage DkdCollection
 * @author Timo Webler <timo.webler@dkd.de>
 * @version $Id$
 * @link http://pear.php.net/package/PHP_CodeSniffer
 */

/**
 * DkdCollection_Sniffs_FileStructure_CopyrightCommentSniff.
 *
 * Tests if file includes the general DkdCollection copyright statement
 *
 * @package PHP_CodeSniffer
 * @subpackage DkdCollection
 * @author Timo Webler <timo.webler@dkd.de>
 * @version $Id$
 * @link http://pear.php.net/package/PHP_CodeSniffer
 * @todo Must be rewritten
 */
class DkdCollection_Sniffs_FileStructure_CopyrightCommentSniff implements PHP_CodeSniffer_Sniff {


	/**
	 * Returns an array of tokens this test wants to listen for.
	 *
	 * @return array
	 */
	public function register() {
		return array(
			T_OPEN_TAG
		);

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

		if ($stackPtr !== 0) {
			return;
		}

		$tokens   = $phpcsFile->getTokens();

		if ($tokens[1]['code'] !== T_COMMENT) {
			$phpcsFile->addError(
				'copyright notice must be set after opening tag',
				$stackPtr
			);
			return;
		}


		$correctCopyright[0] = '/***************************************************************';
		$correctCopyright[1] = '*  Copyright notice';
		$correctCopyright[2] = '*';
		$correctCopyright[4] = '*  All rights reserved';
		$correctCopyright[5] = '*';
		$correctCopyright[6] = '*  This script is part of the TYPO3 project. The TYPO3 project is';
		$correctCopyright[7] = '*  free software; you can redistribute it and/or modify';
		$correctCopyright[8] = '*  it under the terms of the GNU General Public License as published by';
		$correctCopyright[9] = '*  the Free Software Foundation; either version 2 of the License, or';
		$correctCopyright[10] = '*  (at your option) any later version.';
		$correctCopyright[11] = '*';
		$correctCopyright[12] = '*  The GNU General Public License can be found at';
		$correctCopyright[13] = '*  http://www.gnu.org/copyleft/gpl.html.';
		$correctCopyright[14] = '*';
		$correctCopyright[15] = '*  This script is distributed in the hope that it will be useful,';
		$correctCopyright[16] = '*  but WITHOUT ANY WARRANTY; without even the implied warranty of';
		$correctCopyright[17] = '*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the';
		$correctCopyright[18] = '*  GNU General Public License for more details.';
		$correctCopyright[19] = '*';
		$correctCopyright[20] = '*  This copyright notice MUST APPEAR in all copies of the script!';
		$correctCopyright[21] = '***************************************************************/';

		foreach ($correctCopyright as $line => $value) {
			$positionOfToken = 1 + $line;
			if ( $positionOfToken >= count($tokens)) {
				break;
			}
			if (trim($tokens[$positionOfToken]['content']) !== trim($value)) {
				$error = 'Copyright comment not correct. Expecting ' . $value;
				$error .= ' but found ' . $tokens[$positionOfToken]['content'];
				$phpcsFile->addWarning($error, $positionOfToken);
			}
		}


	}//end process()


}//end class

?>
