@isset($posts)
    @if ($posts->count() > 0)
        @foreach ($posts as $post)
            @include('users.posts.add_post')
        @endforeach
    @endif

@endisset
