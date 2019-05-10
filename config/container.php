<?php

use App\Container\Container;

$container = new Container();
$container->set('config', require 'config/config.php');

require 'config/services.php';

return $container;