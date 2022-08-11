@extends('layouts.master') 
<!--extends untuk memanggil dari folder layouts.master -->
@section('title')
    Profile
@endsection
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active"> Profile</li>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-4">
      <img src="{{ $user->foto }}" alt="Foto User" class="d-block mx-auto img-fluid" width="150px">
    </div>
    <div class="col-md-8">
      <div class="card">
        <div class="card-body">
          <form action="" method="POST" enctype="multipart/form-data">
            @csrf

            <x-input-group label="Nama" name="name" value="{{ $user->name }}"></x-input-group>
            <x-input-group type="password" label="Password" name="password" placeholder="Kosongkan jika tidak mengganti password"></x-input-group>
            <x-input-group type="file" label="Foto" name="foto"></x-input-group>

            <button class="btn btn-success btn-sm">Update</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
