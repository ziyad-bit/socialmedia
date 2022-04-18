@extends('layouts.app')

@section('header')
    <link rel="stylesheet" href="{{ asset('css/users/friends/requests.css') }}">
@endsection

@section('content')
    @if (Session::has('error'))
        <div class="alert alert-danger text-center">{{ Session::get('error') }}</div>
    @endif

    @if ($friend_reqs->count() == 0)
        <h3 class="text-center" style="margin-top: 100px">no Requests</h3>
    @else
        <div class="d-flex justify-content-center" style="margin-top: 30px">
            <div class="card text-dark bg-light mb-3" style="width: 50rem;">
                <div class="card-header" data-page_code="{{ $page_code }}">{{ __('titles.Requests') }}</div>
                @foreach ($friend_reqs as $friend_req)
                    @if ($friend_req->friends_add_auth->count() > 0)
                        @foreach ($friend_req->friends_add_auth as $friend)
                            <div class="card-body"  data-friend_req="{{ $friend->request->id }}">
                                <img src="{{ asset('images/users/' . $friend_req->photo) }}" class="rounded-circle"
                                    style="width: 80px" alt="loading">

                                <span class="card-title">
                                    {{ $friend_req->name }}
                                </span>

                                <button class="btn btn-primary approve_btn"
                                    data-friend_req_id="{{ $friend->request->id }}">
                                    {{ __('titles.approve') }}
                                </button>

                                <button class="btn btn-danger ignore_btn" data-friend_req_id="{{ $friend->request->id }}">
                                    {{ __('titles.ignore') }}
                                </button>
                            </div>
                        @endforeach
                    @endif
                @endforeach
            </div>
        </div>
    @endif

@endsection

@section('script')
    <script src="{{ asset('js/users/friends/index.js') }}"></script>
@endsection
