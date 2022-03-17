@extends('layouts.app')

@section('header')
    <link rel="stylesheet" href="{{ asset('css/users/posts/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/users/group/show.css') }}">
@endsection

@section('content')
    @if (Session::has('error'))
        <div class="alert alert-danger text-center">{{ Session::get('error') }}</div>
    @endif

    @if (Session::has('success'))
        <div class="alert alert-success text-center">{{ Session::get('success') }}</div>
    @endif

    

    <input type="hidden" id="auth_id" value="{{ Auth::id() }}">
    @include('users.posts.posts_modals')

    @foreach ($groups as $group)
        <input type="hidden" id="group_id" value="{{ $group->id }}">
        <input type="hidden" id="group_owner" value="{{ $group->user_id }}">

        <div class="d-flex justify-content-center group">

            <img src="{{ asset('images/groups/' . $group->photo) }}" alt="loading error"
                class="rounded-circle group_photo">

            <span class="group_name">{{ $group->name }} ({{ $group->group_users_count . ' Members' }})</span>

            <div class="group_description">{{ $group->description }}</div>

        </div>


        @if ($group->group_users->count() > 0)
            @foreach ($group->group_users as $user)
                @can('destroy', $group)
                    <form action="{{ route('group-users.destroy', $user->request->id) }}" method="POST">
                        @csrf
                        @method('delete')

                        <button class="btn btn-danger left_btn" style="margin-top: 15px"
                            data-group_id="{{ $group->id }}">left</button>
                    </form>
                @else
                    <button class="btn btn-primary " style="margin-top: 15px" data-group_id="{{ $group->id }}"
                        disabled="true">awaiting approval</button>
                @endcan
            @endforeach
        @else
            <button class="btn btn-primary join_btn" style="margin-top: 15px"
                data-group_id="{{ $group->id }}">join</button>
        @endif
    @endforeach

    <hr>

    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-posts-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button"
                role="tab">Posts</button>

            <button class="nav-link" id="nav-members-tab" data-bs-toggle="tab" data-bs-target="#nav-members"
                type="button" role="tab">Members</button>

            <button class="nav-link" id="nav-admins-tab" data-bs-toggle="tab" data-bs-target="#nav-contact"
                type="button" role="tab">Admins</button>

            @foreach ($groups as $group)
                @if ($group->group_users->count() > 0)
                    @foreach ($group->group_users as $group_req)
                        <input type="hidden" value="{{ $group_req->request->id }}" id="group_req_id">

                        @can('show_requests', $group)
                            <button class="nav-link requests_tap" id="nav_requests-tab" data-bs-toggle="tab"
                                data-bs-target="#nav_requests" type="button" role="tab"
                                data-group_id="{{ $group->id }}">Requests</button>
                        @endcan
                    @endforeach
                @endif
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
            @if ($group->group_users->count() > 0)
                @can('show_requests', $group)
                    <div class="tab-pane fade" id="nav_requests" role="tabpanel">
                        <div class="alert alert-success text-center success_msg" style="display: none"></div>
                        <div class="d-flex justify-content-center">
                            

                            <div class="card text-dark bg-light mb-3 parent_requests" data-page_code="" style="width: 50rem;">
                                <div class="card-header">Requests</div>
                            </div>
                        </div>
                    </div>
                @endcan
            @endif
        @endforeach
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/users/general_posts.js') }}"></script>
    <script src="{{ asset('js/users/group/index.js') }}"></script>
@endsection
