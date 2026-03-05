<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;

class TaskManager extends Controller
{

    public function listTask()
    {
        $authUser = auth()->user();

        if ($authUser->isAdmin()) {
            $users = User::where('role', 'user')
                ->withCount('tasks')
                ->latest()
                ->paginate(10);

            return view('admin.home', compact('users'));
        }

        $tasks = $authUser->tasks()
            ->whereNull('status')
            ->latest()
            ->paginate(3);

        return view('welcome', compact('tasks'));
    }


    public function adminUserTasks($userId)
    {
        $targetUser = User::where('role', 'user')->findOrFail($userId);

        $tasks = Task::where('user_id', $userId)
            ->latest()
            ->paginate(10);

        return view('admin.user-tasks', compact('targetUser', 'tasks'));
    }


    public function addTask()
    {
        // Admin task add korbe na
        if (auth()->user()->isAdmin()) {
            return redirect()->route('home')->with('error', 'Admin task add korte parbe na.');
        }

        return view('tasks.add');
    }


    public function addTaskPost(Request $request)
    {

        if (auth()->user()->isAdmin()) {
            return redirect()->route('home')->with('error', 'Admin task add korte parbe na.');
        }


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
        if ($task->save()) {
            return redirect()->route("home")->with("success", "Task added successfully!");
        }
        return redirect()->route("tasks.add")->with("error", "Failed to add task. Please try again.");

    }


    public function updateTaskStatus($id)
    {
        $authUser = auth()->user();

        // Admin jekono task er status update korte parbe
        // User shudhu nijer task er status update korte parbe
        $query = Task::where('id', $id);

        if ($authUser->isUser()) {
            $query->where('user_id', $authUser->id);
        }

        if ($query->update(['status' => 'completed'])) {
            return redirect()->back()->with('success', 'Task status updated successfully!');
        }

        return redirect()->back()->with('error', 'Failed to update task status. Please try again.');
    }



    public function taskEdit($id)
    {
        $authUser = auth()->user();

        $task = $this->findTaskForUser($id, $authUser);

        if (!$task) {
            return redirect()->route('home')->with('error', 'Task not found.');
        }

        return view('tasks.edit', compact('task'));
    }


    public function taskEditPost(Request $request, $id)
{
    $request->validate([
        'title'       => 'required',
        'description' => 'required',
        'deadline'    => 'required',
    ]);

    $authUser = auth()->user();
    $task = $this->findTaskForUser($id, $authUser);

    if (! $task) {
        return redirect()->route('home')->with('error', 'Task not found.');
    }

    if ($task->update([
        'title'       => $request->input('title'),
        'description' => $request->input('description'),
        'deadline'    => $request->input('deadline'),
    ])) {
        // Admin হলে ওই user এর task page এ ফেরো
        // User হলে নিজের home এ ফেরো
        if ($authUser->isAdmin()) {
            return redirect()->route('admin.user.tasks', $task->user_id)
                ->with('success', 'Task updated successfully!');
        }
        return redirect()->route('home')->with('success', 'Task updated successfully!');
    }

    return redirect()->route('tasks.edit', ['id' => $id])->with('error', 'Failed to update task.');
}


    public function deleteTask($id)
    {
        $authUser = auth()->user();

        $task = $this->findTaskForUser($id, $authUser);

        if (!$task) {
            return redirect()->route('home')->with('error', 'Task not found.');
        }

        if ($task->delete()) {
            return redirect()->back()->with('success', 'Task deleted successfully!');
        }

        return redirect()->back()->with('error', 'Failed to delete task. Please try again.');
    }


    private function findTaskForUser($id, $authUser): ?Task
    {
        $query = Task::where('id', $id);

        // User shudhu nijer task dekhte parbe
        if ($authUser->isUser()) {
            $query->where('user_id', $authUser->id);
        }

        return $query->first();
    }
}