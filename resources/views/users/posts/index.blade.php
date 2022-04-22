@extends('layouts.app')

@section('header')
    <link rel="stylesheet" href="{{ asset('css/users/posts/index.css') }}">
@endsection

@section('content')
    {{-- posts modals --}}
    @include('users.posts.posts_modals')

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

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">cancel</button>
                        <button type="button" id="add_post_btn" class="btn btn-primary">add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <button class="btn btn-primary add_post" data-bs-target="#add_post_modal" data-bs-toggle="modal" style="margin-top: 15px;
            margin-left: 277px;">add post</button>
    <!--      posts     -->
    <div class="parent_posts">
        @include('users.posts.index_posts')
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/users/posts/index.js') }}"></script>
    <script src="{{ asset('js/users/general_posts.js') }}"></script>
@endsection
