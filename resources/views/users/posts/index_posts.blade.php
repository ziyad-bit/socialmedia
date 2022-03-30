@isset($posts)
    @if ($posts->count() > 0)
        @foreach ($posts as $post)
            <section class="d-flex justify-content-center post{{ $post->id }}" id="{{ $post->id }}">
                <div class="card bg-light mb-3" style="width: 500px;">

                    <!--      card top      -->
                    <div class="card-header card-top">
                        <img src="{{ asset('images/users/' . $post->users->photo) }}" alt="loading" class="rounded-circle">
                        <span> {{ $post->users->name }}</span>
                        <!-- diff_date is autoloaded from app\helper\general -->
                        <small>{{ diff_date($post->created_at) }}</small>

                        @can('update_or_delete', $post)
                            <i class="fas fa-edit edit_post" data-bs-toggle="modal" data-bs-target="#edit_post_modal"
                                data-post_id="{{ $post->id }}"></i>

                            <i class="fas fa-trash delete_post" data-bs-toggle="modal" data-bs-target="#delete_post_modal"
                                data-post_id="{{ $post->id }}"></i>
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


                        <p class="text{{ $post->id }}">
                            {{ $post->text }}
                        </p>

                        @if ($post->file)
                            <a href="{{ url('posts/download/' . $post->file) }}"
                                class="btn btn-primary file{{ $post->id }}">
                                <i class="fas fa-arrow-down"></i>{{ strstr($post->file, '-') }}
                            </a>
                            <embed src="{{ asset('files/' . $post->file) }}">
                        @endif

                        @if ($post->photo)
                            <img src="{{ asset('images/posts/' . $post->photo) }}" alt="loading"
                                class="image photo{{ $post->id }}">
                        @endif

                        @if ($post->video)
                            <video class="video{{ $post->id }}" src="{{ asset('videos/' . $post->video) }}"
                                controls></video>
                        @endif

                        <small class="number_comments">
                            @if ($post->comments_count >= 1)
                                <span style="font-weight: bold"><span
                                        class="com_num{{ $post->id }}">{{ $post->comments_count }}</span>
                                    comments</span>
                            @else
                                <span style="font-weight: bold"><span class="com_num{{ $post->id }}"> 0 </span>
                                    comments</span>
                            @endif

                            @if ($post->likes_count >= 1)
                                <span><span class="like_num{{ $post->id }}">{{ $post->likes_count }}</span>
                                    likes</span>
                            @else
                                <span><span class="like_num{{ $post->id }}">0 </span> likes</span>
                            @endif

                            @if ($post->shares_count >= 1)
                                <span style="font-weight: bold"><span
                                        class="share_num{{ $post->id }}">{{ $post->shares_count }}</span>
                                    shares</span>
                            @else
                                <span style="font-weight: bold"><span class="share_num{{ $post->id }}">0 </span>
                                    shares</span>
                            @endif

                        </small>
                    </div>
                    <a class="comment_link" post_id={{ $post->id }}>
                        <div class="card-body  comment_btn" style="background-color:#eee ">
                            @if ($post->likes->count() > 0)
                                <i class="fas fa-thumbs-up like liked_icon" data-post_id="{{ $post->id }}">like</i>
                            @else
                                <i class="fas fa-thumbs-up like like_icon" data-post_id="{{ $post->id }}">like</i>
                            @endif

                            <i class="fas fa-share share share_icon" data-bs-toggle="modal" data-bs-target="#share_modal"
                                data-post_id="{{ $post->id }}">share</i>

                            <i class="fas fa-comment comment_icon" id="{{ $post->id }}">Comment</i>
                        </div>
                    </a>

                    <!--      card bottom      -->
                    <div class="card-header card-bottom" data-post_id="{{ $post->id }}"
                        id="{{ 'post_' . $post->id }}" data-comments="true">
                        @if ($post->comments_count != 0)
                            <small class="view_comments" data-view="false" data-post_id="{{ $post->id }}"
                                data-com_req="false">
                                view
                                comments
                            </small>
                        @endif

                        <div class="parent_comments{{ $post->id }}">

                        </div>

                        <form id="{{ 'form_comment' . $post->id }}" class="form_comment">

                            <img src="{{ asset('images/users/' . Auth::user()->photo) }}" alt="loading"
                                class="rounded-circle img_input">
                            <textarea name="text" data-post_id="{{ $post->id }}" id="{{ 'input' . $post->id }}" cols="20" rows="2"
                                class="form-control comment_input"></textarea>
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <small style="color: red; display:none" id="comment_err"></small>
                        </form>
                    </div>
                </div>

            </section>
        @endforeach
    @endif

@endisset
