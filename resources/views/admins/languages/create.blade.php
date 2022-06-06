@extends('layouts.adminApp')

@section('header')
    <link rel="stylesheet" href="{{asset('css/admins/languages/create.css')}}">
@endsection

@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success text-center">{{ Session::get('success') }}</div>
    @endif

    <div class="container">
        <div class="row justify-content-center" style="margin-top: 100px;">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('add language') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admins-language.store') }}">
                            @csrf

                            <div class="form-group ">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" value="{{ old('name') }}" min="3" max="50" required
                                        autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group ">
                                <label for="abbr" class="col-md-4 col-form-label text-md-right">{{ __('abbr') }}</label>

                                <div class="col-md-6">
                                    <input id="abbr" type="text" class="form-control @error('abbr') is-invalid @enderror"
                                        name="abbr" value="{{ old('abbr') }}" min="3" max="50" required
                                        autocomplete="abbr" autofocus>

                                    @error('abbr')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">direction</label>
                                <select name="direction" class="form-select">
                                    <option value=""> ... </option>
                                    <option value="rtl"> right to left </option>
                                    <option value="ltr"> left to right </option>
                                </select>
                                @error('direction')
                                    <small style="color: red">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary" style="margin-top: 10px">
                                {{ __('add') }}
                            </button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
