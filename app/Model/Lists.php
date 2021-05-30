<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Lists extends Model
{
    protected $guarded = [] ;

    public function tasks(){
        return $this->hasMany(Task::class,"list_id");
    }

    public static function createRecord(array $data){
       return Lists::updateOrCreate(
            [
                "name"=> $data['name'],
                "board_id"=> $data['board_id'],
                "description" => $data['description']
            ]
        );
    }

    public static function updateRecord(array $data){
       $update = Lists::find($data['list_id']);
       $update->name = $data['name'];
       $update->board_id = $data['board_id'];
       $update->description = $data['description'];
       $update->save();
       return $update;
        
    }
    public static function checkDuplicate(string $value,int $board_id){
       return Lists::where("name",$value)
       ->where("board_id",$board_id)
       ->count();
    }

    public static function fetch($board_id){
        return Lists::with(["tasks"])
        ->where("board_id",$board_id)
        ->get();
    }

}
