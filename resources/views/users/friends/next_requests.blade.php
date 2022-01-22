@if ($friend_reqs->count() > 0)
    @foreach ($friend_reqs as $friend_req)
        <div class="card-body">
            <img src="{{ asset('images/users/' . $friend_req->photo) }}" class="rounded-circle" style="width: 80px"
                alt="loading">

            <span class="card-title">
                {{ $friend_req->name }}
            </span>

            <button class="btn btn-primary" data-friend_req_id="{{ $friend_req->id }}">
                approve
            </button>

            <button class="btn btn-danger add_btn" data-friend_req_id="{{ $friend_req->id }}">
                ignore
            </button>


            <div class="card-text">
                {{ $friend_req->work }}
            </div>
        </div>
    @endforeach
@endif
