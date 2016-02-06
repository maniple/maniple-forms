<?php

abstract class ManipleForms_Locale_Country
{
    protected static $_countries;

    /**
     * @param Zend_Locale|Zend_Translate|Zend_Translate_Adapter|string $locale
     */
    public static function getAll($locale = null) // {{{
    {
        switch (true) {
            case $locale instanceof Zend_Translate:
                $locale = $locale->getAdapter()->getLocale();
                break;

            case $locale instanceof Zend_Translate_Adapter:
                $locale = $locale->getLocale();
                break;

            case null === $locale:
                if (Zend_Registry::isRegistered('Zend_Locale')) {
                    $locale = Zend_Registry::get('Zend_Locale');
                }
                break;
        }

        if (!$locale instanceof Zend_Locale) {
            $locale = new Zend_Locale($locale);
        }

        $language = $locale->getLanguage();

        if (null === self::$_countries[$language]) {
            $countries = Zend_Locale::getTranslationList('Territory', $language, 2);

            // remove invalid countries
            // CT = Canton and Enderbury Islands (from 1979 part of Republic of Kiribati)
            // DD = East Germany
            // FQ = French Southern and Antarctic Territories
            // NQ = Queen Maud Land (Norwegian claimed region of Antarctica)
            // PZ = Panama Canal Zone (1903–1979)
            // SU = USSR
            // VD = North Vietnam
            // YD = People's Democratic Republic of Yemen (1967 - 1990)
            // ZZ = Unknown or Invalid Region

            foreach (array('CT', 'DD', 'FQ', 'NQ', 'PZ', 'SU', 'VD', 'YD', 'ZZ') as $invalid) {
                if (isset($countries[$invalid])) {
                    unset($countries[$invalid]);
                }
            }

            if (empty($countries['UK'])) {
                $countries['UK'] = 'United Kingdom';
            }

            switch ($language) {
                case 'pl':
                    // remove SAR part from China administered country names, as
                    // it is not obligatory, see:
                    // http://en.wikipedia.org/wiki/Hong_Kong#cite_note-1
                    foreach ($countries as &$country) {
                        $country = str_ireplace(
                            array(', Specjalny Region Administracyjny Chin', ' SAR'), '', $country);
                    }
                    unset($country);
                    break;

                case 'en':
                    foreach ($countries as &$country) {
                        $country = str_ireplace(' SAR China', '', $country);
                    }
                    unset($country);
                    break;
            }

            // this of course won't work on Windows, see:
            // https://bugs.php.net/bug.php?id=46165
            asort($countries, SORT_LOCALE_STRING);

            self::$_countries[$language] = $countries;
        }

        return self::$_countries[$language];
    } // }}}

    /**
     * @param  string $code
     * @param  Zend_Locale|Zend_Translate|Zend_Translate_Adapter|string $locale
     * @return string
     */
    public static function get($code, $locale = null) // {{{
    {
        $countries = self::getAll($locale);
        return isset($countries[$code]) ? $countries[$code] : false;
    } // }}}

    /**
     * @return array
     */
    public static function getAutoCompleteData() // {{{
    {
        return include dirname(__FILE__) . '/Country/autocomplete.inc.php';
    } // }}}
}
