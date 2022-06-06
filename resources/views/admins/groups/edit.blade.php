@extends('layouts.adminApp')

@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success text-center">{{ Session::get('success') }}</div>
    @endif

    @if (Session::has('error'))
        <div class="alert alert-danger text-center">{{ Session::get('error') }}</div>
    @endif

    <form method="post" action="{{ route('admins-groups.update',$admins_group->id) }}" enctype="multipart/form-data">
        @method('put')
        @csrf

        <input type="hidden" name="photo_id" value="1">

        <div class="form-group" style="margin-top: 20px;width: 50%">
            <label for="exampleInputEmail1">
                {{ __('titles.photo') }}
            </label>
            <input type="file" name="photo" class="form-control" aria-describedby="emailHelp">
            @error('photo')
                <small style="color: red">
                    {{ $message }}
                </small>
            @enderror
        </div>


        <div class="card text-white bg-dark mb-3" style="max-width: 34rem;margin-top: 20px">
            <div class="card-header">{{ __('titles.add group') }}</div>
            <div class="card-body">

                <div class="form-group">
                    <label for="exampleInputEmail1">
                        {{ __('titles.name') }}
                    </label>
                    <input type="text" name="name" value="{{ $admins_group->name }}" class="form-control"
                        aria-describedby="emailHelp">
                    @error("name")
                        <small style="color: red">
                            {{ $message }}
                        </small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword1">
                        {{ __('titles.description') }}
                    </label>
                    <textarea type="text" name="description"  class="form-control">{{ $admins_group->description }}</textarea>
                    @error("description")
                        <small style="color: red">
                            {{ $message }}
                        </small>
                    @enderror
                </div>

            </div>
        </div>

        <button type="submit" class="btn btn-primary"
            style="margin-top: 10px;margin-bottom: 10px">{{ __('titles.update') }}</button>



    </form>
@endsection