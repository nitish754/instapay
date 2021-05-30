<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BoardRequest;
use App\Http\Services\BoardService;
use App\Model\Board;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    public $board;
    function __construct(BoardService $board)
    {
        return $this->board = $board;
    }
    // fetch list 
    public function index()
    {
        if (count(Board::fetch()) > 0) {
            $response['message'] = "Board found successfully";
            $response['board'] = Board::fetch();
            return response()->json($response, 200);
        } else {
            $response['message'] = "No Board found";
            return response()->json($response, 404);
        }
    }

    // store board in table
    public function store(BoardRequest $request)
    {
        if ($this->board->checkDuplicate($request->name) == 0) {
            $board = Board::createRecord(["name" => $request->name, "visibility" => $request->visibility, "description" => $request->description]);
            if ($board) {
                $response['board'] = $board;
                $response['message'] = "board created successfully";
                return response()->json($response, 200);
            } else {
                $response['error'] = "something went wrong";
                return response()->json($response, 500);
            }
        } else {
            $response["error"] = "This board is alreday exist with this user";
            return response()->json($response, 200);
        }
    }


    // update resource 
    public function update(BoardRequest $request, $id)
    {
        if ($this->board->checkDuplicate($request->name) == 1) {
            $board = Board::updateRecord(["board_id" => $id, "name" => $request->name, "visibility" => $request->visibility, "description" => $request->description]);
            if ($board) {
                $response['board'] = $board;
                $response['message'] = "board updated successfully";
                return response()->json($response, 200);
            } else {
                $response['error'] = "something went wrong";
                return response()->json($response, 500);
            }
        } else {
            $response["error"] = "This board is alreday exist with this user";
            return response()->json($response, 200);
        }
    }
    /* 
        I am using permanent delete we can use soft delete instead
    */
    // delete resource
    public function destroy($id)
    {
        Board::destroy($id);
        return response(["message" => "Board deleted successfully"], 200);
    }
}
