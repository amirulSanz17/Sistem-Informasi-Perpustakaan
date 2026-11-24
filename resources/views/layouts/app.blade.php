
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Library System')</title>

    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">

    @stack('styles')

</head>

<body>
    <header class="app-header">
        <a href="/dashboard" class="brand">
            <img src="{{ asset('images/logo-perpustakaan-1.png') }}" alt="Logo Perpustakaan">
            <span>Library System</span>
        </a>

        <nav class="app-nav">
            <a href="/dashboard">Dashboard</a>
            <a href="{{ route('borrowings.index') }}">Borrowings</a>
            <a href="{{ route('books.index') }}">Books</a>
            <a href="{{ route('categories.index') }}">Categories</a>
            <a href="{{ route('members.index') }}">Members</a>
            @can('manage-users')
            <a href="{{ route('users.index') }}">Users</a>
            @endcan
        </nav>

        <div class="user-info">
            @auth
                <span>{{ auth()->user()->name }}</span>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-button">
                        Logout
                    </button>
                </form>
            @endauth
        </div>
    </header>

    <main class="app-main">
        @yield('content')
    </main>

    <footer class="app-footer">
        <p>Library System &copy; {{ date('Y') }}</p>
    </footer>
</body>
</html>
