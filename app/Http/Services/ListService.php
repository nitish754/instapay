<?php

namespace App\Http\Services;

use App\Model\Lists;

class ListService {
    public static function checkDuplicate(string $name,int $board_id){
        return Lists::checkDuplicate($name,$board_id);
    }
}