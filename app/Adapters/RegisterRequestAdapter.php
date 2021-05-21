<?php

namespace App\Adapters;

use App\Interfaces\Adapters\AdapterInterface;

class RegisterRequestAdapter implements AdapterInterface {
    static public function transform(array $data): array
    {
        $user = $data['user'] ?? null;
        return [
            'client_name' => $data['name'],
            'address1' => $data['address1'],
            'address2' => $data['address2'],
            'city' => $data['city'],
            'state' => $data['state'],
            'country' => $data['country'],
            'zip' => $data['zipCode'],
            'phone_no1' => $data['phoneNo1'],
            'phone_no2' => $data['phoneNo2'],
            'user' => !!$user ? [
                'first_name' => $user['firstName'],
                'last_name' => $user['lastName'],
                'email' => $user['email'],
                'password' => $user['password'],
                'password_confirmation' => $user['passwordConfirmation'],
                'phone' => $user['phone'],
            ] : null,
        ];
    }
}
