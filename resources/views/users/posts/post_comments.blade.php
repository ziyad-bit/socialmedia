<div class="{{'comment com'.$comment->post_id}}" id="{{'comm'.$comment->id}}" >
    
    <img src="{{asset('images/users/'.Auth::user()->photo)}}" alt="loading" class="rounded-circle">
    <span >{{Auth::user()->name}}</span>

    <small>{{diff_date($comment->created_at)}}</small>
    <p>
        {{$comment->text}}
        <i id="{{$comment->id}}" data-toggle="modal" data-target="#delete_modal" class="fas fa-trash"></i>
        <i  data-toggle="modal" data-target="#edit_modal" class="{{'fas fa-edit '.$comment->id}}"></i>
    </p>
</div>