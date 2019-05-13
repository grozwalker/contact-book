<?php

namespace App\Http\Controllers;

use App\Models\Phone;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\SaveUserPhoneService;
use PDO;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class PhoneController
{
    private $saveUserPhoneService;

    public function __construct(SaveUserPhoneService $saveUserPhoneService)
    {
        $this->saveUserPhoneService = $saveUserPhoneService;
    }

    public function store(ServerRequestInterface $request)
    {
        $userId = $request->getAttribute('userId');
        $data = $request->getParsedBody();

        $newPhone = $this->saveUserPhoneService->create($userId, $data);

        return new JsonResponse($newPhone, 200);
    }

    public function destroy(ServerRequestInterface $request)
    {
        $id = $request->getAttribute('id');
        Phone::find($id)->delete();

        return new JsonResponse('', 200);
    }
}
