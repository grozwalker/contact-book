<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;


$routes->get('home', '/', [HomeController::class, 'index']);

$routes->get('contact.index', '/contact', [ContactController::class, 'index']);
$routes->get('contact.view', '/contact/{id}', [ContactController::class, 'show'], ['id' => '\d+']);
