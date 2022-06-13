@extends('layouts.master')
@section('title', 'Admin List')
@section('content')

    <div class="row" style="margin: 30px;">
        <div class="col-md-6">
            <h3 class="page-title text-center">Admin Page
                <form action="{{url('logout')}}" method="post">
                    @csrf
                    <input type="hidden" name="type" value="{{Session::get('adminSessionData')}}">
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
            <div class="row">
                <div class="col-md-6">
                    <p class="text-primary">Search with user type</p>
                    <form method="get" class="form-inline">
                        <select name="type" class="form-control" required>
                            <option value="">Select User Type</option>
                            <option value="admin">Admin</option>
                            <option value="agent">Agent</option>
                            <option value="user">User</option>
                        </select>
                        <button type="submit" class="btn btn-primary btn-sm">Search</button>
                    </form>
                </div>
                <div class="col-md-6">
                    <p class="text-primary">Search with name or id</p>
                    <form method="get" class="form-inline">
                        <input type="hidden" name="type" value="{{$type_temp}}">
                        <input type="text" name="search" class="form-control" placeholder="search here..." required>
                        <button type="submit" class="btn btn-primary btn-sm">Search</button>
                    </form>
                </div>
            </div>
            <br>
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
                            <a href="{{route('admin.delete', $list->id)}}" onclick="return confirm('Are you sure want to delete?')" class="btn btn-danger btn-sm"> Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <div class="text-center">
                <p class="text-danger">Search with name or id <strong>(Store data)</strong></p>
                <form method="get" class="form-inline">
                    <input type="text" name="store" class="form-control" placeholder="search admin id or name..." required>
                    <button type="submit" class="btn btn-danger btn-sm">Search</button>
                </form>
            </div>
            <hr>
            <span class="text-success">Session stored data</span>
            <table class="table table-striped">
                <thead>
                    <th>SL</th>
                    <th>ID</th>
                    <th>Name</th>
                </thead>
                <tbody>
                @if(!$jsonLists)
                    <tr>
                        <td colspan="4" class="text-center"> Empty Data! </td>
                    </tr>
                @else
                    @foreach($jsonLists as $key_ => $Jlist)
                        <tr>
                            <td>{{++$key_}}</td>
                            <td>{{$Jlist['user_id']}}</td>
                            <td>{{$Jlist['name']}}</td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>

@endsection

