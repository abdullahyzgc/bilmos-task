<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function getAllUsers()
    {
        return User::latest()->paginate(10);
    }

    public function createUser(array $data)
    {
        try {
            DB::beginTransaction();

            $data['password'] = Hash::make($data['password']);
            $user = User::create($data);

            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateUser(User $user, array $data)
    {
        try {
            DB::beginTransaction();

            if (empty($data['password'])) {
                unset($data['password']);
            } else {
                $data['password'] = Hash::make($data['password']);
            }

            $user->update($data);

            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteUser(User $user)
    {
        try {
            DB::beginTransaction();
            
            $user->delete();
            
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getUserWithAttendance(User $user)
    {
        return $user->load(['attendanceLogs' => function ($query) {
            $query->orderBy('check_in', 'desc');
        }]);
    }
} 