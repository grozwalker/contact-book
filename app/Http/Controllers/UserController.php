<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Services\SaveUserPhoneService;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class UserController
{
    private $userRepository;
    /**
     * @var SaveUserPhoneService
     */
    private $saveUserPhoneService;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->saveUserPhoneService = $saveUserPhoneService;
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

    public function store(ServerRequestInterface $request)
    {
        $data = $request->getParsedBody();
        $user = $this->userRepository->create($data);

        return new JsonResponse($user);
    }

    public function edit()
    {

    }

    public function update(ServerRequestInterface $request)
    {
        $id = $request->getAttribute('id');
        $data = $request->getParsedBody();

        $user = $this->userRepository->update($id, $data);

        return new JsonResponse($user);
    }

    public function destroy(ServerRequestInterface $request)
    {
        $id = $request->getAttribute('id');
        $this->userRepository->delete($id);
        return new JsonResponse('', 200);
    }
}
