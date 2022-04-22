<div class="{{ 'comment com' . $comment->post_id }}" id="{{ 'comm' . $comment->id }}">

    <img src="{{ asset('images/users/' . Auth::user()->photo) }}" alt="loading" class="rounded-circle">
    <span>{{ Auth::user()->name }}</span>

    <small>{{ diff_date($comment->created_at) }}</small>
    <p>
        <span>{{ $comment->text }}</span>
        <i id="delete_icon" class="fas fa-trash" data-bs-toggle="modal" data-bs-target="#delete_modal"
        data-comment_id="{{ $comment->id }}" data-post_id="{{ $comment->post_id }}"></i>

    <i data-bs-toggle="modal" data-bs-target="#edit_modal" class="fas fa-edit edit_comment"
        data-comment_id="{{ $comment->id }}" data-post_id="{{ $comment->post_id }}"></i>
    </p>
</div>
