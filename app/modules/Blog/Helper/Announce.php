<?php

/**
 * Announce
 * @author Aleksandr Torosh <webtorua@gmail.com>
 */

namespace Blog\Helper;

class Announce
{

    public function __invoke($incomeString, $num = 300)
    {
        $string = strip_tags($incomeString);
        if (!$string) {
            return;
        }

        if (mb_strlen($string,'utf-8') < $num) {
            return $string;
        }

        $subString = mb_substr($string, 0, $num, 'utf-8');
        $array = explode(' ', $subString);

        $array[count($array) - 1] = '...';
        $output = implode(' ', $array);

        return $output;

    }

}