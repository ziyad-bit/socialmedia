@extends('layouts.adminLogin')
@section('content')
    @if (Session::has('error'))
        <div class="alert alert-danger text-center">{{ Session::get('error') }}</div> 
    @endif
    
    <div class="card text-white bg-dark mb-3" style="max-width: 26rem;margin:auto;margin-top: 150px">
        <div class="card-header">admin login</div>
        <div class="card-body">
            <form action="{{route('admins.post.login')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                </div>
                
                <div class="form-check">
                    <input class="form-check-input" name="remember_me" type="checkbox"  id="flexCheckChecked" >
                    <label class="form-check-label" for="flexCheckChecked">
                        remember me
                    </label>
                </div>

                <button type="submit" class="btn btn-success" style="margin-top: 10px">login</button>
            </form>
        </div>

        <a class="btn btn-link" href="{{ route('admins.get.resetPasswordLink') }}">
            {{ __('Forgot Your Password?') }}
        </a>
    </div>
@endsection
