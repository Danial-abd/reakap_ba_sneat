@extends('layouts/blankLayout')

@section('title', 'Login Pages')

@section('page-style')
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">
@endsection

@section('content')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Register -->
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
                        <h4 class="mb-2 text-center">Welcome to {{ config('variables.templateName') }}! 👋</h4>
                        <p class="mb-4 text-center">Silahkan Login, untuk mengumpulkan berkas</p>

                        @if (Session::has('loginError'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('loginError') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form class="mb-3" action="{{ route('log-in') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">NIK</label>
                                <input type="text" class="form-control" name="id_karyawan"
                                    placeholder="Masukkan NIK Anda" autofocus>
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Password</label>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                            </div>
                        </form>

                        <p class="text-center">
                            <span>Belum Punya Akun? Silahkan Hubungi Admin</span>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            <!-- /Register -->
        </div>
    </div>
    </div>
@endsection
