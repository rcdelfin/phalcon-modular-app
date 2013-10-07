<?php

/**
 * @author Aleksandr Torosh <webtorua@gmail.com>
 */

namespace Blog;

use Phalcon\Mvc\ModuleDefinitionInterface;

class Module implements ModuleDefinitionInterface
{

    public function registerAutoloaders()
    {
        // Registers an autoloader related to the module
    }

    public function registerServices($di)
    {
        $dispatcher = $di->get('dispatcher');
        $dispatcher->setDefaultNamespace("Blog\Controller");
        $di->set('dispatcher', $dispatcher);

        $view = $di->get('view');
        $view->setViewsDir(__DIR__ . '/views/');
        $di->set('view', $view);

    }

}