<!DOCTYPE html>
<html>
<head>
    <title>Car Review System</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <nav>
        <ul>
            <li><a href="{{ url('/') }}/">Home</a></li>
            <li><a href="{{ url('/manufacturers') }}">Manufacturers</a></li>
        </ul>
    </nav>

    <div class="container">
        @yield('content')
    </div>
</body>
</html>
