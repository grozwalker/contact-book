<?php

use App\Container\Container;

$settings = array_merge(require 'config/config.php', require 'config/services.php');

$container = new Container($settings);

return $container;