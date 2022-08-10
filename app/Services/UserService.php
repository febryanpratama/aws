<?php

namespace App\Services;

use App\Models\User;

class UserService
{

    public function getUser()
    {
        $title = "User List";
        $data = User::get();

        $status = true;
        $message = 'Success Get Users';
        $result = [
            'status' => $status,
            'message' => $message,
            'data' => $data,
            'title' => $title
        ];

        return $result;
    }
}
