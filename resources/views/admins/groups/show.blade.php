@extends('layouts.adminApp')

@section('content')

    @if (isset($lang_diff))
        @foreach ($lang_diff as $i => $lang)
            <form action="{{ route('groups.add_lang', $group->id) }}" method="POST">
                @csrf
                <div class="card text-white bg-dark mb-3" style="max-width: 34rem;margin-top: 20px">
                    <div class="card-header">{{ __('titles.add group') }} ({{ __('titles.' . $lang) }})</div>
                    <div class="card-body">

                        <div class="form-group">
                            <label for="exampleInputEmail1">
                                {{ __('titles.name') }} ({{ __('titles.' . $lang) }})
                            </label>
                            <input type="text" name="group[0][name]" class="form-control"
                                aria-describedby="emailHelp">
                            @error("group.0.name")
                                <small style="color: red">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">
                                {{ __('titles.description') }} ({{ __('titles.' . $lang) }})
                            </label>
                            <textarea type="text" name="group[0][description]"
                                class="form-control"></textarea>
                            @error("group.0.description")
                                <small style="color: red">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <input type="hidden" value="{{$lang}}" name="abbr">
                        <input type="hidden" value="1" name="photo_id">

                        <button type="submit" class="btn btn-primary"
                    style="margin-top: 10px;margin-bottom: 10px">{{ __('titles.add') }}</button>
                    </div>
                    
                </div>
                
            </form>
        @endforeach



    @endif


@endsection
