@extends('layouts.app')

@section('header')
    <link rel="stylesheet" href="{{ asset('css/users/posts/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/users/group/show.css') }}">
@endsection

@section('content')
    @include('users.posts.posts_modals')

    @foreach ($groups as $group)
        <div class="d-flex justify-content-center group">

            <img src="{{ asset('images/groups/' . $group->photo) }}" alt="loading error"
                class="rounded-circle group_photo">

            <span class="group_name">{{ $group->name }} ({{ $group->group_users_count . ' Members' }})</span>

            <div class="group_description">{{ $group->description }}</div>

        </div>

        @if ($group->group_users->count() > 0)
            @foreach ($group->group_users as $user)
                @if ($user->request->status == 1)
                    <button class="btn btn-danger join_btn" style="margin-top: 15px"
                        data-group_id="{{ $group->id }}">left</button>
                @else
                    <button class="btn btn-primary join_btn" style="margin-top: 15px" data-group_id="{{ $group->id }}"
                        disabled="true">awaiting approval</button>
                @endif
            @endforeach
        @else
            <button class="btn btn-primary join_btn" style="margin-top: 15px"
                data-group_id="{{ $group->id }}">join</button>
        @endif
    @endforeach



    <hr>

    <div class="parent_posts" data-page_code="{{ $page_code }}">
        @include('users.posts.index_posts')
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/users/general_posts.js') }}"></script>
    <script src="{{ asset('js/users/group/index.js') }}"></script>
@endsection
