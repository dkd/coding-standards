<?php

//  Correct declarations.
class correctClassDeclaration {

}

abstract class correctClassDeclarationWithExtends extends correctClassDeclaration {

}

final class correctClassDeclarationWithImplements implements correctClassDeclaration {

}


// Incorrect placement of opening braces
class incorrectBracePlacement
{}
class incorrectBracePlacementWithExtends extends correctClassDeclaration
{}
class incorrectBracePlacementWithImplements implements correctClassDeclaration
{}

// Incorrect code placement for opening brace.
class incorrectCodeAfterOpeningBrace { protected $_incorrect;

}//end class

class incorrectClassDeclarationWithExtends extends correctClassDeclaration{

}

class incorrectClassDeclarationWithImplements implements correctClassDeclaration{

}

class incorrectBracePlacement{

}

abstract class correctWrapping
	extends
		ArrayObject
	implements
		Serializable,
		Iterator,
		Countable,
		OuterIterator,
		RecursiveIterator {
}

abstract class incorrectWrapping
	extends
		ArrayObject
	implements
		Serializable,
		Iterator,
		Countable,
		OuterIterator,
		RecursiveIterator
{
}
?>