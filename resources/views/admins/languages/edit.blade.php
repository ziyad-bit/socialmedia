@extends('layouts.AdminApp')

@section('content')
@if (Session::has('success'))
    <div class="alert alert-success text-center">{{ Session::get('success') }}</div>
@endif

<div class="container">
    <div class="row justify-content-center" style="margin-top: 100px">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('edit language') }}</div>

                <div class="card-body">
                    <form  action="{{ route('admins-language.update',$admins_language->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group ">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" value="{{$admins_language->name}}" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" min="3" max="50" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        

                        <div class="form-group">
                            <label for="exampleInputPassword1">direction</label>
                            <select name="direction" class="form-select">
                                <option value="rtl" {{$admins_language->direction == 'rtl' ? 'selected' : null }}> right to left </option>
                                <option value="ltr" {{$admins_language->direction == 'ltr' ? 'selected' : null }}> left to right </option>
                            </select>
                            @error('direction')
                                <small style="color: red">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <div class="form-group ">
                            <label for="abbr" class="col-md-4 col-form-label text-md-right">{{ __('abbr') }}</label>

                            <div class="col-md-6">
                                <input id="abbr" value="{{$admins_language->abbr}}" type="text" class="form-control @error('abbr') is-invalid @enderror" name="abbr" min="8" max="50" required autocomplete="new-abbr">

                                @error('abbr')
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
