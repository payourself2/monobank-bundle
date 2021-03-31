<?php

require dirname(__DIR__) . '/vendor/autoload.php';

if (file_exists(dirname(__DIR__) . '/config/bootstrap.php')) {
    require dirname(__DIR__) . '/config/bootstrap.php';
}

if(!defined('PAYOURSELF2_FIXTURES_PATH')){
    define('PAYOURSELF2_FIXTURES_PATH', __DIR__ . '/Fixtures');
}
