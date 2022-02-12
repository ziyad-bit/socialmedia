@foreach ($comments as $comment)
    <div class="{{ 'comment com' . $comment->post_id }}" id="{{ 'comm' . $comment->id }}" 
        data-comment_id="{{ $comment->id }}">
        @if ($comment->users->photo)
            <img src="{{ asset('images/users/' . $comment->users->photo) }}" alt="loading" class="rounded-circle">
            <span>{{ $comment->users->name }}</span>
        @endif

        <small>{{ diff_date($comment->created_at) }}</small>

        <p>
            <span>{{ $comment->text }}</span>
            @if ($comment->user_id == Auth::user()->id)
                <i id="delete_icon"  class="fas fa-trash" data-bs-toggle="modal" data-bs-target="#delete_modal"
                    data-comment_id="{{ $comment->id }}" data-post_id="{{$comment->post_id }}"></i>
                    
                <i data-bs-toggle="modal" data-bs-target="#edit_modal"
                    class="{{ 'fas fa-edit ' . $comment->id }}"></i>
            @endif
        </p>

    </div>
@endforeach
