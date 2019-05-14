<?php

namespace App\Services;

use App\Models\User;
use http\Exception\InvalidArgumentException;
use Illuminate\Database\Eloquent\Model;

//TODO
/*
 * Добавить валидацию до попадания в контроллер
 */

/**
 * Class SaveUserPhoneService
 * @package App\Services
 */
class SaveUserPhoneService
{
    public function create(int $userId, array $userData): Model
    {
        $validatedData = $this->validateData($userData);
        $phone = $this->getPhoneFromData($validatedData);

        $newPhone = User::find($userId)->phones()->create([
            'phone' => $phone
        ]);

        return $newPhone;
    }

    private function validateData(array $data): ?array
    {
        if (count($data) === 0 || array_key_exists('phone', $data) === false) {
            throw new InvalidArgumentException();
        }

        return $data;
    }

    private function getPhoneFromData(array $validatedData): ?string
    {
        $phone = strip_tags($validatedData['phone']);
        $phone = htmlspecialchars($phone);

        return $phone;
    }

}
