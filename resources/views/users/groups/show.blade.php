@extends('layouts.app')

@section('header')
    <link rel="stylesheet" href="{{ asset('css/users/posts/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/users/group/show.css') }}">
@endsection

@section('content')
    @foreach ($groups as $group)
        @if (Session::has('error'))
            <div class="alert alert-danger text-center">{{ Session::get('error') }}</div>
        @endif

        @if (Session::has('success'))
            <div class="alert alert-success text-center">{{ Session::get('success') }}</div>
        @endif



        <input type="hidden" id="auth_id" value="{{ Auth::id() }}">
        @include('users.posts.posts_modals')


        <input type="hidden" id="group_id" value="{{ $group->id }}">
        <input type="hidden" id="group_owner" value="{{ $group->user_id }}">

        <div class="d-flex justify-content-center group">

            <img src="{{ asset('images/groups/' . $group->photo) }}" alt="loading error"
                class="rounded-circle group_photo">

            <span class="group_name">{{ $group->name }} ({{ $group->group_users_count . ' Members' }})</span>

            <div class="group_description">{{ $group->description }}</div>

        </div>


        @cannot('any_with_no_request', $group)
            @foreach ($group->group_users as $user)
                @can('owner_admin_member', [App\Models\Group_users::class, $user->request])
                    <input type="hidden" id="group_req_id" value="{{ $user->request->id }}">
                    <form action="{{ route('group-users.destroy', $user->request->id) }}" method="POST">
                        @csrf
                        @method('delete')

                        <button class="btn btn-danger left_btn" onclick="return confirm('Are you sure ?')" style="margin-top: 15px"
                            data-group_id="{{ $group->id }}">
                            leave
                        </button>
                    </form>
                @else
                    <button class="btn btn-primary " style="margin-top: 15px" disabled="true">
                        awaiting approval
                    </button>
                @endcan
            @endforeach
        @else
            <button class="btn btn-primary join_btn" style="margin-top: 15px" data-group_id="{{ $group->id }}">
                join
            </button>

            <h3></h3>
        @endcannot


        <hr>

        @if ($group->group_users->count() > 0)
            @foreach ($group->group_users as $user)
                @can('owner_admin_member', [App\Models\Group_users::class, $user->request])
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-posts-tab" data-bs-toggle="tab" data-bs-target="#nav-home"
                                type="button" role="tab">Posts</button>

                            <button class="nav-link members_tab" id="nav-members-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-members" type="button" role="tab">Members</button>

                            <button class="nav-link admins_tab" id="nav-admins-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-contact" type="button" role="tab">Admins</button>


                            <input type="hidden" value="{{ $user->request->id }}" id="user_id">

                            @can('owner_admin', [App\Models\Group_users::class, $user->request])
                                <button class="nav-link requests_tap" id="nav_requests-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav_requests" type="button" role="tab"
                                    data-group_id="{{ $group->id }}">Requests</button>
                            @endcan

                        </div>
                    </nav>


                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                            <div class="parent_posts" data-page_code="{{ $page_code }}">


                                <input type="hidden" id="punish" value="{{ $user->request->punish }}">
                                @can('not_punished', [App\Models\Group_users::class, $user->request])
                                    @include('users.posts.index_posts')
                                @else
                                    <h3 class="alert alert-warning text-center">you are punished so you can't see any post</h3>
                                @endcan


                            </div>
                        </div>

                        <div class="tab-pane fade " id="nav-members" data-page_code="" role="tabpanel">
                            <div class="alert alert-success text-center members_success_msg" style="display: none"></div>
                            <div class="d-flex justify-content-center">

                                <div class="card text-dark bg-light mb-3 parent_members" data-page_code=""
                                    style="width: 50rem;">
                                    <div class="card-header">Members</div>
                                </div>
                            </div>

                        </div>

                        <div class="tab-pane fade" id="nav-contact" role="tabpanel">
                            <div class="alert alert-success text-center admins_success_msg" style="display: none"></div>
                            <div class="d-flex justify-content-center">

                                <div class="card text-dark bg-light mb-3 parent_admins" data-page_code="" style="width: 50rem;">
                                    <div class="card-header">Admins</div>
                                </div>
                            </div>
                        </div>


                        @can('owner_admin', [App\Models\Group_users::class, $user->request])
                            <div class="tab-pane fade tab_requests" id="nav_requests" role="tabpanel">
                                <div class="alert alert-success text-center success_msg" style="display: none"></div>
                                <div class="d-flex justify-content-center">

                                    <div class="card text-dark bg-light mb-3 parent_requests" data-page_code=""
                                        style="width: 50rem;">
                                        <div class="card-header">Requests</div>
                                    </div>
                                </div>
                            </div>
                        @endcan


                    </div>
                @endcan
            @endforeach
        @else
        <h3 class="alert alert-warning text-center">you should be member to see posts and other members</h3>
        @endif
    @endforeach
@endsection

@section('script')
    <script src="{{ asset('js/users/general_posts.js') }}"></script>
    <script src="{{ asset('js/users/group/index.js') }}"></script>
@endsection
