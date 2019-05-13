<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PhoneController;


$routes->get('home', '/', [HomeController::class, 'index']);

$routes->get('user.index', '/contact', [UserController::class, 'index']);
$routes->post('user.store', '/contact', [UserController::class, 'store']);
$routes->get('user.view', '/contact/{id}', [UserController::class, 'show'], ['id' => '\d+']);
$routes->put('user.update', '/contact/{id}', [UserController::class, 'update'], ['id' => '\d+']);
$routes->delete('user.delete', '/contact/{id}', [UserController::class, 'destroy'], ['id' => '\d+']);


$routes->post('phone.store', '/contact/{userId}/phone', [PhoneController::class, 'store'], ['userId' => '\d+']);
$routes->delete('phone.delete', '/phone/{id}', [PhoneController::class, 'destroy'], ['id' => '\d+']);
