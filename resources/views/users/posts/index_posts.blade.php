@if ($friends_posts->count() > 0)
    @foreach ($friends_posts as $post)
        <section class="d-flex justify-content-center post{{$post->id}}" id="{{ $post->id }}">
            <div class="card bg-light mb-3" style="max-width: 35rem;">

                <!--      card top      -->
                <div class="card-header card-top">
                    <img src="{{ asset('images/users/' . $post->users->photo) }}" alt="loading" class="rounded-circle">
                    <span> {{ $post->users->name }}</span>
                    <!-- diff_date is autoloaded from app\helper\general -->
                    <small>{{ diff_date($post->created_at) }}</small>

                    @can('update_or_delete', $post)
                        <i class="fas fa-edit edit_post" ></i>

                        <i class="fas fa-trash delete_post" data-bs-toggle="modal"
                        data-bs-target="#delete_post_modal" data-post_id="{{$post->id}}"></i>
                    @endcan

                    @if ($post->shares->count() > 0)
                        <span class="share_name" style="margin-left: 3px">shared this post</span>
                        @foreach ($post->shares->take(2) as $share)
                            @if ($share->users->id != Auth::id())
                                <span class="share_name"> ,
                                    {{ Illuminate\Support\Str::limit($share->users->name, 6, '...') }}</span>
                            @endif
                        @endforeach

                        @foreach ($post->shares as $share)
                            @if ($share->users->id == Auth::id())
                                <span class="share_name"> you </span>
                            @endif

                        @endforeach
                    @endif


                    <p>
                        {{ $post->text }}
                    </p>

                    @if ($post->file)
                        <a href="{{ url('posts/download/' . $post->file) }}" class="btn btn-primary">
                            <i class="fas fa-arrow-down"></i>{{ strstr($post->file, '-') }}
                        </a>
                        <embed src="{{ asset('files/' . $post->file) }}">
                    @endif

                    @if ($post->photo)
                        <img src="{{ $post->photo }}" alt="loading" class="image" style="height: 400px">
                    @endif

                    @if ($post->video)
                        <video src="{{ asset('videos/' . $post->video) }}" controls></video>
                    @endif

                    <small class="number_comments">
                        <span style="font-weight: bold"><span
                                class="com_num{{ $post->id }}">{{ $post->comments_count }}</span>
                            comments</span>
                        <span><span class="like_num{{ $post->id }}">{{ $post->likes_count }}</span> likes</span>
                        <span style="font-weight: bold"><span
                                class="share_num{{ $post->id }}">{{ $post->shares_count }}</span> shares</span>
                    </small>
                </div>
                <a class="comment_link" post_id={{ $post->id }}>
                    <div class="card-body  comment_btn" style="background-color:#eee ">
                        @if ($post->likes->count() > 0)
                            <i class="fas fa-thumbs-up like liked_icon" data-post_id="{{ $post->id }}">like</i>
                        @else
                            <i class="fas fa-thumbs-up like like_icon" data-post_id="{{ $post->id }}">like</i>
                        @endif

                        <i class="fas fa-share share share_icon" data-bs-toggle="modal"
                        data-bs-target="#share_modal" data-post_id="{{ $post->id }}">share</i>

                        <i class="fas fa-comment comment_icon" id="{{ $post->id }}">Comment</i>
                    </div>
                </a>

                <!--      card bottom      -->
                <div class="card-header card-bottom" data-post_id="{{ $post->id }}">
                    @if ($post->comments_count != 0)
                        <small class="view_comments" data-view="false"  id="{{$post->id}}" data-comments="false" data-com_req="false">
                            view
                            comments
                        </small>
                    @endif

                    <div class="parent_comments{{ $post->id }}">
                        
                    </div>

                    <form id="{{ 'form_comment' . $post->id }}" class="form_comment">

                        <img src="{{ asset('images/users/' . Auth::user()->photo) }}" alt="loading"
                            class="rounded-circle img_input">
                        <textarea name="text" data-post_id="{{ $post->id }}" id="{{ 'input' . $post->id }}"
                            cols="20" rows="2" class="form-control comment_input"></textarea>
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <small style="color: red; display:none" id="comment_err"></small>
                    </form>
                </div>
            </div>

        </section>

    @endforeach

@endif
