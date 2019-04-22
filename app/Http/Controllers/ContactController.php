<?php

namespace App\Http\Controllers;

use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;

class ContactController
{
    public function show(ServerRequestInterface $request)
    {
        $id = $request->getAttribute('id');
        if ($id > 5) {
            return new JsonResponse(['error' => 'Undefined Page'], 404);
        } else {
            return new JsonResponse(['id' => $id, 'title' => 'Article #' . $id]);

        }
    }

    public function create()
    {

    }

    public function store()
    {
        
    }

    public function edit()
    {
        
    }

    public function update()
    {
        
    }

    public function destroy()
    {
        
    }
}