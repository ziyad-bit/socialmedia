@if ($group_users->count() > 0)
    @foreach ($group_users as $group_user)
        @foreach ($group_user->group_joined as $group_req)
            <div class="card-body group_user{{ $group_req->request->id }}">
                <img src="{{ asset('images/users/' . $group_user->photo) }}" class="rounded-circle" style="width: 80px"
                    alt="loading">

                <span class="card-title">
                    {{ $group_user->name }}
                </span>

                @can('owner_admin', $group_user)
                    <button class="btn btn-danger btn_delete" data-group_req_id="{{ $group_req->request->id }}">
                        delete
                    </button>

                    @can('not_punished',[App\Models\Group_users::class, $group_req->request])
                        
                        <button class="btn btn-danger btn_punish" data-group_req_id="{{ $group_req->request->id }}">
                            punish for week
                        </button>

                        <button class="btn btn-primary btn_add_admin" data-group_req_id="{{ $group_req->request->id }}">
                            add admin
                        </button>
                    @else
                        <button class="btn btn-danger btn_punish" disabled='true'>
                            punished
                        </button>
                        
                    @endcan
                @endcan

            </div>
        @endforeach
    @endforeach
@endif
