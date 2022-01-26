@extends('layouts.app')

@section('header')
    <link rel="stylesheet" href="{{ asset('css/users/search.css') }}">
@endsection

@section('content')
    @if (Session::has('error'))
        <div class="alert alert-danger text-center">{{ Session::get('error') }}</div>
    @endif

    @if ($users->count() == 0 && $groups->count() == 0)
        <h3 class="text-center">no matched results</h3>
    @else
        <div class="d-flex justify-content-center" style="margin-top: 30px">
            <div class="card text-dark bg-light mb-3" style="width: 50rem;">
                <div class="card-header" data-status="1">All</div>
                @if ($users->count() > 0)
                    @foreach ($users as $user)
                        <div class="card-body">
                            <img src="{{ asset('images/users/' . $user->photo) }}" class="rounded-circle"
                                style="width: 80px" alt="loading">

                            <span class="card-title">
                                {{ $user->name }}
                            </span>

                            @if ($user->auth_add_friends->count() > 0)
                                @foreach ($user->auth_add_friends as $friend)
                                    @if ($friend->request->status == 0 || $friend->request->status == 2)
                                        <button class="btn btn-primary" disabled="true">
                                            awaiting approval
                                        </button>
                                    @endif

                                    @if ($friend->request->status == 1)
                                        <a class="btn btn-success ">
                                            message
                                        </a>
                                    @endif
                                @endforeach
                            @endif

                            @if ($user->friends_add_auth->count() > 0)
                                @foreach ($user->friends_add_auth as $friend)
                                    @if ($friend->request->status == 0 || $friend->request->status == 2)
                                        <button class="btn btn-primary" disabled="true">
                                            awaiting approval
                                        </button>
                                    @endif

                                    @if ($friend->request->status == 1)
                                        <a class="btn btn-success ">
                                            message
                                        </a>
                                    @endif
                                @endforeach
                            @endif

                            @if ($user->auth_add_friends->count() == 0 && $user->friends_add_auth->count() == 0)
                                <button class="btn btn-primary add_btn" data-user_id="{{ $user->id }}">
                                    add
                                </button>
                            @endif

                            <div class="card-text">
                                {{ $user->work }}
                            </div>
                        </div>
                    @endforeach
                @endif


                @if ($groups->count() > 0)
                    @foreach ($groups as $group)
                        <div class="card-body">
                            <img src="{{ asset('images/groups/' . $group->photo) }}" class="rounded-circle"
                                style="width: 100px" alt="loading">
                            <span class="card-title">
                                {{ $group->name }}
                            </span>
                            <a class="btn btn-primary">join</a>
                            <div class="card-text">
                                {{ $group->description }}
                            </div>
                        </div>
                    @endforeach
                @endif


            </div>
        </div>
    @endif


@endsection

@section('script')
    <script src="{{ asset('js/users/search/index.js') }}"></script>
@endsection
