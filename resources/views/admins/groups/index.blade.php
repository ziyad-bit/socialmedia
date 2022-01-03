@extends('layouts.AdminApp')

@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success text-center">{{ Session::get('success') }}</div>
    @endif

    @if (Session::has('error'))
        <div class="alert alert-danger text-center">{{ Session::get('error') }}</div>
    @endif

    <a class="btn btn-primary" href="{{ route('groups.create') }}" style="margin-top: 20px">add group</a>

    <table class="table" style="margin-top: 20px">
        <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">name</th>
                <th scope="col">description</th>
                <th scope="col">photo</th>
                <th scope="col">control</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($groups as $group)
                <tr>
                    <th scope="row">{{ $group->id }}</th>
                    <td>{{ $group->name }}</td>
                    <td>{{ $group->description }}</td>
                    <td><img src="{{$group->photo}}" alt="loading"></td>
                    <td>
                        <a href="{{ route('groups.edit',$group->id) }}" class='btn btn-primary'>
                            edit
                        </a>

                        <form action="{{route('groups.destroy',$group->id)}}" method="POST" style="display: inline-block">
                            @csrf
                            @method('delete')

                            <button type="submit" onclick="return confirm('Are you sure?')" class='btn btn-danger' style="margin-top: 10px">
                                delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
    {{$groups->links()}}
@endsection

