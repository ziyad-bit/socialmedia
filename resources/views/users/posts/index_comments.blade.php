@foreach ($comments as $comment)
    <div class="{{ 'comment com' . $comment->post_id }}" id="{{ 'comm' . $comment->id }}"
        data-comment_id="{{ $comment->id }}" style="display: block">
        @if ($comment->user->photo)
            <img src="{{ asset('images/users/' . $comment->user->photo) }}" alt="loading" class="rounded-circle">
            <span>{{ $comment->user->name }}</span>
        @endif

        <small>{{ diff_date($comment->created_at) }}</small>

        <p>
            <span>{{ $comment->text }}</span>
            @can('update_or_delete', $comment)
                <i id="delete_icon" class="fas fa-trash" data-bs-toggle="modal" data-bs-target="#delete_modal"
                    data-comment_id="{{ $comment->id }}" data-post_id="{{ $comment->post_id }}"></i>

                <i data-bs-toggle="modal" data-bs-target="#edit_modal" class="fas fa-edit edit_comment"
                    data-comment_id="{{ $comment->id }}" data-post_id="{{ $comment->post_id }}"></i>
            @endcan
        </p>
    </div>
@endforeach
