<!DOCTYPE html>
@vite(['resources/css/app.css', 'resources/js/app.js'])
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body>
    <div class="top-right-buttons">
        {{-- Back Button --}}
        <form action="{{ url()->previous() }}" method="get">
            <button type="submit" class="btn btn-outline-secondary">⬅ Back</button>
        </form>

        {{-- Logout Button --}}
        <form action="{{ route('logout') }}" method="get">
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
    </div>

    <div class="container-fluid">
        <div class="row min-vh-100">
            {{-- Sidebar --}}
            <aside class="col-md-3 col-lg-2 bg-light p-3">
                <h5 class="mb-4">Menu</h5>
                <ul class="nav flex-column mb-4">
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost:8082">Properties</a>
                    </li>
                </ul>
            </aside>

            {{-- Main Content --}}
            <main class="col-md-9 col-lg-10 p-4">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>