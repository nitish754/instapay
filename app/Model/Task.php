<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];

    public static function createTask(array $data)
    {
        return Task::create([
            "title" => $data['title'],
            "list_id" => $data['list_id'],
            "description" => $data['description'],
            "priority" => $data['priority'],
        ]);
    }

    public static function updateTask(array $data)
    {
        $update = Task::find($data["task_id"]);
        $update->title = $data['title'];
        $update->list_id = $data['list_id'];
        $update->description = $data['description'];
        $update->priority = $data['priority'];
        return $update;
    }

    public static function fetch($list_id)
    {
        return Task::where("list_id", $list_id)->get();
    }
}
