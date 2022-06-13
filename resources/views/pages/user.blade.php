@extends('layouts.master')
@section('title', 'User List')
@section('content')

    <div class="row" style="margin: 30px;">
        <div class="col-md-4">
            <h3 class="page-title text-center">User Page
                <form action="{{url('logout')}}" method="post">
                    @csrf
                    <input type="hidden" name="type" value="{{Session::get('userSessionData')}}">
                    <button type="submit" class="btn btn-warning btn-sm">Logout</button>
                </form>
            </h3>
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
            <form method="get" class="form-inline">
                <input type="text" name="search" class="form-control" placeholder="search here..." required>
                <button type="submit" class="btn btn-primary btn-sm">Search</button>
            </form>
            <hr>
            <table class="table table-striped">
                <thead>
                    <th>SL</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Option</th>
                </thead>
                <tbody>
                    @if($lists->isEmpty())
                        <tr>
                            <td colspan="4" class="text-center"> No result found! </td>
                        </tr>
                    @endif
                    @foreach($lists as $key => $list)
                    <tr>
                        <td>{{++$key}}</td>
                        <td>{{$list->user_id}}</td>
                        <td>{{$list->name}}</td>
                        <td>
                            <a href="{{route('user.delete', $list->id)}}" onclick="return confirm('Are you sure want to delete?')" class="btn btn-danger btn-sm"> Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

