@extends('layouts.app')

@section('header')
    <link rel="stylesheet" href="{{ asset('css/users/search.css') }}">
@endsection

@section('content')
    @if (Session::has('error'))
        <div class="alert alert-danger text-center">{{ Session::get('error') }}</div>
    @endif

    @if ($users->count() == 0 && $groups->count() == 0)
        <h3 class="text-center">no matched results</h3>
    @else
        <div class="d-flex justify-content-center" style="margin-top: 30px">
            <div class="card text-dark bg-light mb-3" style="width: 50rem;">
                <div class="card-header" data-status="1">All</div>

                @include('users.search.next_search')
                
            </div>
        </div>
    @endif


@endsection

@section('script')
    <script src="{{ asset('js/users/search/index.js') }}"></script>
@endsection
