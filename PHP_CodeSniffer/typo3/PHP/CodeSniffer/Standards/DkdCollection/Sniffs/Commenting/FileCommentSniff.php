<?php
/**
 * Parses and verifies the doc comments for files.
 *
 * @package PHP_CodeSniffer
 * @subpackage DkdCollection
 * @author Timo Webler <timo.webler@dkd.de>
 * @version $Id$
 * @link http://pear.php.net/package/PHP_CodeSniffer
 */

if (class_exists('PHP_CodeSniffer_CommentParser_ClassCommentParser', true) === false) {
	throw new PHP_CodeSniffer_Exception('Class PHP_CodeSniffer_CommentParser_ClassCommentParser not found');
}

/**
 * Parses and verifies the doc comments for files.
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

class DkdCollection_Sniffs_Commenting_FileCommentSniff implements PHP_CodeSniffer_Sniff {

	/**
	 * The header comment parser for the current file.
	 *
	 * @var PHP_CodeSniffer_Comment_Parser_ClassCommentParser
	 */
	protected $_commentParser = null;

	/**
	 * The current PHP_CodeSniffer_File object we are processing.
	 *
	 * @var PHP_CodeSniffer_File
	 */
	protected $_currentFile = null;


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
		'version'    => array(
						'required'       => true,
						'allow_multiple' => false,
						'order_text'     => 'follows @author',
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
		return array(T_OPEN_TAG);
	}//end register()


	/**
	 * Processes this test, when one of its tokens is encountered.
	 *
	 * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
	 * @param int $stackPtr  The position of the current token
	 * in the stack passed in $tokens.
	 * @return void
	 */
	public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr) {
		$this->_currentFile = $phpcsFile;

		// We are only interested if this is the first open tag.
		if ($stackPtr !== 0) {
			if ($phpcsFile->findPrevious(T_OPEN_TAG, ($stackPtr - 1)) !== false) {
				return;
			}
		}

		$tokens = $phpcsFile->getTokens();

		// Ignore copyright comment
		if ($tokens[1]['code'] === T_COMMENT) {
			$stackPtr = 22;
		}

		// Find the next non whitespace token.
		$commentStart = $phpcsFile->findNext(T_WHITESPACE, ($stackPtr + 1), null, true);

		if ($tokens[$commentStart]['code'] === T_CLOSE_TAG) {
			// We are only interested if this is the first open tag.
			return;
		} else if ($tokens[$commentStart]['code'] === T_COMMENT) {
			$phpcsFile->addError('You must use "/**" style comments for a file comment', ($stackPtr + 1));
			return;
		} else if ($commentStart === false || $tokens[$commentStart]['code'] !== T_DOC_COMMENT) {
			$phpcsFile->addError('Missing file doc comment', ($stackPtr + 1));
			return;
		} else {

			// Extract the header comment docblock.
			$commentEnd = ($phpcsFile->findNext(T_DOC_COMMENT, ($commentStart + 1), null, true) - 1);

			// Check if there is only 1 doc comment between the open tag and class token.
			$nextToken = array(
				T_ABSTRACT,
				T_CLASS,
				T_INTERFACE,
				T_FUNCTION,
				T_DOC_COMMENT,
			);
			$commentNext = $phpcsFile->findNext($nextToken, ($commentEnd + 1));
			if ($commentNext !== false && $tokens[$commentNext]['code'] !== T_DOC_COMMENT) {
				// Found a class token right after comment doc block.
				$newlineToken = $phpcsFile->findNext(T_WHITESPACE, ($commentEnd + 1), $commentNext, false, $phpcsFile->eolChar);
				if ($newlineToken !== false) {
					$newlineToken = $phpcsFile->findNext(T_WHITESPACE, ($newlineToken + 1), $commentNext, false, $phpcsFile->eolChar);
					if ($newlineToken === false) {
						// No blank line between the class token and the doc block.
						// The doc block is most likely a class comment.
						$phpcsFile->addError('Missing file doc comment', ($stackPtr + 1));
						return;
					}
				}
			}

			$comment = $phpcsFile->getTokensAsString($commentStart, ($commentEnd - $commentStart + 1));

			// Parse the header comment docblock.
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
				$error = 'File doc comment is empty';
				$phpcsFile->addError($error, $commentStart);
				return;
			}

			// No extra newline before short description.
			$short = $comment->getShortComment();
			$newlineCount = 0;
			$newlineSpan  = strspn($short, $phpcsFile->eolChar);
			if ($short !== '' && $newlineSpan > 0) {
				$line  = ($newlineSpan > 1) ? 'newlines' : 'newline';
				$error = "Extra $line found before file comment short description";
				$phpcsFile->addError($error, ($commentStart + 1));
			}

			$newlineCount = (substr_count($short, $phpcsFile->eolChar) + 1);
			$long = $comment->getLongComment();

			// Exactly one blank line before tags.
			$tags = $this->_commentParser->getTagOrders();
			if (count($tags) > 1) {
				$newlineSpan = $comment->getNewlineAfter();
				if ($newlineSpan !== 2) {
					$error = 'There must be exactly one blank line before the tags in file comment';
					if ($long !== '') {
						$newlineCount += (substr_count($long, $phpcsFile->eolChar) - $newlineSpan + 1);
					}

					$phpcsFile->addError($error, ($commentStart + $newlineCount));
					$short = rtrim($short, $phpcsFile->eolChar.' ');
				}
			}

			// Check each tag.
			$this->_processTags($commentStart, $commentEnd);
		}//end if

	}//end process()


	/**
	 * Processes each required or optional tag.
	 *
	 * @param int $commentStart The position in the stack where the comment started.
	 * @param int $commentEnd The position in the stack where the comment ended.
	 *
	 * @return void
	 */
	protected function _processTags($commentStart, $commentEnd) {
		// Tags in correct order and related info.

		$docBlock    = (get_class($this) === 'DkdCollection_Sniffs_Commenting_FileCommentSniff') ? 'file' : 'class';
		$foundTags   = $this->_commentParser->getTagOrders();
		$orderIndex  = 0;
		$indentation = array();
		$longestTag  = 0;
		$errorPos    = 0;

		foreach ($this->_tags as $tag => $info) {

			// Required tag missing.
			if ($info['required'] === true && in_array($tag, $foundTags) === false) {
				$error = "Missing @$tag tag in $docBlock comment";
				$this->_currentFile->addError($error, $commentEnd);
				continue;
			}

			// Get the line number for current tag.
			$tagName = ucfirst($tag);
			if ($info['allow_multiple'] === true) {
				$tagName .= 's';
			}

			$getMethod  = 'get'.$tagName;
			$tagElement = $this->_commentParser->$getMethod();
			if (is_null($tagElement) === true || empty($tagElement) === true) {
				continue;
			}

			$errorPos = $commentStart;
			if (is_array($tagElement) === false) {
				$errorPos = ($commentStart + $tagElement->getLine());
			}

			// Get the tag order.
			$foundIndexes = array_keys($foundTags, $tag);

			if (count($foundIndexes) > 1) {
				// Multiple occurance not allowed.
				if ($info['allow_multiple'] === false) {
					$error = "Only 1 @$tag tag is allowed in a $docBlock comment";
					$this->_currentFile->addError($error, $errorPos);
				} else {
					// Make sure same tags are grouped together.
					$i     = 0;
					$count = $foundIndexes[0];
					foreach ($foundIndexes as $index) {
						if ($index !== $count) {
							$errorPosIndex = ($errorPos + $tagElement[$i]->getLine());
							$error         = "@$tag tags must be grouped together";
							$this->_currentFile->addError($error, $errorPosIndex);
						}

						$i++;
						$count++;
					}
				}
			}//end if

			// Check tag order.
			if ($foundIndexes[0] > $orderIndex) {
				$orderIndex = $foundIndexes[0];
			} else {
				if (is_array($tagElement) === true && empty($tagElement) === false) {
					$errorPos += $tagElement[0]->getLine();
				}

				$orderText = $info['order_text'];
				$error     = "The @$tag tag is in the wrong order; the tag $orderText";
				$this->_currentFile->addError($error, $errorPos);
			}

			$method = '_process'.$tagName;
			if (method_exists($this, $method) === true) {
				// Process each tag if a method is defined.
				call_user_func(array($this, $method), $errorPos);
			} else {
				if (is_array($tagElement) === true) {
					foreach ($tagElement as $key => $element) {
						$element->process($this->_currentFile, $commentStart, $docBlock);
					}
				} else {
					$tagElement->process($this->_currentFile, $commentStart, $docBlock);
				}
			}
		}//end foreach

	}//end processTags()


	/**
	 * Process the package tag.
	 *
	 * @param int $errorPos The line number where the error occurs.
	 *
	 * @return void
	 */
	protected function _processPackage($errorPos)
	{
		$package = $this->_commentParser->getPackage();
		if ($package !== null) {
			$content = $package->getContent();
			if (empty($content)) {
				$error = '@package tag must contain a name';
				$this->_currentFile->addError($error, $errorPos);
			} else if ($content !== 'TYPO3'){
				$error = 'package name must be "TYPO3"';
				$this->_currentFile->addError($error, $errorPos);
			}
		}

	}//end processPackage()


	/**
	 * Process the subpackage tag.
	 *
	 * @param int $errorPos The line number where the error occurs.
	 *
	 * @return void
	 */
	protected function _processSubpackage($errorPos)
	{
		$package = $this->_commentParser->getSubpackage();
		if ($package !== null) {
			$content = $package->getContent();
			if ($content === '') {
				$error = '@subpackage tag must contain a name';
				$this->_currentFile->addError($error, $errorPos);
			}
		}

	}//end processSubpackage()


	/**
	 * Process the author tag(s) that this header comment has.
	 *
	 * This function is different from other _process functions
	 * as $authors is an array of SingleElements, so we work out
	 * the errorPos for each element separately
	 *
	 * @param int $commentStart The position in the stack where
	 *                          the comment started.
	 *
	 * @return void
	 */
	protected function _processAuthors($commentStart) {
		$authors = $this->_commentParser->getAuthors();
		// Report missing return.
		if (empty($authors) === false) {
			foreach ($authors as $author) {
				$errorPos = ($commentStart + $author->getLine());
				$content  = $author->getContent();
				if ($content !== '') {
					$local = '\da-zA-Z-_+';
					// Dot character cannot be the first or last character in the local-part.
					$localMiddle = $local.'.\w';
					if (preg_match('/^([^<]*)\s+<(['.$local.']['.$localMiddle.']*['.$local.']@[\da-zA-Z][-.\w]*[\da-zA-Z]\.[a-zA-Z]{2,7})>$/', $content) === 0) {
						$error = 'Content of the @author tag must be in the form "Display Name <username@example.com>"';
						$this->_currentFile->addError($error, $errorPos);
					}
				} else {
					$docBlock = (get_class($this) === 'DkdCollection_Sniffs_Commenting_FileCommentSniff') ? 'file' : 'class';
					$error    = "Content missing for @author tag in $docBlock comment";
					$this->_currentFile->addError($error, $errorPos);
				}
			}
		}

	}//end processAuthors()


	/**
	 * Process the version tag.
	 *
	 * @param int $errorPos The line number where the error occurs.
	 *
	 * @return void
	 */
	protected function _processVersion($errorPos)
	{
		$version = $this->_commentParser->getVersion();
		if ($version !== null) {
			$content = $version->getContent();
			$matches = array();
			if (empty($content) === true) {
				$error = 'Content missing for @version tag in file comment';
				$this->_currentFile->addError($error, $errorPos);
			} else if (strpos($content, '$Id') === false) {
				$error = 'Invalid version "' . $content .' " in file comment; consider $Id $';
				$this->_currentFile->addError($error, $errorPos);
			}
		}

	}//end processVersion()


}//end class

?>
