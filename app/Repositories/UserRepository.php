<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function fetchAll()
    {
        return User::with('phones')->get();
    }

    public function fetch(int $id)
    {
        return User::find($id);
    }

    public function delete($id)
    {
        User::find($id)->delete();
    }
}
