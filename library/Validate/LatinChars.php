<?php

class ManipleForms_Validate_LatinChars extends Zend_Validate_Abstract
{
    const NOT_LATIN = 'notLatin';

    protected $_messageTemplates = array(
        self::NOT_LATIN => 'Only latin characters are allowed',
    );

    public function isValid($value)
    {
        $value = (string) $value;

        // all basic ASCII chars + Unicode Latin letters
        if (!preg_match("/^[\t\n\r\x20-\x7E\p{Latin}]+$/u", $value)) {
            $this->_error(self::NOT_LATIN);
            return false;
        }

        return true;
    }
}
