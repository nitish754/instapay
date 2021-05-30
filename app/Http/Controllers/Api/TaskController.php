<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($list_id)
    {
        $task=Task::fetch($list_id);
        if(count($task) > 0){
            $response['message'] = "Task found successfully";
            $response["data"] = $task;
            return response()->json($response,200);
        }else {
            return response()->json(["message"=> "No task found"]);
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $task = Task::createTask(["title"=>$request->title,"list_id"=>$request->list_id,"description"=>$request->description,"priority"=>$request->priority]);
        $response['message'] = "Task created successfully";
        $response["data"] = $task;
        return response()->json($response,200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $task = Task::updateTask(["title"=>$request->title,"list_id"=>$request->list_id,"description"=>$request->description,"priority"=>$request->priority,"task_id"=>$id]);
        $response['message'] = "Task updated successfully";
        $response["data"] = $task;
        return response()->json($response,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Task::destroy($id);
        return response()->json(["message"=>"Task deleted successfully"]);
    }
}
