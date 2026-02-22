@extends("layouts.default")
@section("content")
<div class="d-flex align-items-center">
    <div class="container card shadow-sm" style="margin-top: 100px; max-width: 500px;">
        <div class="fs-3 fw-bold text-center">Edit Task</div>
        <form class="p-3" method="POST" action="{{ route('tasks.edit.post', ['id' => $task->id]) }}">
            @csrf
            <div class="mb-3 mt-1">
                <input type="text" class="form-control" name="title" id=" taskTitle" placeholder="Enter task title"
                    value="{{ $task->title }}">
            </div>
            <div class="mb-3">
                <input type="datetime-local" class="form-control" name="deadline" value="{{ $task->deadline }}">
            </div>
            <div class="mb-3">
                <textarea class="form-control" name="description" id="taskDescription" rows="3"
                    placeholder="Enter task description">{{ $task->description }}</textarea>
            </div>
            @if(session()->has("success"))
            <div class="alert alert-success">
                {{ session()->get("success") }}
            </div>
            @endif

            @if(session()->has("error"))
            <div class="alert alert-danger">
                {{ session("error") }}
            </div>
            @endif

            <button type="submit" class="btn btn-success rounded-pill">Submit</button>
        </form>
    </div>

</div>
@endsection