<?php

return new \Phalcon\Config(array(
    'database' => array(
        'adapter'  => 'Mysql',
        'host'     => 'localhost',
        'username' => 'root',
        'password' => '111',
        'name'     => 'phalcon-modular-app',
        'charset'  => 'utf8',
    ),
    'view'     => array(
        'layoutsDir'    => '../../../layouts/',
        'partialsDir'   => '../../../partials/',
        'defaultLayout' => 'main',
    ),
));