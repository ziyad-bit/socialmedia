@extends('layouts.app')

@section('header')
    <link rel="stylesheet" href="{{ asset('css/users/posts/index.css') }}">
@endsection

@section('content')
    <!--       edit comment modal        -->
    <div class="modal fade" id="edit_modal" tabindex="-1" aria-labelledby="delete_modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit_modal"> Edit comment </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-success text-center" id="success_msg" style="display: none"></div>
                    <div id="update_input" class="form-control" contenteditable="true"></div>
                    <small style="color: red; display:none" id="error"></small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">cancel</button>
                    <button type="button" id="update_btn" comment_id='' class="btn btn-primary">update</button>
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
