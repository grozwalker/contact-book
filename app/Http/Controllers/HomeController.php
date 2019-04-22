<?php

namespace App\Http\Controllers;

use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class HomeController
{
    public function index(ServerRequestInterface $request)
    {
        $blog = [
            ['id' => 1, 'title' => 'First article'],
            ['id' => 2, 'title' => 'Second article'],
        ];

        return new JsonResponse($blog);
    }
}