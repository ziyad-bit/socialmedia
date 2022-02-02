@extends('layouts.app')

@section('header')
    <link rel="stylesheet" href="{{asset('css/users/chat/index.css')}}">
@endsection

@section('content')
    <div class="container">
        <div class="row" style="margin-top: 50px">

            <div class="col-4 ">
            <input type="hidden" value="{{Auth::user()->name}}" id="auth">
            <input type="hidden" value="{{Auth::id()}}" id="auth_id">
                <div class="list-group nav-pills " data-status="1" id="list-tab" role="tablist" >
                    @if ($friends_user->count() > 0)
                        @foreach ($friends_user as $i => $user)
                            
                            <button class="user_btn nav-link list-group-item list-group-item-action {{ $i == 0 ? 'active index_0' : null }}"
                                id="list-home-list" data-bs-toggle="pill" data-bs-target={{'#chat_box'.$user->id}} role="tab"
                                data-id="{{ $user->id }}" aria-controls="home" 
                                data-index="{{ $i }}" data-status="0" >{{ $user->name }} 

                                <img class="rounded-circle image" src="{{asset('images/users/'.$user->photo)}}" alt="loading">
                            </button>

                        @endforeach
                    @endif
                </div>
            </div>


            <div class="col-8">
                <div class="tab-content" id="nav-tabContent">
                    @if ($friends_user->count() > 0)
                        @foreach ($friends_user as $i => $user)

                            <div class="tab-pane fade  {{ $i == 0 ? 'show active' : null }}" id={{'chat_box'.$user->id}}
                                role="tabpanel" aria-labelledby="list-home-list">
                                <form id={{ 'form' . $user->id }}>
                                    
                                    <div class="card" style="height: 300px">
                                        <h5 class="card-header">chat<span id="loading{{ $user->id }}"
                                                style="margin-left: 50px;display:none">loading old messages</span>
                                        </h5>

                                        <div class="card-body " id="box{{ $user->id }}" data-user_id="{{$user->id}}" data-old_msg='1'>
                                            
                                        </div>
                                        <input type="hidden" name="receiver_id" class="receiver_id"
                                            value="{{ $user->id }}">
                                        <input type="text" name="message" id="msg{{ $user->id }}" class="form-control"
                                            data-id="{{ $user->id }}">
                                        
                                        <button type="button" class="btn btn-success send_btn"
                                            data-receiver_id="{{ $user->id }}">Send</button>
                                    </div>
                                </form>
                            </div>

                        @endforeach
                    @endif

                </div>

            </div>
        </div>

    </div>
@endsection

@section('script')
<script src="{{ asset('js/users/chat/index.js') }}"></script>
@endsection