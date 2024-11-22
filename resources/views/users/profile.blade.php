@extends('users.layout')
@section('title', 'Profile')
@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2>Profile</h2>
      <form>
        @if(session('id') || Cookie::has('user_login'))
        <div class="form-group">
          <label for="username">Username:</label>
          <input type="text" class="form-control" id="username" value="{{session('name')}}" readonly>
        </div>
        <div class="form-group">
          <label for="password">Password:</label>
          <input type="password" class="form-control" id="password" value="{{$user->password}}" readonly>
        </div>
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" class="form-control" id="email" value="{{$user->email}}" readonly>
        </div>
        <div class="form-group">
          <label for="address">Address:</label>
          <input type="text" class="form-control" id="address" value="{{$user->address}}" readonly>
        </div>
        <div class="form-group">
          <label for="phone">Phone Number:</label>
          <input type="text" class="form-control" id="phone" value="{{$user->phone_number}}" readonly>
        </div>
        @endif
      </form>
    </div>
  </div>
</div>
@endsection