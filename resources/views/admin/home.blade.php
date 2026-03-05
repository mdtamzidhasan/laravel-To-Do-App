<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - Todo App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        min-height: 100vh;
        background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
        font-family: 'Segoe UI', sans-serif;
    }

    /* ── Navbar ── */
    .navbar {
        background: rgba(255, 255, 255, 0.07);
        backdrop-filter: blur(12px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        padding: 0 40px;
        height: 64px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: sticky;
        top: 0;
        z-index: 100;
    }

    .navbar-brand {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #fff;
        font-size: 18px;
        font-weight: 700;
        text-decoration: none;
    }

    .nav-welcome {
        color: rgba(255, 255, 255, 0.75);
        font-size: 14px;
    }

    .nav-welcome strong {
        color: #fff;
        font-weight: 600;
    }

    .btn-logout {
        border: 1.5px solid rgba(255, 255, 255, 0.45);
        color: #fff;
        border-radius: 8px;
        padding: 7px 20px;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        transition: 0.2s;
        background: none;
    }

    .btn-logout:hover {
        background: rgba(255, 255, 255, 0.12);
        border-color: #fff;
        color: #fff;
    }

    /* ── Content ── */
    .admin-wrapper {
        max-width: 820px;
        margin: 44px auto;
        padding: 0 24px;
    }

    .section-title {
        color: rgba(255, 255, 255, 0.55);
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1.8px;
        text-transform: uppercase;
        margin-bottom: 18px;
    }

    /* ── User Card ── */
    .user-card {
        background: #fff;
        border-radius: 14px;
        padding: 22px 30px;
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        text-decoration: none;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.09);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .user-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.16);
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 18px;
    }

    .user-avatar {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2c5364, #667eea);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: 700;
        font-size: 20px;
        flex-shrink: 0;
    }

    .user-name {
        font-size: 16px;
        font-weight: 700;
        color: #1a2e3b;
        margin-bottom: 4px;
    }

    .user-email {
        font-size: 13px;
        color: #96a8b2;
    }

    .card-right {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .task-badge {
        background: linear-gradient(135deg, #2c5364, #203a43);
        color: #fff;
        border-radius: 22px;
        padding: 8px 22px;
        font-size: 14px;
        font-weight: 600;
    }

    .arrow {
        color: #c5d3d9;
        font-size: 24px;
        font-weight: 300;
        line-height: 1;
    }

    /* ── Empty ── */
    .empty-state {
        background: rgba(255, 255, 255, 0.07);
        border-radius: 14px;
        padding: 60px;
        text-align: center;
        color: rgba(255, 255, 255, 0.4);
        font-size: 15px;
    }

    .alert {
        font-size: 14px;
        border-radius: 9px;
        margin-bottom: 18px;
    }
    </style>
</head>

<body>

    {{-- Navbar --}}
    <nav class="navbar">
        <div class="navbar-brand">
            <span>👑</span> Admin Dashboard
        </div>

        <span class="nav-welcome">Welcome, <strong>{{ auth()->user()->name }}</strong></span>

        <a href="{{ route('logout') }}" class="btn-logout">Logout</a>
    </nav>

    {{-- Content --}}
    <div class="admin-wrapper">

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <p class="section-title">All Users ({{ $users->total() }})</p>

        @if($users->count() > 0)
        @foreach($users as $user)
        <a href="{{ route('admin.user.tasks', $user->id) }}" class="user-card">
            <div class="user-info">
                <div class="user-avatar">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <p class="user-name">{{ $user->name }}</p>
                    <p class="user-email">{{ $user->email }}</p>
                </div>
            </div>
            <div class="card-right">
                <span class="task-badge">{{ $user->tasks_count }} Tasks</span>
                <span class="arrow">›</span>
            </div>
        </a>
        @endforeach

        <div class="mt-4 d-flex justify-content-center">
            {{ $users->links() }}
        </div>
        @else
        <div class="empty-state">
            <p style="font-size:40px; margin-bottom:10px;">👥</p>
            <p>There are no users to display.</p>
        </div>
        @endif

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
</body>

</html>