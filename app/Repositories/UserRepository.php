<?php

namespace App\Repositories;

interface UserRepository {

    public function saveuser(array $user, int $roleid , $password);
    public function update(array $userdata ,int $roleid ,$password);
    public function getUser(int $user_id);
}