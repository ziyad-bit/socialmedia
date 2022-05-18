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

    <!--       add post        -->
    <div class="modal fade" id="add_post_modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add_post_modal"> add post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="post_form" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="alert alert-success text-center" id="add_post_msg" style="display: none"></div>

                        <div class="form-group">
                            <label for="exampleInputname1">text </label>
                            <textarea name="text" class="form-control" cols="15" rows="5"></textarea>
                            <small style="color:red" class="errors" id="text_err">

                            </small>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputname1">photo </label>
                            <input type="file" name="photo" class="form-control">
                            <small style="color:red" class="errors" id="photo_err">

                            </small>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputname1">file </label>
                            <input type="file" name="file" class="form-control">
                            <small style="color:red" class="errors" id="file_err">

                            </small>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputname1">video </label>
                            <input type="file" name="video" class="form-control">
                            <small style="color:red" class="errors" id="video_err">

                            </small>
                        </div>

                        <input type="hidden" name="group_id" value="{{ $group->id }}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">cancel</button>
                        <button type="button" id="add_post_btn" class="btn btn-primary">add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--       edit post        -->
    <div class="modal fade" id="group_update" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit_group_modal"> edit group</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="edit_group_form" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="alert alert-success text-center" id="update_group_msg" style="display: none"></div>
                        <input type="hidden" name="photo_id" value="1">

                        <div class="form-group">
                            <label for="exampleInputname1">name </label>
                            <input name="name" class="form-control input_name" type="text" />
                            <small style="color:red" class="errors" id="name_update_err" style="display: none">

                            </small>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputname1">description </label>
                            <textarea name="description" class="form-control input_description" cols="15" rows="5"></textarea>
                            <small style="color:red" class="errors" id="description_update_err"
                                style="display: none">

                            </small>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputname1">photo </label>
                            <input type="file" name="photo" class="form-control">
                            <small style="color:red" class="errors" id="photo_update_err" style="display: none">

                            </small>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">cancel</button>
                        <button type="button" id="update_group_btn" class="btn btn-primary">update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    

    <input type="hidden" id="auth_id" value="{{ Auth::id() }}">
    @include('users.posts.posts_modals')


    <input type="hidden" id="group_id" value="{{ $group->id }}">
    <input type="hidden" id="group_owner" value="{{ $group->user_id }}">

    <div class="d-flex justify-content-center group">

        <img src="{{ asset('images/groups/' . $group->photo) }}" alt="loading error" class="rounded-circle group_photo">

        <span class="group_name">{{ $group->name }} </span><span
            class="members_count">({{ $group_users_count . ' Members' }})</span>

        <div class="group_description">{{ $group->description }}</div>

    </div>

    

    @if ($group_auth)
        @can('owner_admin_member', $group_auth)
            <input type="hidden" id="group_req_id" value="{{ $group_auth->id }}">
            <form action="{{ route('group-users.destroy', $group_auth->id) }}" method="POST" style="display: inline-block">
                @csrf
                @method('delete')

                <button class="btn btn-danger left_btn" onclick="return confirm('Are you sure ?')"
                    style="margin-top: 15px;display: inline-block" data-group_id="{{ $group->id }}">
                    leave
                </button>
            </form>
        @else
            <button class="btn btn-primary " style="margin-top: 15px" disabled="true">
                awaiting approval
            </button>
        @endcan
    @else
        <button class="btn btn-primary join_btn" style="margin-top: 15px" data-group_id="{{ $group->id }}">
            join
        </button>
    @endif

    @can('owner', $group_auth)
        <form action="{{ route('group.destroy', $group->id) }}" method="POST" style="display: inline-block">
            @csrf
            @method('delete')

            <button class="btn btn-danger left_btn" onclick="return confirm('Are you sure ?')"
                style="margin-top: 15px;display: inline-block" data-group_id="{{ $group->id }}">
                delete
            </button>
        </form>

        <button class="btn btn-primary btn_edit" style="margin-top: 15px;display: inline-block" data-bs-toggle="modal"
            data-bs-target="#group_update">
            update
        </button>
    @endcan

    @can('owner_admin_member', $group_auth)
        <button class="btn btn-primary add_post" data-bs-target="#add_post_modal" data-bs-toggle="modal" style="margin-top: 15px;
        float: right;">add post</button>
    @endcan

    <hr>

    @if ($group_auth)
        @can('owner_admin_member', $group_auth)
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-posts-tab" data-bs-toggle="tab" data-bs-target="#nav-home"
                        type="button" role="tab">Posts</button>

                    <button class="nav-link members_tab" id="nav-members-tab" data-bs-toggle="tab" data-bs-target="#nav-members"
                        type="button" role="tab">Members</button>

                    <button class="nav-link admins_tab" id="nav-admins-tab" data-bs-toggle="tab" data-bs-target="#nav-contact"
                        type="button" role="tab">Admins</button>


                    <input type="hidden" value="{{ $group_auth->id }}" id="user_id">

                    @can('owner_admin', $group_auth)
                        <button class="nav-link requests_tap" id="nav_requests-tab" data-bs-toggle="tab"
                            data-bs-target="#nav_requests" type="button" role="tab"
                            data-group_id="{{ $group->id }}">Requests</button>
                    @endcan

                </div>
            </nav>


            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="parent_posts" data-page_code="{{ $page_code }}">


                        <input type="hidden" id="punish" value="{{ $group_auth->punish }}">
                        @can('auth_not_punished', $group_auth)
                            @include('users.posts.index_posts')
                        @else
                            <h3 class="alert alert-warning text-center">you are punished so you can't see any post</h3>
                        @endcan


                    </div>
                </div>

                <div class="tab-pane fade " id="nav-members" data-page_code="" role="tabpanel">
                    <div class="alert alert-success text-center members_success_msg" style="display: none"></div>
                    <div class="d-flex justify-content-center">

                        <div class="card text-dark bg-light mb-3 parent_members" data-page_code="" style="width: 50rem;">
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


                @can('owner_admin', $group_auth)
                    <div class="tab-pane fade tab_requests" id="nav_requests" role="tabpanel">
                        <div class="alert alert-success text-center success_msg" style="display: none"></div>
                        <div class="d-flex justify-content-center">

                            <div class="card text-dark bg-light mb-3 parent_requests" data-page_code="" style="width: 50rem;">
                                <div class="card-header">Requests</div>
                            </div>
                        </div>
                    </div>
                @endcan


            </div>
        @endcan
    @else
        <h3 class="alert alert-warning text-center">you should be member to see posts and other members</h3>
    @endif
@endsection

@section('script')
    <script src="{{ asset('js/users/general_posts.js') }}"></script>
    <script src="{{ asset('js/users/group/index.js') }}"></script>
@endsection
