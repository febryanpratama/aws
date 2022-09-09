<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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

    public function addUser($data)
    {

        $validator = Validator::make($data, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|same:re-password',
            'level'     => 'required|in:admin,user'
        ]);

        if ($validator->fails()) {
            # code...
            // dd($validator->errors());
            return [
                'status' => false,
                'message' => $validator->errors()->first(),
            ];
        }

        $data['password'] = Hash::make($data['password']);

        // dd("ok");
        User::create($data);

        $status = true;
        $message = 'Success Add User';

        $result = [
            'status' => $status,
            'message' => $message,

        ];

        return $result;
    }

    public function getUserById($user_id)
    {
        $data = User::findOrFail($user_id);

        if ($data == null) {
            # code...
            $status = false;
            $message = 'User Not Found';
            $result = [
                'status' => $status,
                'message' => $message,
            ];
            return $result;
        }

        $status = true;
        $message = 'Success Get User';
        $result = [
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ];

        return $result;
    }

    public function updateUser($data)
    {
        $validator = Validator::make($data, [
            'user_id' => 'required|numeric|exists:users,id',
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $data['user_id'],
            'password' => 'nullable|min:6|same:re-password',
            'level'     => 'required|in:admin,user'
        ]);

        if ($validator->fails()) {
            # code...
            return [
                'status' => false,
                'message' => $validator->errors()->first(),
            ];
        }
        if (array_key_exists('password', $data)) {
            $data['password'] = Hash::make($data['password']);
        }

        User::findOrFail($data['user_id'])->update($data);

        $status = true;
        $message = 'Success Update User';
        $result = [
            'status' => $status,
            'message' => $message,
        ];

        return $result;
    }
}
