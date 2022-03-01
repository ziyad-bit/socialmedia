@extends('layouts.app')

@section('header')
    <link rel="stylesheet" href="{{ asset('css/users/posts/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/users/group/show.css') }}">
@endsection

@section('content')
    @include('users.posts.posts_modals')

    <div class="d-flex justify-content-center group">
        <img src="{{ asset('images/groups/' . $group->photo) }}" alt="loading error" class="rounded-circle group_photo">

        <span class="group_name">{{ $group->name }} ({{ $group_members_count .' Members'}})</span>

        <div class="group_description">{{ $group->description }}</div>
    </div>

    <hr>

    <div class="parent_posts" data-page_code="{{ $page_code }}">
        @include('users.posts.index_posts')
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/users/general_posts.js') }}"></script>
    <script src="{{ asset('js/users/group/index.js') }}"></script>
@endsection
