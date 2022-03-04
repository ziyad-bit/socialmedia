@extends('layouts.app')

@section('header')
    <link rel="stylesheet" href="{{ asset('css/users/posts/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/users/group/show.css') }}">
@endsection

@section('content')
    <input type="hiddden" id="auth_id" value="{{Auth::id()}}">
    @include('users.posts.posts_modals')

    @foreach ($groups as $group)
    <input type="hiddden" id="group_id" value="{{$group->user_id}}">
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
            @cannot('show', $group)
                <button class="btn btn-primary join_btn" style="margin-top: 15px"
                    data-group_id="{{ $group->id }}">join</button>
            @endcannot
        @endif
    @endforeach

    <hr>

    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button"
                role="tab">Posts</button>

            <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-members"
                type="button" role="tab">Members</button>

            <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact"
            type="button" role="tab">Admins</button>

            @foreach ($groups as $group)
                @can('show', $group)
                    <button class="nav-link requests_tap" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                        type="button" role="tab" data-group_id="{{$group->id}}">Requests</button>
                @endcan
            @endforeach

        </div>
    </nav>

    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <div class="parent_posts" data-page_code="{{ $page_code }}">
                @include('users.posts.index_posts')
            </div>
        </div>

        <div class="tab-pane fade" id="nav-members" role="tabpanel">
            members
        </div>

        <div class="tab-pane fade" id="nav-contact" role="tabpanel">
            admins
        </div>

        @foreach ($groups as $group)
            @can('show', $group)
                <div class="tab-pane fade" id="nav_requests" role="tabpanel">
                    
                </div>
            @endcan
        @endforeach
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/users/general_posts.js') }}"></script>
    <script src="{{ asset('js/users/group/index.js') }}"></script>
@endsection
