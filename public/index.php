<?php

/**
 * @author Aleksandr Torosh <webtorua@gmail.com>
 */

defined('APPLICATION_ENV') ||
        define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

chdir(dirname(__DIR__));

require_once __DIR__ . '/../app/Bootstrap.php';
Bootstrap::run();