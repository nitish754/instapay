<?php
namespace App\Http\Services;

use App\Model\Board;

class BoardService{
    
    // check if board name is already associated with user 
    public function checkDuplicate($name){
        return Board::checkDuplicate($name);
    }
}