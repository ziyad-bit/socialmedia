@extends('layouts.AdminApp')

@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success text-center">{{ Session::get('success') }}</div>
    @endif

    @if (Session::has('error'))
        <div class="alert alert-danger text-center">{{ Session::get('error') }}</div>
    @endif

    <a class="btn btn-primary" href="{{ route('languages.create') }}" style="margin-top: 20px">add language</a>

    <table class="table" style="margin-top: 20px">
        <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">name</th>
                <th scope="col">direction</th>
                <th scope="col">abbr</th>
                <th scope="col">control</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($languages as $language)
                <tr>
                    <th scope="row">{{ $language->id }}</th>
                    <td>{{ $language->name }}</td>
                    <td>{{ $language->direction }}</td>
                    <td>{{ $language->abbr }}</td>
                    <td>
                        <a href="{{ route('languages.edit',$language->id) }}" class='btn btn-primary'>
                            {{__('titles.edit')}}
                        </a>

                        <form action="{{route('languages.destroy',$language->id)}}" method="POST" style="display: inline-block">
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
    {{$languages->links()}}
@endsection

