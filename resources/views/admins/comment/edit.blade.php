@extends('layouts.adminApp')

@section('content')
@if (Session::has('success'))
    <div class="alert alert-success text-center">{{ Session::get('success') }}</div>
@endif

<div class="container">
    <div class="row justify-content-center" style="margin-top: 100px">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('edit admin') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admins-comments.update',$admins_comment->id) }}">
                        @csrf
                        @method('put')
                        <input type="hidden" name="post_id" value="1">
                        <div class="form-group ">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input  value="{{$admins_comment->text}}" type="text" class="form-control @error('text') is-invalid @enderror" name="text" value="{{ old('text') }}" min="3" max="50" required autocomplete="text" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary" style="margin-top: 10px">
                            {{ __('update') }}
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
