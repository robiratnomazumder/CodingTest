@extends('layouts.master')
@section('title', 'Login')
@section('content')

    <div class="row" style="margin: 30px;">
        <div class="col-md-4">
            <h3 class="page-title text-center">Login Page</h3>
            <hr>
            @if(Session('success'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <strong>{{ Session('success') }} {{ Session::forget('success') }}</strong>
                </div>
            @elseif(Session('error'))
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <strong>{{ Session('error') }} {{ Session::forget('error') }}</strong>
                </div>
            @endif

            <form action="{{route('login_verify')}}" method="post">
                @csrf
                <div class="form-group">
                    <label> User Type </label>
                    <select name="type" class="form-control" required>
                        <option value="">Select User Type</option>
                        <option value="admin">Admin</option>
                        <option value="agent">Agent</option>
                        <option value="user">User</option>
                    </select>
                </div>
                <div class="form-group">
                    <label> Email </label>
                    <input type="email" name="email" class="form-control" placeholder="Email">
                </div>
                <div class="form-group">
                    <label> Password </label>
                    <input type="password" name="password" class="form-control" placeholder="Password">
                </div>
                <p class="text-danger">Email verification is mandatory for login!</p>
                <div class="mt-3">
                    <button type="submit" class="btn btn-block btn-primary">Log In</button>
                </div>
            </form>
            <br>
            <p class="text-primary">For registration, use this link button below.</p>
            <a href="{{route('register')}}" class="btn btn-info btn-block">Registration Link</a>

            <br>
            <h5>
                <ul>
                    <li>Please change "MAIL_USERNAME" and "MAIL_PASSWORD" for email verify.</li>
                    <li>After registration, check email & click link for verify & login.</li>
                </ul>
            </h5>
        </div>
    </div>

@endsection
