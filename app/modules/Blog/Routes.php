<?php

/**
 * Routes
 * @author Aleksandr Torosh <webtorua@gmail.com>
 */

namespace Blog;

class Routes
{

    public function add($router)
    {
        $blog = new \Phalcon\Mvc\Router\Group(array(
            'module'     => 'blog',
            'controller' => 'index'
        ));

        $blog->setPrefix('/blog');

        $blog->add('', array(
            'action' => 'index',
        ))->setName('blog');

        $blog->add('/{slug:[a-z0-9_-]+}.html', array(
            'action' => 'post',
        ))->setName('blog/post');

        $router->mount($blog);

        return $router;

    }

}