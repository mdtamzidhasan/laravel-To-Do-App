@extends("layouts.default")

@section("style")
<style>
body {
    background: #f4f6f9;
}

.task-container {
    max-width: 900px;
    margin: auto;
}

.task-card {
    background: #ffffff;
    border-radius: 12px;
    padding: 18px 20px;
    margin-bottom: 15px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.06);
    transition: 0.3s ease;
}

.task-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
}

.task-title {
    font-weight: 600;
    font-size: 16px;
}

.task-deadline {
    font-size: 13px;
    color: #6c757d;
}

.task-description {
    font-size: 14px;
    margin-top: 6px;
    color: #555;
}

.task-actions a {
    margin-left: 6px;
    border-radius: 8px;
    padding: 6px 10px;
}

.btn-complete {
    background: #198754;
    color: white;
}

.btn-edit {
    background: #0d6efd;
    color: white;
}

.btn-delete {
    background: #dc3545;
    color: white;
}

.btn-complete:hover,
.btn-edit:hover,
.btn-delete:hover {
    opacity: 0.85;
}
</style>
@endsection

@section("content")

<main class="mt-5">
    <div class="task-container">

        <h4 class="mt-5 mb-4 fw-bold">📋 Task Dashboard</h4>

        @if(session()->has("success"))
        <div class="alert alert-success rounded-3">
            {{ session()->get("success") }}
        </div>
        @endif

        @if(session()->has("error"))
        <div class="alert alert-danger rounded-3">
            {{ session("error") }}
        </div>
        @endif

        @foreach ($tasks as $task)
        <div class="task-card">

            <div class="d-flex justify-content-between align-items-start">

                <div>
                    <div class="task-title">
                        {{ $task->title }}
                    </div>
                    <div class="task-deadline">
                        Deadline: {{ $task->deadline }}
                    </div>
                </div>

                <div class="task-actions d-flex">
                    <a href="{{ route('tasks.status.update', $task->id) }}" class="btn btn-complete btn-sm">
                        ✔
                    </a>

                    <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-edit btn-sm">
                        ✏
                    </a>

                    <a href="{{ route('tasks.delete', $task->id) }}" class="btn btn-delete btn-sm">
                        🗑
                    </a>
                </div>

            </div>

            <div class="task-description">
                {{ $task->description }}
            </div>

        </div>
        @endforeach

        <div class="mt-4">
            {{ $tasks->links() }}
        </div>

    </div>
</main>

@endsection