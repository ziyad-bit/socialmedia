@extends('layouts.app')

@section('header')
    <link rel="stylesheet" href="{{ asset('css/users/posts/index.css') }}">
@endsection

@section('content')
    <!--       delete comment modal        -->
    <div class="modal fade" id="delete_modal" tabindex="-1" aria-labelledby="delete_modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="delete_modal"> Delete comment </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-success text-center" id="delete_msg" style="display: none"></div>
                    <div class="alert alert-danger text-center" id="err_delete_msg" style="display: none"></div>
                    <h4>Are you want to delete it?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">cancel</button>
                    <button type="button" id="delete_btn" data-comment_id='' data-post_id="" class="btn btn-danger">delete</button>
                </div>
            </div>
        </div>
    </div>

    <!--       edit comment modal        -->
    <div class="modal fade" id="edit_modal" tabindex="-1" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit_modal"> Edit comment </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-success text-center" id="success_msg" style="display: none"></div>
                    <div id="update_input" class="form-control" contenteditable="true"></div>
                    <small style="color: red; display:none" id="error"></small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">cancel</button>
                    <button type="button" id="update_btn" data-comment_id='' class="btn btn-primary">update</button>
                </div>
            </div>
        </div>
    </div>

    <!--      posts     -->
    <div class="parent">
        @include('users.posts.index_posts')
    </div>


@endsection

@section('script')
    <script src="{{ asset('js/users/posts/index.js') }}"></script>
@endsection
