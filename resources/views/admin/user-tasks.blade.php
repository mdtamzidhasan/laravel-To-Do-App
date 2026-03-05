@extends("layouts.auth")

@section("style")
<style>
body {
    min-height: 100vh;
    background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
    font-family: 'Segoe UI', sans-serif;
}

.wrapper {
    max-width: 900px;
    margin: 50px auto;
    padding: 0 20px;
}

.page-header {
    background: #ffffff;
    border-radius: 15px;
    padding: 24px 32px;
    margin-bottom: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.page-header h1 {
    font-size: 20px;
    font-weight: 700;
    color: #2c5364;
    margin: 0 0 4px;
}

.page-header p {
    margin: 0;
    font-size: 13px;
    color: #888;
}

.back-btn {
    color: #667eea;
    font-size: 13px;
    font-weight: 500;
    text-decoration: none;
    border: 1.5px solid #667eea;
    border-radius: 8px;
    padding: 7px 16px;
    transition: 0.2s;
}

.back-btn:hover {
    background: #667eea;
    color: #fff;
}

.task-card {
    background: #ffffff;
    border-radius: 12px;
    padding: 20px 28px;
    margin-bottom: 14px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.07);
    transition: transform 0.2s;
}

.task-card:hover {
    transform: translateY(-2px);
}

.task-top {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 10px;
}

.task-title {
    font-size: 17px;
    font-weight: 600;
    color: #2c3e50;
    margin: 0 0 5px;
}

.task-description {
    font-size: 14px;
    color: #666;
    margin: 0;
    line-height: 1.5;
}

.task-deadline {
    font-size: 12px;
    color: #888;
    margin-top: 10px;
}

.status-badge {
    font-size: 12px;
    font-weight: 600;
    padding: 4px 12px;
    border-radius: 20px;
    white-space: nowrap;
    flex-shrink: 0;
    margin-left: 12px;
}

.status-pending {
    background: #fff3cd;
    color: #856404;
}

.status-completed {
    background: #d1e7dd;
    color: #0a3622;
}

.task-actions {
    display: flex;
    gap: 8px;
    margin-top: 14px;
    padding-top: 14px;
    border-top: 1px solid #f0f0f0;
}

.btn-edit {
    background: linear-gradient(135deg, #2c5364, #203a43);
    color: #fff;
    border: none;
    border-radius: 7px;
    padding: 7px 18px;
    font-size: 13px;
    font-weight: 500;
    text-decoration: none;
    cursor: pointer;
    transition: 0.2s;
}

.btn-edit:hover {
    opacity: 0.88;
    color: #fff;
}

.btn-delete {
    background: none;
    color: #dc3545;
    border: 1.5px solid #dc3545;
    border-radius: 7px;
    padding: 7px 18px;
    font-size: 13px;
    font-weight: 500;
    text-decoration: none;
    cursor: pointer;
    transition: 0.2s;
}

.btn-delete:hover {
    background: #dc3545;
    color: #fff;
}

.btn-status {
    background: none;
    color: #198754;
    border: 1.5px solid #198754;
    border-radius: 7px;
    padding: 7px 18px;
    font-size: 13px;
    font-weight: 500;
    text-decoration: none;
    cursor: pointer;
    transition: 0.2s;
}

.btn-status:hover {
    background: #198754;
    color: #fff;
}

.alert {
    font-size: 14px;
    padding: 10px 16px;
    border-radius: 8px;
    margin-bottom: 18px;
}

.empty-state {
    background: #fff;
    border-radius: 12px;
    padding: 50px;
    text-align: center;
    color: #aaa;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.07);
}
</style>
@endsection

@section("content")
<div class="wrapper">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1>📋 {{ $targetUser->name }} এর Tasks</h1>
            <p>{{ $targetUser->email }}</p>
        </div>
        <a href="{{ route('home') }}" class="back-btn">← Dashboard</a>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Tasks --}}
    @if($tasks->count() > 0)
    @foreach($tasks as $task)
    <div class="task-card">
        <div class="task-top">
            <div>
                <p class="task-title">{{ $task->title }}</p>
                <p class="task-description">{{ $task->description }}</p>
                <p class="task-deadline">⏰ Deadline: {{ \Carbon\Carbon::parse($task->deadline)->format('d M Y') }}</p>
            </div>
            <span class="status-badge {{ $task->status === 'completed' ? 'status-completed' : 'status-pending' }}">
                {{ $task->status === 'completed' ? '✅ Completed' : '⏳ Pending' }}
            </span>
        </div>

        <div class="task-actions">
            {{-- Edit --}}
            <a href="{{ route('tasks.edit', $task->id) }}" class="btn-edit">✏️ Edit</a>

            {{-- Delete --}}
            <a href="{{ route('tasks.delete', $task->id) }}" class="btn-delete"
                onclick="return confirm('এই task টি delete করবেন?')">
                🗑️ Delete
            </a>

            {{-- Status update (pending hole show korbe) --}}
            @if($task->status !== 'completed')
            <a href="{{ route('tasks.status.update', $task->id) }}" class="btn-status">
                ✔️ Complete
            </a>
            @endif
        </div>
    </div>
    @endforeach

    {{-- Pagination --}}
    <div style="margin-top: 20px;">
        {{ $tasks->links() }}
    </div>
    @else
    <div class="empty-state">
        <p style="font-size: 36px; margin-bottom: 10px;">📭</p>
        <p>এই user এর কোনো task নেই।</p>
    </div>
    @endif

</div>
@endsection