@extends('layouts.adminApp')

@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success text-center">{{ Session::get('success') }}</div>
    @endif

    @if (Session::has('error'))
        <div class="alert alert-danger text-center">{{ Session::get('error') }}</div>
    @endif

    <a class="btn btn-primary" href="{{ url('admins/create') }}" style="margin-top: 20px">add admin</a>

    <table class="table" style="margin-top: 20px">
        <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">name</th>
                <th scope="col">email</th>
                <th scope="col">control</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($admins as $admin)
                <tr>
                    <th scope="row">{{ $admin->id }}</th>
                    <td>{{ $admin->name }}</td>
                    <td>{{ $admin->email }}</td>
                    <td>
                        <a href="{{ url('admins/edit/' . $admin->id) }}" class='btn btn-primary'>
                            edit
                        </a>

                        <a href="{{ url('admins/delete/' . $admin->id) }}" class='btn btn-danger'>
                            delete
                        </a>

                        
                        
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
    {{$admins->links()}}
@endsection

