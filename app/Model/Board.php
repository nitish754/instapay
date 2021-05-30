<?php

namespace App\Model;

use App\Model\Lists;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    protected $guarded = []; //allow all coulum to be insertable and readable

    public function lists()
    {
        return $this->hasMany(Lists::class, "board_id");
    }

    public static function createRecord(array $data)
    {
        return Board::updateOrCreate(
            ["id"=>$data["board_id"]],
            [
            "name" => $data["name"],
            "user_id" => auth()->guard('api')->user()->id,
            "visibility" => $data['visibility'],
            "description" => $data['description']
        ]);
    }

    public static function checkDuplicate($value)
    {
        return Board::where("name", $value)->count();
    }

    public static function fetch()
    {
        return  Board::with(['lists'])
            ->where("user_id", auth()->guard('api')->user()->id)
            ->get();
    }

   
}
