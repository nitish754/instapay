<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ListRequest;
use App\Http\Services\ListService;
use App\Model\Lists;
use Illuminate\Http\Request;

class ListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($board_id)
    {
        $list = Lists::fetch($board_id);
        if(count($list) > 0){
            $response["message"] = "List found successfully";
            $response['data'] = $list;
            return response()->json($response,200);
        }
        return response(["message"=>"List not found"]);
    }


//    store record 
    public function store(ListRequest $request)
    {
        if(ListService::checkDuplicate($request->name,$request->board_id) == 0){
           $list = Lists::createRecord(["name"=>$request->name,"board_id"=>$request->board_id,"description"=>$request->description]);
           $response["message"]= "List created successfully";
           $response["list"]= $list;
           return response()->json($response,200);
        }else{
            $response["message"] = "This List is already exist";
            return response()->json($response,200);
        }
    }


    /* update list  */
    public function update(ListRequest $request, $id)
    {
        // return json_encode(ListService::checkDuplicate($request->name,$request->board_id));
        if(ListService::checkDuplicate($request->name,$request->board_id) > 1 || ListService::checkDuplicate($request->name,$request->board_id) == 0){
            $list = Lists::updateRecord(["name"=>$request->name,"board_id"=>$request->board_id,"description"=>$request->description,"list_id"=>$id]);
            $response["message"]= "List udated successfully";
            $response["list"]= $list;
            return response()->json($response,200);
         }else{
             $response["message"] = "This List is already exist ";
             return response()->json($response,200);
         }
    }

    /* delete list */
    public function destroy($id)
    {
        Lists::destroy($id);
        return response()->json(["message"=>"List deleted successfully"]);
    }
}
