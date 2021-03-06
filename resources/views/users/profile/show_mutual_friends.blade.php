@extends('layouts.app')

@section('header')
    <link rel="stylesheet" href="{{ asset('css/users/search.css') }}">
@endsection

@section('content')
    <div class="d-flex justify-content-center" style="margin-top: 30px">
        <div class="card text-dark bg-light mb-3 parent_friends"  style="width: 50rem;">
            <div class="card-header" data-status="1">friends</div>
            @foreach ($mutual_friends as $mutual_friend)
                <div class="card-body">
                    <img src="{{ asset('images/users/' . $mutual_friend->photo) }}" class="rounded-circle" style="width: 100px"
                        alt="loading">
                    <span class="card-title">
                        {{ $mutual_friend->name }}
                    </span>
                    <a class="btn btn-success message_btn" href="{{route('message.index.friends')}}">message</a>
                    <div class="card-text" style="position: relative;
                    top: 5px;">
                        {{ $mutual_friend->work }}
                    </div>
                </div>
                <hr>
            @endforeach
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/users/profile/show.js') }}"></script>
@endsection