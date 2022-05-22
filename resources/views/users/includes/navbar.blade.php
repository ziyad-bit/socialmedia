<div id="app">
    <input type="hidden" value="{{ Auth::id() }}" id="auth_id">
    <input type="hidden" value="{{ getLang() }}" id="lang">

    <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ __('titles.languages') }}
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                    <a rel="alternate" hreflang="{{ $localeCode }}" class="dropdown-item"
                        href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                        {{ $properties['native'] }}
                    </a>
                @endforeach
            </div>
        </div>
        <div class="container">

            <a class="navbar-brand" href="{{ url('/') }}">
                Social Media
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->

                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link"
                            href="{{ route('users.profile.index') }}">{{ __('titles.profile') }}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('posts.index.all') }}">{{ __('titles.posts') }}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link"
                            href="{{ route('groups.index_groups') }}">{{ __('titles.groups') }}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link"
                            href="{{ route('message.index.friends') }}">{{ __('titles.chat') }}</a>
                    </li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <form method="POST" id="search_form" action="{{ route('search.index') }}" class="d-flex">
                            @csrf

                            <input required class="form-control me-2" id="search" name="search" type="search"
                                value="{{ old('search') }}" placeholder="Search" aria-label="Search" autocomplete="off">
                            <div class="    ">
                                <ul class="list-group list-group-flush list_search" data-req_num="0" data-recent_req="0">

                                </ul>
                            </div>
                            <button class="btn btn-outline-success" id="search_btn" type="submit">Search</button>
                        </form>

                        <i class="fas fa-bell" style="color: white;font-size: larger;position: relative;" id="bell">
                            <span id="notifs_count" class="rounded-circle" style="display: none">{{ $notifs_count }}</span>
                        </i>


                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ ucfirst(substr(Auth::user()->name, 0, 1)) }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('friends.show.requests') }}">
                                    {{ __('titles.Requests') }}
                                </a>

                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                    {{ __('titles.logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>

        <div>
            <div class="card notif " style="width: 26rem;display: none " id="notif">
                @include('users.notifications.index')
            </div>
        </div>
    </nav>
