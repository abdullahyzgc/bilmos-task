<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = $this->userService->getAllUsers();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(StoreUserRequest $request)
    {
        try {
            $this->userService->createUser($request->validated());
            return redirect()->route('admin.users.index')
                ->with('success', 'Personel başarıyla eklendi.');
        } catch (\Exception $e) {
            return back()->with('error', 'Personel eklenirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            $this->userService->updateUser($user, $request->validated());
            return redirect()->route('admin.users.index')
                ->with('success', 'Personel bilgileri güncellendi.');
        } catch (\Exception $e) {
            return back()->with('error', 'Personel güncellenirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    public function destroy(User $user)
    {
        try {
            $this->userService->deleteUser($user);
            return redirect()->route('admin.users.index')
                ->with('success', 'Personel silindi.');
        } catch (\Exception $e) {
            return back()->with('error', 'Personel silinirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    public function show(User $user)
    {
        $user = $this->userService->getUserWithAttendance($user);
        return view('admin.users.show', compact('user'));
    }
}
