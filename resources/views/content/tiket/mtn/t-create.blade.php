@extends('layouts/contentNavbarLayout')

@section('title', 'Data Tiket Maintenance')

@section('content')

    {{-- <div class="container"> --}}
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="" class="text-reset fw-bold">
                Tiket Maintenance/</a></span> Tambah Data Tiket
    </h4>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if (Session::has('error'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    {{-- <h5 class="mb-0">Basic Layout</h5> <small class="text-muted float-end">Default label</small> --}}
                </div>
                <div class="card-body">
                    <form action="{{ route('spn.mtn') }}" method="POST" class="form-item">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Jenis Tiket</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" readonly name='' value="{{ $jenistiket->nama_tiket }}" id="basic-default-name"
                                    placeholder="Masukkan Kode Jobdesk">
                                <input type="hidden" class="form-control" readonly name='id_j_tiket' value="{{ $jenistiket->id }}" id="basic-default-name"
                                    placeholder="Masukkan Kode Jobdesk">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">No Tiket</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('no_tiket') is-invalid @enderror"
                                    name='no_tiket' id="basic-default-name" placeholder="Masukkan No Tiket">
                                @error('no_tiket')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('nama_pic') is-invalid @enderror"
                                    name='nama_pic' id="basic-default-name" placeholder="Masukkan Nama Pelanggan">
                                @error('nama_pic')
                                    <div class="invalid-feedback">
                                        The Nama Pelanggan field is required
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">No Handphone</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control @error('no_pic') is-invalid @enderror"
                                    name='no_pic' id="basic-default-name" placeholder="Masukkan No Handphone">
                                @error('no_pic')
                                    <div class="invalid-feedback">
                                        The No Handphone Pelanggan field is required
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Alamat</label>
                            <div class="col-sm-10">
                                <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" cols="2"
                                    rows="3" placeholder="Masukkan Alamat" style="resize : none"></textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">
                                        The Alamat field is required
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Ket</label>
                            <div class="col-sm-10">
                                <textarea name="ket" id="alamat" class="form-control" cols="2" rows="3"
                                    placeholder="Masukkan Keterangan Tiket" style="resize : none"></textarea>
                            </div>
                        </div>

                        <div class="row justify-content-end">
                            <div class="col-sm-10 gap-3 d-flex">
                                <button type="submit" class="btn btn-info" name="simpan">Simpan</button>
                                <a href="{{ route('mtn') }}" class="btn btn-outline-danger ">Batal</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- </div> --}}
@endsection
