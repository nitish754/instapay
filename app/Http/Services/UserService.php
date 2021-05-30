<?php

namespace App\Http\Services;

use App\User;

class UserService {
    public function checkifUserExist($key,$value){
       return User::checkDuplicate($key,$value);
    }
}