<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class ContactController
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(ServerRequestInterface $request)
    {
        $users = $this->userRepository->fetchAll();

        return new JsonResponse($users);
    }

    public function show(ServerRequestInterface $request)
    {
        $id = $request->getAttribute('id');
        $user = $this->userRepository->fetch($id);

        return new JsonResponse($user);
    }

    public function create(ServerRequestInterface $request)
    {
        $user = $this->userRepository->create($request);

        return $user;
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

    public function destroy(ServerRequestInterface $request)
    {
        $id = $request->getAttribute('id');
        $this->userRepository->delete($id);
        return new JsonResponse('', 200);
    }
}