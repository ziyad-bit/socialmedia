@extends('layouts.app')

@section('header')
<title>
    
    {{  'Groups - ' .config('app.name') }}
    
</title>

<meta name="keywords" content="groups page contain information about all groups which you joined">
@endsection

@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success text-center">{{ Session::get('success') }}</div>
    @endif

    @if (Session::has('error'))
        <div class="alert alert-danger text-center">{{ Session::get('error') }}</div>
    @endif

    <a class="btn btn-primary" href="{{ route('group.create') }}" style="margin-top: 20px">
        {{ __('titles.add') }}
    </a>

    <table class="table" style="margin-top: 20px">
        <thead class="thead-dark">
            <tr>
                <th scope="col">number</th>
                <th scope="col">photo</th>
                <th scope="col">name</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($groups_joined as $i => $group)
                <tr>
                    <th scope="row">{{ $i + 1 }}</th>

                    <td> <a href="{{ route('groups.posts.index', $group->slug) }}" >
                            <img src="{{ asset('images/groups/' . $group->photo) }}" alt="">
                        </a>
                    </td>

                    <td>
                        <a href="{{ route('groups.posts.index', $group->slug) }}" style="text-decoration: none">
                            {{ $group->name }}
                        </a>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
@endsection
