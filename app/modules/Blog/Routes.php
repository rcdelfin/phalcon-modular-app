<?php

/**
 * Routes
 * @copyright Copyright (c) 2011 - 2012 Aleksandr Torosh (http://wezoom.com.ua)
 * @author Aleksandr Torosh <webtorua@gmail.com>
 */

namespace Blog;

class Routes
{

    public function add($router)
    {
        // Homepage router
        $router->add('/blog/{slug:[a-z0-9_-]+}\.html', array(
            'module'     => 'blog',
            'controller' => 'index',
            'action'     => 'post',
        ))->setName('home');

        return $router;

    }

}