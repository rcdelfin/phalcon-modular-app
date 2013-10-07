<?php

/**
 * Bootstrap
 * @author Aleksandr Torosh <webtorua@gmail.com>
 */
class Bootstrap
{

    public static function run()
    {
        $debug = new Phalcon\Debug();
        $debug->listen();

        $config = include __DIR__ . '/config/application.php';

        // DI Container
        $di = new Phalcon\DI\FactoryDefault();

        // Loader, registering namespaces
        $loader = new Phalcon\Loader();
        $loader->registerNamespaces(array(
            // Libraries
            'Zend'        => __DIR__ . '/../vendor/zendframework/zendframework/library/Zend',
            // Modules
            'Application' => __DIR__ . '/modules/Application',
            'Index'       => __DIR__ . '/modules/Index',
            'Blog'        => __DIR__ . '/modules/Blog',
        ));
        $loader->register();

        $application = new Phalcon\Mvc\Application();

        // Registering modules
        $application->registerModules(array(
            'index' => array(
                'className' => 'Index\Module',
                'path'      => __DIR__ . '/modules/Index/Module.php'
            ),
            'blog'  => array(
                'className' => 'Blog\Module',
                'path'      => __DIR__ . '/modules/Blog/Module.php'
            ),
        ));

        // Routing
        $router = new Phalcon\Mvc\Router(true);

        $router->setDefaultModule('index');
        $router->setDefaultController('index');
        $router->setDefaultAction('index');

        foreach ($application->getModules() as $module) {
            $className = str_replace('Module', 'Routes', $module['className']);
            if (class_exists($className)) {
                $class  = new $className();
                $router = $class->add($router);
            }
        }
        $di->set('router', $router);

        // URL component
        $di->set('url', function() {
                    $url = new Phalcon\Mvc\Url();
                    $url->setBaseUri('/');
                    $url->setBasePath('/');
                    return $url;
                }, true);

        // View
        $view = new Phalcon\Mvc\View();
        $view->setLayoutsDir('/../../../layouts/'); // path with layouts
        $view->setPartialsDir('../../../partials/'); // relative path with partials
        $view->setLayout('main'); // default layout
        // rendering engines
        $view->registerEngines(array(
            ".phtml" => 'Phalcon\Mvc\View\Engine\Volt', // you can use .volt files extension
                //".phtml" => 'Phalcon\Mvc\View\Engine\Php', // default php rendering engine
        ));
        $di->set('view', $view);

        // Database
        $di->set('db', function() use ($config) {
                    return new DbAdapter(array(
                        'host'     => $config->database->host,
                        'username' => $config->database->username,
                        'password' => $config->database->password,
                        'dbname'   => $config->database->name,
                        'charset'  => $config->database->charset,
                    ));
                });

        // Cache
        $cache = new Phalcon\Cache\Backend\Memcache(
                new Phalcon\Cache\Frontend\Data(array(
            "lifetime" => 60,
            "prefix"   => 'phalcon-modular-app',
                )), array(
            "host" => "localhost",
            "port" => "11211"
        ));
        $di->set('cache', $cache);
        // $di->set('viewCache', $cache); // optional
        $di->set('modelsCache', $cache); //
        // ModelsMetadata
        $modelsMetadata = new Phalcon\Mvc\Model\Metadata\Memory();
        /**
         * You can use APC for production
         *
         * $modelsMetadata = new Phalcon\Mvc\Model\MetaData\Apc(array(
         *     "lifetime" => 60,
         *     "prefix"   => "phalcon-modular-app"
         * ));
         */
        $di->set('modelsMetadata', $modelsMetadata);

        // Session
        $di->setShared('session', function() {
                    $session = new Phalcon\Session\Adapter\Files();
                    $session->start();
                    return $session;
                });

        // Flash messenger
        $di->set('flash', function() {
                    $flash = new Phalcon\Flash\Session(array(
                        'error'   => 'alert alert-error',
                        'success' => 'alert alert-success',
                        'notice'  => 'alert alert-info',
                    ));
                    return $flash;
                });

        // Helpers
        // Your own helpers. Using: $this->helper->myHelper();
        $di->set('helper', new Application\Mvc\Helper());

        // Handle the request
        $application->setDI($di);

        // The core of all the work of the controller occurs when handle() is invoked:
        echo $application->handle()->getContent();

    }

}