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
        return Board::create([
            "name" => $data["name"],
            "user_id" => auth()->guard('api')->user()->id,
            "visibility" => $data['visibility'],
            "description" => $data['description']
        ]);
    }

    public static function updateRecord(array $data)
    {
        $update = Board::find($data['board_id']);
        $update->name = $data["name"];
        $update->user_id = auth()->guard('api')->user()->id;
        $update->visibility = $data["visibility"];
        $update->description = $data["description"];
        $update->save();
        return $update;
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
