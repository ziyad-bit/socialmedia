@if ($notifications->count() > 0)
    @foreach ($notifications as $notification)
        <div class="list-group" data-notif_id="{{ $notification->id }}">
            <a href="/friends/requests" class="list-group-item list-group-item-action notif_hover">
                <div class="d-flex w-100 justify-content-between">
                    <img src="/images/users/{{ $notification->user->photo }}" class="rounded-circle" alt="error">
                    <h5 class="mb-1 p">{{ $notification->user->name }} sent friend request</h5>

                </div>
                <small class="text-muted">{{ diff_date($notification->created_at) }}</small>
            </a>
        </div>
    @endforeach
@endif