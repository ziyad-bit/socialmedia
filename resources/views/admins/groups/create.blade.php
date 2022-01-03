@extends('layouts.adminApp')

@section('content')

    @if (Session::has('success'))
        <div class="alert alert-success text-center">{{ Session::get('success') }}</div>
    @endif

    @if (Session::has('error'))
        <div class="alert alert-danger text-center">{{ Session::get('error') }}</div>
    @endif

    <form method="POST" action="{{ route('groups.store') }}" enctype="multipart/form-data">
        @csrf

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

        
        <div class="form-group" style="width: 50%">
            <label for="exampleInputPassword1">status</label>
            <select name="status" class="form-select">
                <option value=""> ... </option>
                <option value="1"> closed </option>
                <option value="0"> open </option>
            </select>
            @error('status')
                <small style="color: red">
                    {{ $message }}
                </small>
            @enderror
        </div>

        @if ($languages->count() > 0)
            @foreach ($languages as $i => $lang)
                <div class="card text-white bg-dark mb-3" style="max-width: 34rem;margin-top: 20px">
                    <div class="card-header">{{ __('titles.add group') }} ({{ __('titles.' . $lang->abbr) }})</div>
                    <div class="card-body">


                        <div class="form-group">
                            <label for="exampleInputEmail1">
                                {{ __('titles.name') }} ({{ __('titles.' . $lang->abbr) }})
                            </label>
                            <input type="text" name="group[{{ $i }}][name]" class="form-control"
                                aria-describedby="emailHelp">
                            @error("group.$i.name")
                                <small style="color: red">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">
                                {{ __('titles.description') }} ({{ __('titles.' . $lang->abbr) }})
                            </label>
                            <textarea type="text" name="group[{{ $i }}][description]"
                                class="form-control"></textarea>
                            @error("group[{{ $i }}][description]")
                                <small style="color: red">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <input type="text" name="group[{{ $i }}][abbr]" style="display: none" value="{{ $lang->abbr }}"
                            class="form-control">

                    </div>
                </div>
            @endforeach

            <button type="submit" class="btn btn-primary"
            style="margin-top: 10px;margin-bottom: 10px">{{ __('titles.add') }}</button>

        @endif

    </form>
@endsection
