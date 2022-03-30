@if ($group_admins->count() > 0)
    @foreach ($group_admins as $group_admin)
        @foreach ($group_admin->group_joined as $group_req)
            <div class="card-body group_user{{ $group_req->request->id }}">
                <img src="{{ asset('images/users/' . $group_admin->photo) }}" class="rounded-circle" style="width: 80px"
                    alt="loading">

                <span class="card-title">
                    {{ $group_admin->name }}
                </span>
                
                @can('owner', $group_auth)
                    <button class="btn btn-danger btn_delete_from_group" data-group_req_id="{{ $group_req->request->id }}">
                        delete from group
                    </button>

                    <button class="btn btn-danger btn_remove_admin" data-group_req_id="{{ $group_req->request->id }}">
                        remove admin
                    </button>
                @endcan

            </div>
        @endforeach
    @endforeach
@endif
