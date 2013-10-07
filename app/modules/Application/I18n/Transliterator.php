<?php

/**
 * Transliterator
 * @author Aleksandr Torosh <webtorua@gmail.com>
 */

namespace Application\I18n;

class Transliterator
{

    public static function slugify($string)
    {
        $params = 'Any-Latin; NFD; [:Nonspacing Mark:] Remove; NFC; [:Punctuation:] Remove; Lower();';
        $transliterated =
                \Transliterator::create($params)->transliterate($string);

        return preg_replace('/[-\s]+/', '-', $transliterated);

    }

}