<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Admin - ' . config('app.name') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    @php
        $user = auth()->user();
        $roleId = (int) ($user->role_id ?? 0);
        $isSuperAdmin = $roleId === 1;
    @endphp

    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
        <div class="container">
            <a href="{{ route('admin.dashboard') }}" class="navbar-brand fw-semibold mb-0 text-decoration-none">
                Admin Panel
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="adminNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    {{-- SUPER ADMIN: show everything --}}
                    @if ($isSuperAdmin)
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active fw-semibold' : '' }}"
                                href="{{ route('admin.dashboard') }}">
                                Dashboard
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.services.*') ? 'active fw-semibold' : '' }}"
                                href="{{ route('admin.services.index') }}">
                                Services
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active fw-semibold' : '' }}"
                                href="{{ route('admin.products.index') }}">
                                Products
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.gallery.*') ? 'active fw-semibold' : '' }}"
                                href="{{ route('admin.gallery.index') }}">
                                Gallery
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.bookings.*') ? 'active fw-semibold' : '' }}"
                                href="{{ route('admin.bookings.index') }}">
                                Bookings
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active fw-semibold' : '' }}"
                                href="{{ route('admin.settings.edit') }}">
                                Settings
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.barbers.*') ? 'active fw-semibold' : '' }}"
                                href="{{ route('admin.barbers.index') }}">
                                Barbers
                            </a>
                        </li>

                    {{-- NORMAL ADMIN: Bookings + Barbers --}}
                    @else
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.bookings.*') ? 'active fw-semibold' : '' }}"
                                href="{{ route('admin.bookings.index') }}">
                                Bookings
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.barbers.*') ? 'active fw-semibold' : '' }}"
                                href="{{ route('admin.barbers.index') }}">
                                Barbers
                            </a>
                        </li>
                    @endif
                </ul>

                <div class="d-flex gap-2">
                    <a class="btn btn-outline-secondary btn-sm" href="{{ route('home') }}">View Site</a>

                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button class="btn btn-outline-danger btn-sm" type="submit">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
