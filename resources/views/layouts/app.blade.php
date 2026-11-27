
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
            Library System
        </a>
        <button
            type="button"
            class="menu-toggle"
            id="menuToggle"
            aria-label="Buka menu navigasi"
            aria-expanded="false"
            aria-controls="appMenu"
        >
            <span></span>
            <span></span>
            <span></span>
        </button>
        <div class="app-menu" id="appMenu">
            <nav class="app-nav">
                <a href="/dashboard">Dashboard</a>
                <a href="{{ route('borrowings.index') }}">
                    Borrowings
                </a>
                <a href="{{ route('books.index') }}">
                    Books
                </a>
                <a href="{{ route('categories.index') }}">
                    Categories
                </a>
                <a href="{{ route('members.index') }}">
                    Members
                </a>
                @can('manage-users')
                    <a href="{{ route('users.index') }}">
                        Kelola Pengguna
                    </a>
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
        </div>
    </header>

    <main class="app-main">
        @yield('content')
    </main>

    <footer class="app-footer">
        <p>Library System &copy; {{ date('Y') }}</p>
    </footer>

    <script>
        const menuToggle = document.getElementById('menuToggle');
        const appMenu = document.getElementById('appMenu');
        menuToggle.addEventListener('click', function () {
            const isOpen = appMenu.classList.toggle('is-open');
            menuToggle.classList.toggle('active', isOpen);
            menuToggle.setAttribute('aria-expanded', isOpen);
            menuToggle.setAttribute(
                'aria-label',
                isOpen ? 'Tutup menu navigasi' : 'Buka menu navigasi'
            );
        });
        document.querySelectorAll('.app-nav a').forEach(function (link) {
            link.addEventListener('click', function () {
                appMenu.classList.remove('is-open');
                menuToggle.classList.remove('active');
                menuToggle.setAttribute('aria-expanded', 'false');
                menuToggle.setAttribute('aria-label', 'Buka menu navigasi');
            });
        });
    </script>

</body>
</html>
