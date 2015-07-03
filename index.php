<?php

define('PUBLIC_PATH', realpath(dirname(__FILE__)));
define('APPLICATION_PATH', PUBLIC_PATH . '/app/');

require_once 'debug.php';
require_once 'autoload.php';

$app = new \Core\Application();
$app->run();