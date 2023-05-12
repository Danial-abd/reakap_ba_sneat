@extends('layouts/blankLayout')

@section('title', 'Edit User')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection


@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner">

      <!-- Register Card -->
      <div class="card">
        <div class="card-body">
          <!-- Logo -->
          <div class="app-brand justify-content-center">
            <a href="{{url('/')}}" class="app-brand-link gap-2">
              <span class="app-brand-logo demo">@include('_partials.macros',["width"=>25,"withbg"=>'#696cff'])</span>
              <span class="app-brand-text demo text-body fw-bolder">{{config('variables.templateName')}}</span>
            </a>
          </div>
          <!-- /Logo -->
          <h4 class="mb-2">Edit User</h4>
          <p class="mb-4">====================</p>

          <form id="formAuthentication" class="mb-3" action="{{route('up.usr', $user->id)}}" method="POST">
            @csrf
            {{-- <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" autofocus>
            </div> --}}

            {{-- Role --}}
            <div class="mb-3">
              <label class="form-label">Pilih Role</label>
              <select name="role" class="form-control">
                <option value="" disabled selected>--Pilih Role--</option>
                @foreach ($jobdesk as $job)
                    <option value="{{ $job->id }}" {{$user->role == $job->id ? 'selected' : '' }}>{{ $job->jobdesk }} {{ $job->detail_kerja }}</option>
                @endforeach
            </select>
            </div>
            {{-- /Role --}}

            {{-- karyawan --}}
            <div class="mb-3">
              <label class="form-label" >Nama Karyawan</label>
              <select name="id_karyawan" id="id_team" class="form-control">
                <option value="" disabled selected>--Pilih Nama Tim--</option>
                @foreach ($karyawan as $kyw)
                    <option value="{{ $kyw->id }}" {{$user->id_karyawan == $kyw->id ? 'selected' : '' }}>{{ $kyw->nama }}</option>
                @endforeach
            </select>
            </div>
            {{-- /karyawan --}}
            
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="text" class="form-control" id="email" name="email" value="{{ $user->email }}" placeholder="Enter your email">
            </div>

            <div class="mb-3 form-password-toggle">
              <label class="form-label" for="password">Isi Password Baru</label>
              <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>

            {{-- Tim --}}
            <div class="mb-3">
              <label class="form-label">Nama Tim</label>
              <select name="role_t" id="id_team" class="form-control">
                <option value="" disabled selected>--Pilih Nama Tim--</option>
                @foreach ($teamdetail as $td)
                    <option value="{{ $td->id }}" {{$user->role_t == $td->id ? 'selected' : '' }}>{{ $td->teamlist->list_tim }} , {{ $td->karyawan->nama }}, {{ $td->jobdesk->jobdesk }} {{ $td->jobdesk->detail_kerja }}</option>
                @endforeach
            </select> 
            </div>
            {{-- /Tim --}}

            <button class="btn btn-primary d-grid w-100">
              Sign up
            </button>
          </form>
        </div>
      </div>
    </div>
    <!-- Register Card -->
  </div>
</div>
</div>
@endsection
