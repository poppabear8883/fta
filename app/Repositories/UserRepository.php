<?php

namespace App\Repositories;

use App\Traits\NotifiesUsers;
use App\User;

class UserRepository implements UserRepositoryInterface {

    use NotifiesUsers;

    private $userRepository;

    public function __construct(UserRepositoryInterface $user) {
        $this->userRepository = $user;
    }

    public function findOrFail($id)
    {
        return User::findOrFail($id);
    }

    public function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'bidder_number' => $data['bidder_number'],
            'phone_number' => $data['phone_number'],
            'timezone' => $data['timezone'],
        ]);

        $this->notifyUserRegistered($user);

        return $user;
    }

    public function update($id, array $data)
    {
        $user = $this->findOrFail($id);
        $user->fill($data)->save();
        return $user;
    }

    public function destroy($id)
    {
        // TODO: Implement destroy() method.
    }
}