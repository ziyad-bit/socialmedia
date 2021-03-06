@if ($friends->count() > 0)
    @foreach ($friends as $friend)
        <div class="card-body">
            <img src="{{ asset('images/users/' . $friend->photo) }}" class="rounded-circle" style="width: 80px"
                alt="loading">

            <span class="card-title">
                <a href="{{route('users.index',str_replace(' ','-',$friend->name))}}">{{$friend->name}}</a>
            </span>

            @if ($friend->auth_add_friends->count() > 0)
                @foreach ($friend->auth_add_friends as $friend_user)
                    {{---  0 =friend request   and   2 = ignored request --}}
                    @if ($friend_user->request->status == 0 || $friend_user->request->status == 2)
                        <button class="btn btn-primary awaiting_btn" disabled="true">
                            {{ __('titles.awaiting approval') }}
                        </button>
                    @endif

                    {{---  1 = friend --}}
                    @if ($friend_user->request->status == 1)
                        <a class="btn btn-success message_btn" href="{{route('message.index.friends')}}">
                            {{ __('titles.chat') }}
                        </a>
                    @endif
                @endforeach
            @endif

            @if ($friend->friends_add_auth->count() > 0)
                @foreach ($friend->friends_add_auth as $friend_user)
                    @if ($friend_user->request->status == 0 || $friend_user->request->status == 2)
                        <button class="btn btn-primary awaiting_btn" disabled="true">
                            {{ __('titles.awaiting approval') }}
                        </button>
                    @endif

                    @if ($friend_user->request->status == 1)
                        <a class="btn btn-success message_btn" href="{{route('message.index.friends')}}">
                            {{ __('titles.chat') }}
                        </a>
                    @endif
                @endforeach
            @endif

            <div class="card-text">
                {{ $friend->work }}
            </div>
        </div>
        <hr>
    @endforeach
@endif

{{--   no friend request   --}}
@if ($users->count() > 0)
    @foreach ($users as $user)
        <div class="card-body">
            <img src="{{ asset('images/users/' . $user->photo) }}" class="rounded-circle" style="width: 80px"
                alt="loading">

            <span class="card-title">
                <a href="{{route('users.index', str_replace('','-',$user->name) )}}">{{$user->name}}</a>
            </span>

            <button class="btn btn-primary add_btn" data-friend_id="{{ $user->id }}">
                {{ __('titles.send request') }}
            </button>
            

            <div class="card-text">
                {{ $user->work }}
            </div>
        </div>
        <hr>
    @endforeach
@endif

@if ($groups_joined->count() > 0)
    @foreach ($groups_joined as $group_joined)
        <div class="card-body">
            <img src="{{ asset('images/groups/' . $group_joined->photo) }}" class="rounded-circle" style="width: 100px"
                alt="loading">

            <span class="card-title">
                <a href="{{ route('groups.posts.index',$group_joined->slug) }}"  >
                    {{ $group_joined->name }}
                </a>
            </span>

            @if ($group_joined->group_users)
                @foreach ($group_joined->group_users as $group_user)
                    @if ($group_user->request->role_id == null)
                        <button class="btn btn-primary awaiting_btn" disabled="true">
                            {{ __('titles.awaiting approval') }}
                        </button>
                    @else
                        <button class="btn btn-primary awaiting_btn" disabled="true">
                            {{ __('titles.joined') }}
                        </button>
                    @endif
                @endforeach
            @endif

            <div class="card-text">
                {{ $group_joined->description }}
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
                <a href="{{ route('groups.posts.index',$group->slug) }}"  >
                    {{ $group->name }}
                </a>
                
            </span>
            <button class="btn btn-primary join_btn" data-group_id="{{$group->id}}">{{ __('titles.join') }}</button>
            <div class="card-text">
                {{ $group->description }}
            </div>
        </div>
        <hr>
    @endforeach
@endif
