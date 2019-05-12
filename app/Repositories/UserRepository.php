<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function fetchAll()
    {
        return User::all();
    }

    public function fetch(int $id)
    {
        return User::find($id);
    }
}
