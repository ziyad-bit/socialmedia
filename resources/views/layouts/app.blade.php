<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('users.includes.header')

<body class="{{in_array(default_Lang(),lang_rtl()) ? 'rtl' : null}}">
    @include('users.includes.navbar')

    <main class="container">
        @yield('content')
    </main>

    @include('users.includes.footer')
    
    @yield('script')
    
</body>

</html>
