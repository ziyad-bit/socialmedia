@if ($users->count() > 0)
    @foreach ($users as $user)
        <div class="card-body">
            <img src="{{ asset('images/users/' . $user->photo) }}" class="rounded-circle" style="width: 80px"
                alt="loading">

            <span class="card-title">
                {{ $user->name }}
            </span>
            <a class="btn btn-primary">add</a>
            <div class="card-text">
                {{ $user->work }}
            </div>

        </div>
    @endforeach
@endif


@if ($groups->count() > 0)
    @foreach ($groups as $group)
    <div class="card-body">
        <img src="{{ asset('images/groups/' . $group->photo) }}" class="rounded-circle" style="width: 100px"
            alt="loading">
        <span class="card-title">
            {{ $group->name }}
        </span>
        <a class="btn btn-primary">join</a>
        <div class="card-text">
            {{ $group->description }}
        </div>

    </div>
    @endforeach
@endif


