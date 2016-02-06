<?php

class ManipleForms_Form_Element_Country extends Zend_Form_Element_Select
{
    public $helper = 'formCountrySelect';

    protected function _getMultiOptions()
    {
        if (empty($this->options)) {
            $countries = array(
                '' => 'Select country',
            );
            foreach (ManipleForms_Locale_Country::getAll() as $code => $name) {
                $countries[$code] = $name;
            }
            $this->options = $countries;
        }
        return $this->options;
    }
}
