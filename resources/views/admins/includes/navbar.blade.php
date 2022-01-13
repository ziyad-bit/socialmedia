<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Social media</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">{{__("titles.home")}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('admins/index')}}">{{__("titles.admins")}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('languages.index')}}">{{__("titles.groups")}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('groups.index')}}">{{__("titles.languages")}}</a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="{{url('admins/logout')}}">{{__('titles.logout')}}</a>
                </li>
            </ul>
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
            
        </div>
    </div>
</nav>
