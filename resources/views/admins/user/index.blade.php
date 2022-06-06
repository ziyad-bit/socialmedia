@extends('layouts.adminApp')

@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success text-center">{{ Session::get('success') }}</div>
    @endif

    @if (Session::has('error'))
        <div class="alert alert-danger text-center">{{ Session::get('error') }}</div>
    @endif

    <a class="btn btn-primary" href="{{ route('admins-users.create') }}" style="margin-top: 20px">
        {{__('titles.add')}}
    </a>

    
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
            @foreach ($users as $user)
                <tr>
                    <th scope="row">{{ $user->id }}</th>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>

                    <td>
                        <a href="{{ route('admins-users.edit',$user->id) }}" class='btn btn-primary'>
                            {{__('titles.edit')}}
                        </a>

                        <a href="{{ route('admins.edit.user.password',$user->id) }}" class='btn btn-primary'>
                            edit password
                        </a>


                        <form action="{{route('admins-users.destroy',$user->id)}}" method="POST" style="display: inline-block">
                            @csrf
                            @method('delete')

                            <button type="submit" onclick="return confirm('Are you sure?')" class='btn btn-danger'>
                                {{__('titles.delete')}}
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
    {{$users->links()}}
@endsection

