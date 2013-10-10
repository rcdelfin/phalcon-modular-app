<?php

/**
 * Helper
 * @author Aleksandr Torosh <webtorua@gmail.com>
 */

namespace Application\Mvc;

class Helper
{

    public function announce($incomeString, $num)
    {
        $helper = new \Blog\Helper\Announce();
        return $helper($incomeString, $num);

    }

}