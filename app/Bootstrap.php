<?php

/**
 * Bootstrap
 * @author Aleksandr Torosh <webtorua@gmail.com>
 */
use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\Router;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Mvc\View;

class Bootstrap
{

    public static function run()
    {
        // DI Container
        $di = new FactoryDefault();

        // Loader, registering namespaces
        $loader = new \Phalcon\Loader();
        $loader->registerNamespaces(array(
            // Libraries
            'Zend'        => __DIR__ . '/../vendor/zendframework/zendframework/library/Zend',
            // Modules
            'Application' => __DIR__ . '/modules/Application',
            'Index'       => __DIR__ . '/modules/Index',
            'News'        => __DIR__ . '/modules/News',
        ));
        $loader->registerDirs(
                array(
                    __DIR__ . "/plugins/"
                )
        );
        $loader->register();

        $application = new Application();

        // Registering modules
        $application->registerModules(array(
            'index' => array(
                'className' => 'Index\Module',
                'path'      => __DIR__ . '/modules/Index/Module.php'
            ),
            'news'  => array(
                'className' => 'News\Module',
                'path'      => __DIR__ . '/modules/News/Module.php'
            ),
        ));

        // Routing
        $router = new Router(true);

        /* $router->setDefaultModule('index');
          $router->setDefaultController('index');
          $router->setDefaultAction('index'); */

        //Дефолтный роутер
        /* $router->add('/:module/:controller/:action(/:params)?', array(
          'module'     => 1,
          'controller' => 2,
          'action'     => 3,
          'params'     => 5
          ))->setName('default'); */

        foreach ($application->getModules() as $module) {
            $className = str_replace('Module', 'Routes', $module['className']);
            if (class_exists($className)) {
                $class  = new $className();
                $router = $class->init($router);
            }
        }
        $di->set('router', $router);

        // URL component
        $di->set('url', function() {
                    $url = new UrlResolver();
                    $url->setBaseUri('/');
                    $url->setBasePath('/');
                    return $url;
                }, true);

        // View
        $view = new View();
        $view->setLayoutsDir('/../../../layouts/'); // директория с layout
        $view->setPartialsDir('../../../partials/'); // директория с partial
        $view->setLayout('main');

        //Регистрация движков вывода (rendering engines)
        $view->registerEngines(array(
            ".phtml" => 'Phalcon\Mvc\View\Engine\Volt',
        ));

        $di->set('view', $view);

        // Handle the request
        $application->setDI($di);

        // The core of all the work of the controller occurs when handle() is invoked:
        echo $application->handle()->getContent();

    }

}