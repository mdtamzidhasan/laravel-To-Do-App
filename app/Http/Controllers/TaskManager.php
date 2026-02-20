<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskManager extends Controller
{
    public function addTask()
    {
        return view("tasks.add");
    }
}