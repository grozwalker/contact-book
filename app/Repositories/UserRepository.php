<?php

namespace App\Repositories;

use App\Models\User;

//TODO
/*
 * На самом деле не уверен, что правильно применяю здесь этот паттерн.
 * Я так понимаю, что репозиторий нужен для работы с данными, чтобы
 * отвзятаться от способа получения данных (поэтому возвращаю не модели, а массивы),
 * но и не должно быть логики и какой-то обработки,
 * так что возможно эти модули можно было поместить или в контроллеры или в сервис.
 *
 * Но решил показать, что знаю, что есть такой паттерн. Возможно зря
 */

/**
 * Class UserRepository
 * @package App\Repositories
 */
class UserRepository
{
    public function fetchAll(): array
    {
        return User::with('phones')->orderBy('first_name')->orderBy( 'last_name')->get()->toArray();
    }

    public function fetch(int $id): array
    {
        return User::find($id)->toArray();
    }

    public function create($data): array
    {
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'comment' => $data['comment'],
        ]);

        return $user->toArray();
    }

    public function update($id, $data): array
    {
        User::find($id)->update([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'comment' => $data['comment'],
        ]);

        return [];
    }

    public function delete($id)
    {
        User::find($id)->delete();
    }
}
