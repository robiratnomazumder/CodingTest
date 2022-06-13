@extends('layouts.master')
@section('title', 'Registration')
@section('content')

    <div class="row" style="margin: 30px;">
        <div class="col-md-4">
            <h3 class="page-title text-center">Registration Page</h3>
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

            <form action="{{route('registration_submit')}}" method="post">
                @csrf
                <div class="form-group">
                    <label> User Type </label>
                    <select name="type" class="form-control" required>
                        <option value="" selected>Select User Type</option>
                        <option value="admin" {{old('type') == 'admin' ? 'selected':''}}>Admin</option>
                        <option value="agent" {{old('type') == 'agent' ? 'selected':''}}>Agent</option>
                        <option value="user" {{old('type') == 'user' ? 'selected':''}}>User</option>
                    </select>
                </div>
                <div class="form-group">
                    <label> Name </label>
                    <input type="text" name="name" class="form-control" value="{{old('name')}}" placeholder="name" required>
                </div>
                <div class="form-group">
                    <label> Email </label>
                    <input type="email" name="email" class="form-control" value="{{old('email')}}" placeholder="email" required>
                </div>
                <div class="form-group">
                    <label> Password </label>
                    <input type="password" name="password" class="form-control" placeholder="password" required>
                </div>
                <div class="form-group">
                    <label> Confirm Password </label>
                    <input type="password" name="confirm_password" class="form-control" placeholder="confirm password" required>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-block btn-primary">Submit</button>
                </div>
            </form>
            <br>
            <p>For registration, use this link button below.</p>
            <a href="{{route('login')}}" class="btn btn-info btn-block">Login Link</a>
        </div>
    </div>

@endsection
