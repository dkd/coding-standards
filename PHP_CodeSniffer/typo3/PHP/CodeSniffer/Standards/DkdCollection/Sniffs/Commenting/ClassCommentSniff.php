<?php
/**
 * Parses and verifies the doc comments for classes.
 *
 * @package PHP_CodeSniffer
 * @subpackage DkdCollection
 * @author Timo Webler <timo.webler@dkd.de>
 * @version $Id$
 * @link http://pear.php.net/package/PHP_CodeSniffer
 */

if (class_exists('PHP_CodeSniffer_CommentParser_ClassCommentParser', true) === false) {
	$error = 'Class PHP_CodeSniffer_CommentParser_ClassCommentParser not found';
	throw new PHP_CodeSniffer_Exception($error);
}

if (class_exists('DkdCollection_Sniffs_Commenting_FileCommentSniff', true) === false) {
	$error = 'Class DkdCollection_Sniffs_Commenting_FileCommentSniff not found';
	throw new PHP_CodeSniffer_Exception($error);
}

/**
 * Parses and verifies the doc comments for classes.
 *
 * Verifies that :
 * <ul>
 *  <li>A doc comment exists.</li>
 *  <li>There is a blank newline before first tag.</li>
 *  <li>Check the indentation of each tag.</li>
 *  <li>Check required and optional tags and the format of their content.</li>
 * </ul>
 *
 * @package PHP_CodeSniffer
 * @subpackage DkdCollection
 * @author Timo Webler <timo.webler@dkd.de>
 * @version $Id$
 * @link http://pear.php.net/package/PHP_CodeSniffer
 */
class DkdCollection_Sniffs_Commenting_ClassCommentSniff extends DkdCollection_Sniffs_Commenting_FileCommentSniff {


	/**
	 * allowed tags
	 *
	 * @var array
	 */
	protected $_tags = array(
		 'package'    => array(
						  'required'       => true,
						  'allow_multiple' => false,
						  'order_text'     => 'precedes @subpackage',
						 ),
		 'subpackage' => array(
						  'required'       => true,
						  'allow_multiple' => false,
						  'order_text'     => 'follows @package',
						 ),
		 'author'     => array(
						  'required'       => true,
						  'allow_multiple' => true,
						  'order_text'     => 'follows @subpackage',
						 ),
		 'link'       => array(
						  'required'       => false,
						  'allow_multiple' => true,
						  'order_text'     => 'follows @version',
						 ),
		 'see'        => array(
						  'required'       => false,
						  'allow_multiple' => true,
						  'order_text'     => 'follows @link',
						 )
	);

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
		$this->_currentFile = $phpcsFile;

		$tokens = $phpcsFile->getTokens();
		$type   = strtolower($tokens[$stackPtr]['content']);
		$find   = array(
			T_ABSTRACT,
			T_WHITESPACE,
			T_FINAL,
		);

		// Extract the class comment docblock.
		$commentEnd = $phpcsFile->findPrevious($find, ($stackPtr - 1), null, true);

		if ($commentEnd !== false && $tokens[$commentEnd]['code'] === T_COMMENT) {
			$phpcsFile->addError("You must use \"/**\" style comments for a $type comment", $stackPtr);
			return;
		} else if ($commentEnd === false || $tokens[$commentEnd]['code'] !== T_DOC_COMMENT) {
			$phpcsFile->addError("Missing $type doc comment", $stackPtr);
			return;
		}

		$commentStart = ($phpcsFile->findPrevious(T_DOC_COMMENT, ($commentEnd - 1), null, true) + 1);
		$commentNext  = $phpcsFile->findPrevious(T_WHITESPACE, ($commentEnd + 1), $stackPtr, false, $phpcsFile->eolChar);

		// Distinguish file and class comment.
		$prevClassToken = $phpcsFile->findPrevious(T_CLASS, ($stackPtr - 1));
		if ($prevClassToken === false) {
			// This is the first class token in this file, need extra checks.
			$prevNonComment = $phpcsFile->findPrevious(T_DOC_COMMENT, ($commentStart - 1), null, true);
			if ($prevNonComment !== false) {
				$prevComment = $phpcsFile->findPrevious(T_DOC_COMMENT, ($prevNonComment - 1));
				if ($prevComment === false) {
					// There is only 1 doc comment between open tag and class token.
					$newlineToken = $phpcsFile->findNext(T_WHITESPACE, ($commentEnd + 1), $stackPtr, false, $phpcsFile->eolChar);
					if ($newlineToken !== false) {
						$newlineToken = $phpcsFile->findNext(T_WHITESPACE, ($newlineToken + 1), $stackPtr, false, $phpcsFile->eolChar);
						if ($newlineToken !== false) {
							// Blank line between the class and the doc block.
							// The doc block is most likely a file comment.
							$phpcsFile->addError("Missing $type doc comment", ($stackPtr + 1));
							return;
						}
					}//end if
				}//end if
			}//end if
		}//end if

		$comment = $phpcsFile->getTokensAsString($commentStart, ($commentEnd - $commentStart + 1));

		// Parse the class comment.docblock.
		try {
			$this->_commentParser = new PHP_CodeSniffer_CommentParser_ClassCommentParser($comment, $phpcsFile);
			$this->_commentParser->parse();
		} catch (PHP_CodeSniffer_CommentParser_ParserException $e) {
			$line = ($e->getLineWithinComment() + $commentStart);
			$phpcsFile->addError($e->getMessage(), $line);
			return;
		}

		$comment = $this->_commentParser->getComment();
		if (is_null($comment) === true) {
			$error = ucfirst($type).' doc comment is empty';
			$phpcsFile->addError($error, $commentStart);
			return;
		}

		// No extra newline before short description.
		$short = $comment->getShortComment();
		$newlineCount = 0;
		$newlineSpan  = strspn($short, $phpcsFile->eolChar);
		if ($short !== '' && $newlineSpan > 0) {
			$line  = ($newlineSpan > 1) ? 'newlines' : 'newline';
			$error = "Extra $line found before $type comment short description";
			$phpcsFile->addError($error, ($commentStart + 1));
		}

		$newlineCount = (substr_count($short, $phpcsFile->eolChar) + 1);
		$long = $comment->getLongComment();

		// Exactly one blank line before tags.
		$tags = $this->_commentParser->getTagOrders();
		if (count($tags) > 1) {
			$newlineSpan = $comment->getNewlineAfter();
			if ($newlineSpan !== 2) {
				$error = "There must be exactly one blank line before the tags in $type comments";
				if ($long !== '') {
					$newlineCount += (substr_count($long, $phpcsFile->eolChar) - $newlineSpan + 1);
				}

				$phpcsFile->addError($error, ($commentStart + $newlineCount));
				$short = rtrim($short, $phpcsFile->eolChar.' ');
			}
		}

		// Check each tag.
		$this->_processTags($commentStart, $commentEnd);

	}//end process()

}//end class

?>
