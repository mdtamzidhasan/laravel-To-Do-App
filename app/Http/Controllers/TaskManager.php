<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;

class TaskManager extends Controller
{

    public function listTask()
    {
        $tasks = Task::where("user_id", auth()->user()->id)->where("status", NULL)->paginate(3);
        return view("welcome", compact("tasks"));
    }
    public function addTask()
    {
        return view("tasks.add");
    }


    public function addTaskPost(Request $request)
    {
        $request->validate([
            "title" => "required",
            "description" => "required",
            "deadline" => "required"
        ]);

        

        $task = new Task();
        $task->title = $request->input("title");
        $task->description = $request->input("description");
        $task->deadline = $request->input("deadline");
        $task->user_id = auth()->user()->id;
        if($task->save()) {
            return redirect()->route("home")->with("success", "Task added successfully!");
        }
        return redirect()->route("tasks.add")->with("error", "Failed to add task. Please try again.");
        
    }


    public function updateTaskStatus($id)
    {
        if(Task::where("user_id", auth()->user()->id)->where("id", $id)->update(["status" => "completed"])) {
            return redirect()->route("home")->with("success", "Task status updated successfully!");
        }
        return redirect()->route("home")->with("error", "Failed to update task status. Please try again.");
    }


    public function taskEdit($id)
    {
        $task = Task::where("user_id", auth()->user()->id)->where("id", $id)->first();
        if($task) {
            return view("tasks.edit", compact("task"));
        }
        return redirect()->route("home")->with("error", "Task not found.");
    }
    

    public function taskEditPost(Request $request, $id)
    {
        $request->validate([
            "title" => "required",
            "description" => "required",
            "deadline" => "required"
        ]);

        if(Task::where("user_id", auth()->user()->id)->where("id", $id)->update([
            "title" => $request->input("title"),
            "description" => $request->input("description"),
            "deadline" => $request->input("deadline")
        ])) {
            return redirect()->route("home")->with("success", "Task updated successfully!");
        }
        return redirect()->route("tasks.edit", ["id" => $id])->with("error", "Failed to update task. Please try again.");
    }


    public function deleteTask($id)
    {
        if(Task::where("user_id", auth()->user()->id)->where("id", $id)->delete()) {
            return redirect()->route("home")->with("success", "Task deleted successfully!");
        }
        return redirect()->route("home")->with("error", "Failed to delete task. Please try again.");
    }
}