@if ($users->count() > 0)
    @foreach ($users as $user)
        <div class="card-body">
            <img src="{{ asset('images/users/' . $user->photo) }}" class="rounded-circle" style="width: 80px"
                alt="loading">

            <span class="card-title">
                {{ $user->name }}
            </span>

            @if ($user->auth_add_friends->count() > 0)
                @foreach ($user->auth_add_friends as $friend)
                    {{---  0 =friend request   and   2 = ignored request --}}
                    @if ($friend->request->status == 0 || $friend->request->status == 2)
                        <button class="btn btn-primary" disabled="true">
                            awaiting approval 
                        </button>
                    @endif

                    {{---  1 = friend --}}
                    @if ($friend->request->status == 1)
                        <a class="btn btn-success ">
                            message
                        </a>
                    @endif
                @endforeach
            @endif

            @if ($user->friends_add_auth->count() > 0)
                @foreach ($user->friends_add_auth as $friend)
                    @if ($friend->request->status == 0 || $friend->request->status == 2)
                        <button class="btn btn-primary" disabled="true">
                            awaiting approval 
                        </button>
                    @endif

                    @if ($friend->request->status == 1)
                        <a class="btn btn-success ">
                            message
                        </a>
                    @endif
                @endforeach
            @endif

            @if ($user->auth_add_friends->count() == 0 && $user->friends_add_auth->count() == 0)
                <button class="btn btn-primary add_btn" data-user_id="{{ $user->id }}">
                    add
                </button>
            @endif

            <div class="card-text">
                {{ $user->work }}
            </div>
        </div>
        <hr>
    @endforeach
@endif


@if ($groups->count() > 0)
    @foreach ($groups as $group)
        <div class="card-body">
            <img src="{{ asset('images/groups/' . $group->photo) }}" class="rounded-circle" style="width: 100px"
                alt="loading">
            <span class="card-title">
                <a href="{{ route('groups.posts.index',$group->id) }}"  >
                    {{ $group->name }}
                </a>
                
            </span>
            <a class="btn btn-primary">join</a>
            <div class="card-text">
                {{ $group->description }}
            </div>
        </div>
        <hr>
    @endforeach
@endif
