@extends('layouts.auth') 
<!-- Folder inti auth.blade -->
<!-- karna mengunakan auth juga -->
@section('login')
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
    <div class="login-logo">
    <a href="{{ url('/') }}">
        <img src="img/logoo.png" alt="logo.png" width="150">
</a>
    </div>
      <form action="{{ route('login') }}" method="post">
          <!-- @csrf adalah token supaya tidak kadaluarsa -->
          @csrf
          <!-- "{{ old('email') }}" di bagian bawah untuk memunculkan tetap pada login jikalau salah -->
        <div>
          <div class="input-group mb-3 @error('email') has-error @enderror">
          <input type="email" name="email" class="form-control" placeholder="Email" required value="{{ old('email') }}" autofocus>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
          </div>
          <p>
          <!-- untuk menambahkan message error -->
            @error('email')
             <span calss="help-block">{{ $message }}</span>
             @enderror
             </p> 
        </div>
        <div> 
        <div class="input-group mb-3 @error('password') has-error @enderror">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <!-- untuk menambahkan message error -->
        <p>
           @error('password')
             <span calss="help-block">{{ $message }}</span>
             @enderror
             </p> 
          </div>
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection