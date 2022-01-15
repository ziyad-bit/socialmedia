@extends('layouts.app')

@section('header')
    <link rel="stylesheet" href="{{ asset('css/users/search.css') }}">
@endsection

@section('content')
    @if (Session::has('error'))
        <div class="alert alert-success text-center">{{ Session::get('error') }}</div>
    @endif

    <div class="d-flex justify-content-center" style="margin-top: 30px">
        <div class="card text-dark bg-light mb-3" style="width: 50rem;">
            <div class="card-header">All</div>
            @isset($users)
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
            @endisset


            @isset($groups)
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
            @endisset

        </div>
    </div>

@endsection

@section('script')
    <script src="{{asset('js/search/index.js')}}"></script>
@endsection
