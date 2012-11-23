<?php
define('OK', 1);

class noComment {

}//end class


//
// Sample class comment
//
//
//
class invalidCommentStyle1 {

}//end class


/**
 *
 *
 * Sample class comment
 * Long description with extra blank line before and after
 *
 * @package TYPO3
 * @subpackage TYPO3
 * @author Timo Webler <timo.webler@dkd.de>
 * @version $Id$
 * @link http://pear.php.net/package/PHP_CodeSniffer
 */
class extraDescriptionNewlines {

}//end class


/**
 * Sample class comment
 * @package TYPO3
 * @subpackage TYPO3
 * @author Timo Webler <timo.webler@dkd.de>
 * @version $Id$
 * @link http://pear.php.net/package/PHP_CodeSniffer
 */
class missingNewlinesBeforeTags {

}//end class


/**
 * Simple class comment
 *
 * @package TYPO3
 * @subpackage SUBPACKAGE TAG
 * @author Original Author <author@example.com>
 * @version	$Id$
 * @see
 * @deprecated	asd
 */
class checkingTags {


}//end class


/**
 *
 *
 */
class emptyClassDoc {

}//end class


/**
 *
 *
 */
interface emptyInterfaceDoc {

}//end interface
?>