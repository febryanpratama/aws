<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $data = $this->userService->getUser();

        return view('pages.user.index', [
            'data' => $data['data'],
            'title' => $data['title']
        ]);
    }

    public function create()
    {
        // $data = $this->userService->createUser();
        return view('pages.user.form', [
            'title' => 'Create User',
            'data' => null,
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // 
        $result = $this->userService->addUser($request->all());

        if ($result['status']) {
            # code...
            return redirect()->route('user.index')->with('success', $result['message']);
        } else {
            return redirect()->back()->with('error', $result['message']);
        }
        // return redirect('/user')->withSuccess($result['message']);
    }

    public function edit($user_id)
    {
        $data = $this->userService->getUserById($user_id);
        return view('pages.user.form', [
            'data' => $data['data'],
            'title' => 'Edit User'
        ]);
    }

    public function update(Request $request)
    {
        $data = collect(request()->all())->filter()->all();
        // dd($data);

        $result = $this->userService->updateUser($data);

        return redirect('user')->withSuccess($result['message']);
    }
}
