<?php

/**
 * Routes
 * @author Aleksandr Torosh <webtorua@gmail.com>
 */

namespace Index;

class Routes
{

    public function add($router)
    {
        // Homepage router
        $router->add('/', array(
            'module'     => 'index',
            'controller' => 'index',
            'action'     => 'index',
        ))->setName('home');

        return $router;

    }

}