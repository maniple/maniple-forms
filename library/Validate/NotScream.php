<?php

class ManipleForms_Validate_NotScream extends Zend_Validate_Abstract
{
    const IS_SCREAM = 'isScream';

    protected $_messageTemplates = array(
        self::IS_SCREAM => 'Please don\'t scream. Use capital letters only to begin sentences, titles or proper names. Other letters must be in lower case',
    );

    /**
     * Minimum percentage of 
     * @var float
     */
    protected $_treshold = 0.5;

    /**
     * @param  string $value
     * @return bool
     */
    public function isValid($value)
    {
        // transliterate to ASCII
        $filter = new Zefram_Filter_Ascii;
        $value = $filter->filter($value);

        $alpha = preg_replace('/[^A-Za-z]/', '', $value);
        $caps = preg_replace('/[^A-Z]/', '', $alpha);

        $alpha_length = strlen($alpha);
        $caps_length = strlen($caps);

        if (($alpha_length > 0) &&
            (($alpha_length - $caps_length) / $alpha_length < $this->_treshold)
        ) {
            $this->_error(self::IS_SCREAM);
            return false;
        }

        return true;
    }
}
