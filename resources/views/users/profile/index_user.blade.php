@extends('layouts.app')

@section('header')
    <link rel="stylesheet" href="{{ asset('css/users/posts/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/users/profile/index.css') }}">
@endsection

@section('content')
    @include('users.posts.posts_modals')

    <div class="alert alert-success text-center profile_msg" style="display: none"></div>

    {{-- profile details --}}

    @foreach ($related_user as $user)
        @if ($user->auth_add_friends != [])
            @foreach ($user->auth_add_friends as $auth_user)
                @if ($auth_user->request->status == 1)
                    <button class="btn btn-danger profile_btn unfriend_btn" data-friend_req_id="{{$auth_user->request->id }}">
                        unfriend
                    </button>
                @endif

                @if ($auth_user->request->status == 0 || $auth_user->request->status == 2)
                    <button class="btn btn-primary profile_btn" disabled>awaiting approval</button>
                @endif
            @endforeach
        @endif

        @if ($user->friends_add_auth != [])
            @foreach ($user->friends_add_auth as $auth_user)
                @if ($auth_user->request->status == 1)
                    <button class="btn btn-danger profile_btn unfriend_btn" data-friend_req_id="{{$auth_user->request->id }}">
                        unfriend
                    </button>
                @endif

                @if ($auth_user->request->status == 0 || $auth_user->request->status == 2)
                    <button class="btn btn-primary profile_btn" disabled>awaiting approval</button>
                @endif
            @endforeach
        @endif

        @if ($user->friends_add_auth->count() == 0 && $user->auth_add_friends->count() == 0)
            <button class="btn btn-primary profile_btn add_btn" data-user_id="{{$user->id}}">send request </button>
        @endif


        <div class="card mb-3 card_profile">
            <div class="row no-gutters">
                <div class="col-md-4">
                    <img src="{{ asset('/images/users/' . $user->photo) }}" style="height: 292px;width: 199px"
                        class="card-img image-profile" alt="..." />
                </div>
                <div class="col-md-8">
                    <ul class="list-group ">
                        <li class="list-group-item active">
                            <h4>information</h4>
                        </li>
                        <li class="list-group-item items_list">
                            <span class="name_profile name_text">name</span>:
                            <span id="name" class="user_name">{{ $user->name }}</span>
                        </li>

                        <li class="list-group-item items_list ">
                            <span class="email">email</span>:
                            <span id="email" class="user_email">{{ $user->email }}</span>
                        </li>

                        <li class="list-group-item items_list">
                            <span class="created_at"> created at </span>:
                            <span>{{ $user->created_at }}</span>

                        </li>

                        <li class="list-group-item items_list">
                            <span class="email"> work </span>:
                            @if ($user->work)
                                <span class="user_work">{{ $user->work }}</span>
                            @else
                                __
                            @endif


                        </li>

                        <li class="list-group-item items_list">
                            <span class="name_profile">status</span>:
                            @if ($user->marital_status)
                                <span class="user_marital_status">{{ $user->marital_status }}</span>
                            @else
                                __
                            @endif

                        </li>

                        <li class="list-group-item items_list">
                            <span class="email"><a href="{{ route('users.friends.index', $user->name) }}">mutual
                                    friends</a></span>:
                            <span class="user_marital_status">
                                <a href="{{ route('users.friends.index', $user->name) }}">{{ $mutual_friends_num }}</a>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    @endforeach


    <hr style="margin-top: 100px">
    {{-- posts --}}
    <div class="parent_posts" data-page_code="{{ $page_code }}">
        @include('users.posts.index_posts')
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/users/general_posts.js') }}"></script>
    <script src="{{ asset('js/users/profile/index_user.js') }}"></script>
@endsection
