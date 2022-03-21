@if ($group_reqs->count() > 0)
    @foreach ($group_reqs as $user)
    @foreach ($user->group_joined as $group_req)
        <div class="card-body group_user{{ $group_req->request->id }}">
            <img src="{{ asset('images/users/' . $user->photo) }}" class="rounded-circle" style="width: 80px"
                alt="loading">

            <span class="card-title">
                {{ $user->name }}
            </span>
            
                <button class="btn btn-primary btn_approve" data-group_req_id="{{ $group_req->request->id }}">
                    approve
                </button>

                <button class="btn btn-danger btn_ignore" data-group_req_id="{{ $group_req->request->id }}">
                    ignore
                </button>
            
        </div>
        @endforeach
    @endforeach
@endif
