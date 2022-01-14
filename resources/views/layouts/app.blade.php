<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('users.includes.header')

<body>
    @include('users.includes.navbar')

    <main class="container">
        @yield('content')
    </main>

    @include('users.includes.footer')
</body>

</html>
