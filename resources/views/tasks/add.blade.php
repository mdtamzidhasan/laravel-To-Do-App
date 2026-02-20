@extends("layouts.default")
@section("content")
<div class="d-flex align-items-center">
    <div class="container card shadow-sm" style="margin-top: 100px; max-width: 500px;">
        <div class="fs-3 fw-bold text-center">Add New Task</div>
        <form class="p-3" method="POST" action="">
            <div class="mb-3 mt-1">
                <input type="text" class="form-control" name="title" id=" taskTitle" placeholder="Enter task title">
            </div>
            <div class="mb-3">
                <input type="datetime-local" class="form-control" name="deadline">
            </div>
            <div class="mb-3">
                <textarea class="form-control" id="taskDescription" rows="3"
                    placeholder="Enter task description"></textarea>
            </div>
            <button type="submit" class="btn btn-success rounded-pill">Add Task</button>
        </form>
    </div>

</div>
@endsection