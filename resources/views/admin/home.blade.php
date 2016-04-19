@extends('admin.layouts.master')

@section('title')
    Admin | Home
@endsection

@section('admin_content')
@include('includes.message-block')

<div class="table-responsive">
  <table class="table table-bordered">
    <thead>
        <th>Name</th>
        <th>Email</th>
        <th>User Status </th>
        <th>User Type </th>
        <th>Joined Date</th>
        <th>Action</th>
    </thead>
    <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->first_name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                <?php if($user->user_status == 0) {
                    echo 'Active';
                }elseif($user->user_status == 1)
                {
                    echo 'Inactive';
                }
                ?>
                </td>
                <td>
                <?php if($user->user_type == 0) {
                    echo 'User';
                }elseif($user->user_type == 1)
                {
                    echo 'Admin';
                }
                ?>
                </td>
                <td>{{ $user->created_at }}</td>
                <td>
                <?php
                if($user->user_status == 1)
                {
                ?>
                    <a class="btn btn-default" href="{{ route('user.inactive', ['user_id' => $user->id]) }}" title="Active" role="button">Active</a>
                 <?php
                }
                if($user->user_status == 0)
                {
                ?>
                    <a class="btn btn-default" href="{{ route('user.active', ['user_id' => $user->id]) }}" title="Inactive" role="button">Inactive</a>
                <?php
                }
                ?>
                    <a class="btn btn-default" href="{{ route('user.delete', ['user_id' => $user->id]) }}" title="Delete User" role="button">Delete</a>
                    <a class="btn btn-default" href="{{ route('user-profile', ['user_id' => $user->id]) }}" title="View Posts" role="button">View Profile</a>
                </td>
            </tr>
        @endforeach
    </tbody>
  </table>
  <div class="pagination">
  {!! $users->render() !!}
  </div>
</div>
@endsection