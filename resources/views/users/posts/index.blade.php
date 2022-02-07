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
    @if ($friends_posts)
        @foreach ($friends_posts as $friend)
            @foreach ($friend->posts as $post)

                <section class="d-flex justify-content-center">
                    <div class="card bg-light mb-3" style="max-width: 35rem;">

                        <!--      card top      -->
                        <div class="card-header card-top">
                            <img src="{{ asset('images/users/' . $friend->photo) }}" alt="loading" class="rounded-circle">
                            <span> {{ $friend->name }}</span>
                            <!-- diff_date is autoloaded from app\helper\general -->
                            <small>{{ diff_date($post->created_at) }}</small>
                            <p>
                                {{ $post->text }}
                            </p>

                            @if ($post->file)
                                <a href="{{ url('posts/download/' . $post->file) }}" class="btn btn-primary">
                                    <i class="fas fa-arrow-down"></i>{{ strstr($post->file, '-') }}
                                </a>
                                <embed src="{{ asset('files/' . $post->file) }}">
                            @endif

                            @if ($post->photo)
                                <img src="{{ $post->photo }}" alt="loading" class="image" style="height: 400px">
                            @endif

                            @if ($post->video)
                                <video src="{{ asset('videos/' . $post->video) }}" controls></video>
                            @endif

                            <small class="number_comments"><span>{{ $post->comments_count }} comments</span> </small>
                        </div>
                        <a class="comment_link" post_id={{ $post->id }}>
                            <div class="card-body d-flex justify-content-center comment_btn" id="{{ $post->id }}"
                                style="background-color:#eee ">
                                <i class="fas fa-comment"></i>Comment
                            </div>
                        </a>

                        <!--      card bottom      -->
                        <div class="card-header card-bottom">
                            @if ($post->comments_count != 0)
                                <small class=" {{ 'view_comments ' . $post->id }}" id="{{ 'view' . $post->id }}">view
                                    all comments</small>
                            @endif

                            @foreach ($post->comments as $comment)
                                <div class="{{ 'comment com' . $post->id }}" id="{{ 'comm' . $comment->id }}"
                                    style="display: none">
                                    @if ($comment->users->photo)
                                        <img src="{{ asset('images/users/' . $comment->users->photo) }}" alt="loading"
                                            class="rounded-circle">
                                        <span>{{ $comment->users->name }}</span>
                                    @else
                                        <img src="{{ asset('images/users/' . $comment->users->photo) }}" alt="loading"
                                            class="rounded-circle">
                                        <span>{{ $comment->users->name }}</span>
                                    @endif

                                    <small>{{ diff_date($comment->created_at) }}</small>

                                    <p >
                                        <span>{{ $comment->text }}</span>
                                        @if ($comment->user_id == Auth::user()->id)
                                            <i id="delete_icon" onclick="return confirm('Are you sure')"
                                                class="fas fa-trash" data-id="{{ $comment->id }}"></i>
                                            <i data-bs-toggle="modal" data-bs-target="#edit_modal"
                                                class="{{ 'fas fa-edit ' . $comment->id }}"></i>
                                        @endif
                                    </p>

                                </div>
                            @endforeach
                            <form id="{{ 'form_comment' . $post->id }}" class="form_comment">
                                
                                <img src="{{ asset('images/users/' . Auth::user()->photo) }}" alt="loading"
                                    class="rounded-circle img_input">
                                <textarea name="text" data-post_id="{{ $post->id }}" id="{{ 'input' . $post->id }}"
                                    cols="20" rows="2" class="form-control comment_input"></textarea>
                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                <small style="color: red; display:none"></small>
                            </form>
                        </div>
                    </div>

                </section>
            @endforeach
        @endforeach

    @endif

@endsection

@section('script')
    <script src="{{ asset('js/users/posts/index.js') }}"></script>
@endsection
