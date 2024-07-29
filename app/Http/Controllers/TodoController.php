<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    public function index() {
        $table_data = $this->table_data();
        return view('todo', compact('table_data'));
    }

    private function table_data($all = null) {
        if($all==null) {
            $data = Todo::orderBy('id', 'DESC')->where('status', '')->get();
        } else {
            $data = Todo::orderBy('id', 'DESC')->get();
        }
        $data =  view('table_data', compact('data'))->render();
        return $data;
    }

    public function store(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'task'=>'required|unique:todos,task'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $todo = new Todo;
        $todo->task = $request->task;
        $result = $todo->save();
        if($result) {

            $table_data = $this->table_data();

            $res = json_encode([
                'status'=>1,
                'message'=>'Task created.',
                'table_data'=>$table_data
            ]);
        } else {
            $res = json_encode([
                'status'=>0,
                'message'=>'Task not created. Try again..'
            ]);
        }
        return $res;
    }
    public function delete(Request $request) {
        $result = Todo::where('id', $request->id)->delete();
        
        if($result) {

            $table_data = $this->table_data();

            $res = json_encode([
                'status'=>1,
                'message'=>'Task Deleted.',
                'table_data'=>$table_data
            ]);
        } else {
            $res = json_encode([
                'status'=>0,
                'message'=>'Task not deleted. Try again..'
            ]);
        }
        return $res;
    }

    public function update(Request $request) {
        $result = Todo::where('id', $request->id)->update(['status'=>'done']);

        if($result) {

            $table_data = $this->table_data();

            $res = json_encode([
                'status'=>1,
                'message'=>'Task Completed.',
                'table_data'=>$table_data
            ]);
        } else {
            $res = json_encode([
                'status'=>0,
                'message'=>'Task not completed. Try again..'
            ]);
        }
        return $res;
    }

    public function show_all() {
        $table_data = $this->table_data('all');
        $res = json_encode([
            'status'=>1,
            'message'=>'',
            'table_data'=>$table_data
        ]);
        return $res;
    }
}
