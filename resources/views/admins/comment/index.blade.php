@extends('layouts.AdminApp')

@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success text-center">{{ Session::get('success') }}</div>
    @endif

    @if (Session::has('error'))
        <div class="alert alert-danger text-center">{{ Session::get('error') }}</div>
    @endif

    <table class="table" style="margin-top: 20px">
        <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">text</th>
                <th scope="col">control</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($comments as $comment)
                <tr>
                    <th scope="row">{{ $comment->id }}</th>
                    <td>{{ $comment->text }}</td>
                    <td>
                        <a href="{{ route('admins-comments.edit',$comment->id) }}" class='btn btn-primary'>
                            {{__('titles.edit')}}
                        </a>

                        <form action="{{route('admins-comments.destroy',$comment->id)}}" method="POST" style="display: inline-block">
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
    {{$comments->links()}}
@endsection

