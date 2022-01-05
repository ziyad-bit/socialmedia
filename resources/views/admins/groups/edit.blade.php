@extends('layouts.adminApp')

@section('content')

    @if (Session::has('success'))
        <div class="alert alert-success text-center">{{ Session::get('success') }}</div>
    @endif

    @if (Session::has('error'))
        <div class="alert alert-danger text-center">{{ Session::get('error') }}</div>
    @endif

    <div class="card text-white bg-dark mb-3" style="max-width: 34rem;">
        <div class="card-header">{{ __('titles.edit group') }}({{ __('titles.' . $group->trans_of) }})</div>
        <div class="card-body">
            <form method="POST" action="{{ route('groups.update',$group->id) }}">
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

                <div class="form-group" style="width: 50%">
                    <label for="exampleInputPassword1">status</label>
                    <select name="status" class="form-select">
                        <option value="1" {{ $group->status == 1 ? 'selected' : null }}> closed </option>
                        <option value="0" {{ $group->status == 0 ? 'selected' : null }}> open </option>
                    </select>
                    @error('status')
                        <small style="color: red">
                            {{ $message }}
                        </small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">{{ __('titles.name') }}
                        ({{ __('titles.' . $group->trans_of) }})</label>
                    <input type="text" name="name" value="{{ $group->name }}" class="form-control"
                        aria-describedby="emailHelp">
                    @error('group.0.name')
                        <small style="color: red">
                            {{ $message }}
                        </small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword1">{{ __('titles.description') }}
                        ({{ __('titles.' . $group->trans_of) }})</label>
                    <textarea type="text" name="description"
                        class="form-control"> {{ $group->description }} </textarea>
                    @error('group.0.description')
                        <small style="color: red">
                            {{ $message }}
                        </small>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">{{ __('titles.edit') }}</button>
            </form>
        </div>
    </div>


    @if (isset($group->groups))
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            @foreach ($group->groups as $i => $other_group)
                <li class="nav-item" role="presentation">
                    <a class="nav-link " id="profile-tab{{$i}}" data-toggle="tab"
                        href="#profile{{$i}}" role="tab" aria-controls="{{ $i }}"
                        aria-selected="false">
                        edit group({{ __('titles.' . $other_group->trans_lang) }})</a>
                </li>
            @endforeach
        </ul>
    @endif
    @if (isset($group->groups))
        <div class="tab-content" id="myTabContent">
            @foreach ($group->groups as $i => $other_group)

                <div class="tab-pane fade " id="profile{{$i}}" role="tabpanel"
                    aria-labelledby="{{ $i }}">
                    <div class="card text-white bg-dark mb-3" style="max-width: 34rem;">

                        <div class="card-body">
                            <form method="POST" action="{{ route('groups.update',$other_group->id) }}">
                                @csrf

                                <div class="form-group">
                                    <label for="exampleInputEmail1">name
                                        ({{ __('titles.' . $other_group->trans_of) }})</label>
                                    <input type="text" name="name" value="{{ $other_group->name }}" class="form-control"
                                        aria-describedby="emailHelp">
                                    @error('group.0.name')
                                        <small style="color: red">
                                            {{ $message }}
                                        </small>
                                    @enderror

                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">description
                                        ({{ __('titles.' . $other_group->trans_of) }})</label>
                                    <textarea type="text" name="description"
                                        class="form-control"> {{ $other_group->description }} </textarea>
                                    @error('group.0.description')
                                        <small style="color: red">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
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
                
                                <div class="form-group" style="width: 50%">
                                    <label for="exampleInputPassword1">status</label>
                                    <select name="status" class="form-select">
                                        <option value="1" {{ $other_group->status == 1 ? 'selected' : null }}> closed </option>
                                        <option value="0" {{ $other_group->status == 0 ? 'selected' : null }}> open </option>
                                    </select>
                                    @error('status')
                                        <small style="color: red">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>

                        </div>
                    </div>
                </div>

            @endforeach
        </div>
    @endif
@endsection