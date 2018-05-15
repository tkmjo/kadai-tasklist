<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class TasksController extends Controller
{
    public function index() {
        $data = [];
        if (\Auth::check()) {
            $user = \Auth::user();
            $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);
            
            $data = [
                'user' => $user,
                'tasks' => $tasks,
            ];
            return view('tasks.index', $data);
        } else {
            return view('welcome');
        }
    }
    
    public function show($id) {
        $user = \Auth::user();
        $task = $user->tasks()->find($id);
        
        $data = [
            'user' => $user,
            'task' => $task,
        ];
        
        if ($task != null) {
            return view('tasks.show', $data);
        } else {
            return redirect('/');
        }
        
    }
    
    public function create() {
        $task = new Task;
        
        return view('tasks.create', [
            'task' => $task, 
        ]);
    }
    
    public function store(Request $request) {
        $this->validate($request, [
            'status' => 'required', 
        ]);
        
        $request->user()->tasks()->create([
            'status' => $request->status,
            'content' => $request->content,
        ]);
        
        /*
        $task = new Task;
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();
        */
        
        return redirect('/');   //==============================================
    }
    
    public function edit($id) {
        $task = Task::find($id);
        
        
        if ($task != null && \Auth::user()->id === $task->user_id) {
            return view('tasks.edit', [
                'task' => $task,
            ]);
        } else {
            return redirect('/');
        }
    }
    
    public function update(Request $request, $id) {

        $this->validate($request, [
            'status' => 'required', 
        ]);
        
        $request->user()->tasks()->find($id)->update([
            'status' => $request->status,
            'content' => $request->content,
        ]);
        
        return redirect('/');  //==============================================
    }
    
    public function destroy($id) {
        $task = Task::find($id);
        
        if (\Auth::user()->id === $task->user_id) {
            $task->delete();
        }
        
        return redirect('/');  //==============================================
    }
}
