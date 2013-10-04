<?php

/**
 * Bootstrap
 * @author Aleksandr Torosh <webtorua@gmail.com>
 */
use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\Router;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Php as PhpEngine;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;

class Bootstrap
{

    public static function run()
    {
        $di = new FactoryDefault();

        $loader = new \Phalcon\Loader();
        $loader->registerNamespaces(array(
            // Libraries
            'Zend'          => __DIR__ . '/../vendor/zendframework/zendframework/library/Zend',
            'Application'   => __DIR__ . '/modules/Application',

            // Modules
            'Application'   => __DIR__ . '/modules/Application',
            'Index'         => __DIR__ . '/modules/Index',
            'News'          => __DIR__ . '/modules/News',
        ));
        $loader->registerDirs(
                array(
                    __DIR__ . "/plugins/"
                )
        );
        $loader->register();



        //...

        // Handle the request
        $application = new Application($di);

        $application->registerModules(array(
            'index' => array(
                'className' => 'Index\Module',
                'path'      => __DIR__ . '/modules/Index/Module.php'
            ),
            'news'      => array(
                'className' => 'News\Module',
                'path'      => __DIR__ . '/modules/News/Module.php'
            ),
        ));

        // The core of all the work of the controller occurs when handle() is invoked:
        echo $application->handle()->getContent();

    }

}