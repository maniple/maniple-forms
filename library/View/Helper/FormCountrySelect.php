<?php

class ManipleForms_View_Helper_FormCountrySelect extends Zend_View_Helper_FormSelect
{
    public function formCountrySelect($name, $value = null, $attribs = null,
        $options = null, $listsep = "<br />\n")
    {
        $attribs['data-country-select'] = '';
        return $this->formSelect($name, $value, $attribs, $options, $listsep);
    }

    protected function _build($value, $label, $selected, $disable, $optionClasses = array())
    {
        if (is_bool($disable)) {
            $disable = array();
        }

        $class = null;
        if (array_key_exists($value, $optionClasses)) {
            $class = $optionClasses[$value];
        }

        $opt = '<option'
             . ' value="' . $this->view->escape($value) . '"';

        if ($class) {
             $opt .= ' class="' . $class . '"';
        }
        // selected?
        if (in_array((string) $value, $selected)) {
            $opt .= ' selected="selected"';
        }

        // disabled?
        if (in_array($value, $disable)) {
            $opt .= ' disabled="disabled"';
        }

        $countries = ManipleForms_Locale_Country::getAutoCompleteData();
        if (isset($countries[$value])) {
            foreach ($countries[$value] as $key => $v) {
                if ($key == 'name') {
                    continue;
                }
                $opt .= ' data-' . $key . '="' . $this->view->escape($v) . '"';
            }
        }

        $opt .= '>' . $this->view->escape($label) . "</option>";

        return $opt;
    }
}
