<?php

namespace App\UseCases\Admin;

use App\Models\User;
use Exception;
use Illuminate\Support\Str;

class CreateAdminUseCase
{
    /**
     * @throws Exception
     * @param array<string, string> $data
     */
    public function __invoke(array $data): \Illuminate\Database\Eloquent\Model|User
    {
        $data['uuid'] = $this->uuid();

        try {
            return User::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'is_admin' => true,
                'uuid' => $data['uuid'],
                'email' => $data['email'],
                'password' => $data['password'],
                'avatar' => $data['avatar'],
                'address' => $data['address'],
                'phone_number' => $data['phone_number'],
            ]);
        }catch (Exception $exception){
            throw  new Exception($exception->getMessage(), 500);
        }

    }

    public function uuid(): string
    {
        return Str::uuid()->toString();
    }
}
