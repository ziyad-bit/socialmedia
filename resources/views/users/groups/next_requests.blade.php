@if ($group_reqs->count() > 0)
    @foreach ($group_reqs as $group_req)
        <div class="card-body">
            <img src="{{ asset('images/users/' . $group_req->photo) }}" class="rounded-circle" style="width: 80px"
                alt="loading">

            <span class="card-title">
                {{ $group_req->name }}
            </span>

            <button class="btn btn-primary btn_approve" data-group_req_id="{{ $group_req->id }}">
                approve
            </button>

            <button class="btn btn-danger btn_ignore" data-group_req_id="{{ $group_req->id }}">
                ignore
            </button>

        </div>
    @endforeach
@endif
