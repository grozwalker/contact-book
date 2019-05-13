<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class UserController
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(ServerRequestInterface $request): JsonResponse
    {
        $users = $this->userRepository->fetchAll();

        return new JsonResponse($users);
    }

    public function show(ServerRequestInterface $request): JsonResponse
    {
        $id = $request->getAttribute('id');
        $user = $this->userRepository->fetch($id);

        return new JsonResponse($user);
    }

    public function store(ServerRequestInterface $request): JsonResponse
    {
        $data = $request->getParsedBody();
        $user = $this->userRepository->create($data);

        return new JsonResponse($user);
    }

    public function update(ServerRequestInterface $request): JsonResponse
    {
        $id = $request->getAttribute('id');
        $data = $request->getParsedBody();

        $user = $this->userRepository->update($id, $data);

        return new JsonResponse($user);
    }

    public function destroy(ServerRequestInterface $request): JsonResponse
    {
        $id = $request->getAttribute('id');
        $this->userRepository->delete($id);

        return new JsonResponse('', 200);
    }
}
