@extends('layouts.app')

@section('header')
    <link rel="stylesheet" href="{{ asset('css/users/posts/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/users/profile/index.css') }}">

    <title>
        
        {{  ucfirst(Auth::user()->name).' - ' .config('app.name') }}
        
    </title>
    <meta name="keywords" content="profile page contain information about user">
@endsection

@section('content')

    @include('users.posts.posts_modals')

    {{-- edit modal photo --}}
    <div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">edit photo</h5>

                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="alert alert-success text-center" style="display: none" id="success_photo">
                    </div>

                    <form method="POST" id="photoForm" enctype="multipart/form-data">


                        <div class="form-group">
                            <label for="exampleInputEmail1">photo</label>
                            <input type="file" name="photo" class="form-control photo" aria-describedby="emailHelp">

                            <small style="color: red" id="photo_err">

                            </small>

                        </div>
                        <input type="hidden" name="id" value="1">
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="save_photo" class="btn btn-primary">Save changes</button>
                </div>
            </div>

        </div>
    </div>
    </div>


    {{-- edit modal profile --}}
    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">edit profile</h5>

                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="alert alert-success text-center" id="success_profile" style="display: none">

                    </div>

                    <form id="profile_form">
                        <input type="hidden" name="photo_id" value="1">

                        <div class="form-group">
                            <label for="exampleInputEmail1">name</label>
                            <input type="text" name="name" value="{{ Auth::user()->name }}" class="form-control input"
                                id="input_name" aria-describedby="emailHelp">

                            <small style="color: red" class="errors" id="name_err">

                            </small>

                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">email</label>
                            <input type="email" name="email" value="{{ Auth::user()->email }}" class="form-control input"
                                id="input_email">

                            <small style="color: red" class="errors" id="email_err">

                            </small>

                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">work</label>
                            <input type="text" name="work" value="{{ Auth::user()->work }}" class="form-control input"
                                id="input_work">

                            <small style="color: red" class="errors" id="work_err">

                            </small>

                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">marital status</label>
                            <input type="text" name="marital_status" value="{{ Auth::user()->marital_status }}"
                                class="form-control input" id="input_marital_status">

                            <small style="color: red" class="errors" id="marital_status_err">

                            </small>

                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">old password</label>
                            <input type="password" name="old_password" class="form-control input" id="input_old_password">

                            <small style="color: red" class="errors" id="old_password_err">

                            </small>

                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">new password</label>
                            <input type="password" name="password" class="form-control input" id="input_password">

                            <small style="color: red" class="errors" id="password_err">

                            </small>

                        </div>


                    </form>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="update_profile_btn" class="btn btn-secondary ">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center" style="margin-top: 30px">
        <button type="button" class="btn btn-primary edit_photo" data-bs-toggle="modal" data-bs-target="#photoModal">
            edit photo
        </button>
        <button type="button" class="btn btn-primary edit_profile" data-bs-toggle="modal" data-bs-target="#profileModal">
            edit profile
        </button>
    </div>


    {{-- profile details --}}

    <div class="card mb-3 card_profile">
        <div class="row no-gutters">
            <div class="col-md-4">
                <img src="{{ asset('/images/users/' . Auth::user()->photo) }}" style="height: 292px;width: 199px"
                    class="card-img image-profile" alt="..." />
            </div>
            <div class="col-md-8">
                <ul class="list-group ">
                    <li class="list-group-item active">
                        <h4>information</h4>
                    </li>
                    <li class="list-group-item items_list">
                        <span class="name_profile name_text">name</span>:
                        <span id="name" class="user_name">{{ Auth::user()->name }}</span>
                    </li>

                    <li class="list-group-item items_list ">
                        <span class="email">email</span>:
                        <span id="email" class="user_email">{{ Auth::user()->email }}</span>
                    </li>

                    <li class="list-group-item items_list">
                        <span class="created_at"> created at </span>:
                        <span>{{ Auth::user()->created_at }}</span>

                    </li>

                    <li class="list-group-item items_list">
                        <span class="email"> work </span>:
                        @if (Auth::user()->work)
                            <span class="user_work">{{ Auth::user()->work }}</span>

                        @else
                            __
                        @endif


                    </li>

                    <li class="list-group-item items_list">
                        <span class="name_profile">status</span>:
                        @if (Auth::user()->marital_status)
                            <span class="user_marital_status">{{ Auth::user()->marital_status }}</span>

                        @else
                            __
                        @endif

                    </li>

                    <li class="list-group-item items_list">
                        <span class="email"><a href="{{ route('users.profile.show') }}">friends</a></span>:
                        <span class="user_marital_status">
                            <a href="{{ route('users.profile.show') }}">{{ $friends_count }}</a>
                            </span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <hr style="margin-top: 100px">
    {{-- posts --}}
    <div class="parent_posts" data-page_code="{{ $page_code }}">
        @include('users.posts.index_posts')
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/users/general_posts.js') }}"></script>
    <script src="{{ asset('js/users/profile/index.js') }}"></script>
@endsection
