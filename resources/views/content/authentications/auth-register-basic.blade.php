@extends('layouts/contentNavbarLayout')

@section('title', 'Register Basic - Pages')

@section('page-style')
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">
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
                            <img src="{{ asset('assets/img/favicon/logo.png') }}" style="width:110px;height:80px" />
                        </div>
                        <div class="app-brand justify-content-center">
                            <a href="{{ url('/') }}" class="app-brand-link ">
                                <span
                                    class="app-brand-text demo text-body fw-bolder">{{ config('variables.templateName') }}</span>
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-2">Daftar User</h4>
                        <p class="mb-4">====================</p>

                        <form id="formAuthentication" class="mb-3" action="{{ route('signin') }}" method="POST">
                            @csrf
                            {{-- <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" autofocus>
            </div> --}}

                            {{-- Role --}}
                            <div class="mb-3">
                                <label class="form-label">Pilih Role</label>
                                <select name="role" class="form-control @error('role') is-invalid @enderror">
                                    <option value="" disabled selected>--Pilih Role--</option>
                                    @foreach ($jobdesk as $job)
                                        <option value="{{ $job->id }}">{{ $job->jobdesk }} {{ $job->detail_kerja }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            {{-- /Role --}}

                            {{-- karyawan --}}
                            <div class="mb-3">
                                <label class="form-label">Nama Karyawan</label>
                                <select name="id_karyawan" id="id_team"
                                    class="form-control @error('id_karyawan') is-invalid @enderror">
                                    <option value="" disabled selected>--Pilih Nama Tim--</option>
                                    @foreach ($karyawan as $kyw)
                                        <option value="{{ $kyw->id }}">{{ $kyw->nik }} {{ $kyw->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_karyawan')
                                    <div class="invalid-feedback">
                                        The Nama Karyawan field is required
                                    </div>
                                @enderror
                            </div>
                            {{-- /karyawan --}}

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control  @error('email') is-invalid @enderror"
                                    id="email" name="email" placeholder="Enter your email">
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3 form-password-toggle">
                                <label class="form-label" for="password">Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Tim --}}
                            <div class="mb-3">
                                <label class="form-label">Nama Tim</label>
                                <select name="role_t" id="id_team" class="form-control">
                                    <option value="" disabled selected>--Pilih Nama Tim--</option>
                                    @foreach ($teamdetail as $td)
                                        <option value="{{ $td->id }}">{{ $td->teamlist->list_tim }} ,
                                            {{ $td->karyawan->nama }}, {{ $td->jobdesk->jobdesk }}
                                            {{ $td->jobdesk->detail_kerja }}</option>
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
