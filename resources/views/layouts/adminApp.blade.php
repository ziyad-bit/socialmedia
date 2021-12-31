<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('users.includes.header')
{{--  defaultLang(),lang_rtl() are autoloaded from app\helpers\general    --}}
<body >
    @include('admins.includes.navbar') 

        <div class="container">
            @yield('content')
        </div>

    @include('users.includes.footer')
    
    @yield('script')
</body>

</html>
