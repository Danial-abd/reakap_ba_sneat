@extends('layouts/contentNavbarLayout')

@section('title', 'Data Karyawan')

@section('content')

    {{-- <div class="container"> --}}
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('kyw') }}" class="text-reset fw-bold">
                Data Karyawan/</a></span> Edit Data Karyawan</h4>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    {{-- <h5 class="mb-0">Basic Layout</h5> <small class="text-muted float-end">Default label</small> --}}
                </div>
                <div class="card-body">
                    <form action="{{ route('up.kyw', $karyawan->id) }}" method="POST" class="form-item">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">NIK</label>
                            <div class="col-sm-10">
                                <input type="number" value="{{ $karyawan->nik }}" readonly class="form-control" name='nik' id="basic-default-name"
                                    placeholder="Masukkan NIK Karyawan">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ $karyawan->nama }}" class="form-control" name='nama' id="basic-default-name"
                                    placeholder="Masukkan Nama Karyawan">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">No Handphone</label>
                            <div class="col-sm-10">
                                <input type="number" value="{{ $karyawan->telepon }}" class="form-control" name='telepon' id="basic-default-name"
                                    placeholder="Masukkan No Handphone">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Tanggal Lahir</label>
                            <div class="col-sm-10">
                                <input type="date" value="{{ $karyawan->ttl }}" class="form-control" name='ttl' id="basic-default-name"
                                    placeholder="Masukkan Tanggal Lahir">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Tanggal Lahir</label>
                            <div class="col-sm-10">
                                <select name="jns_klmin" class="form-control">
                                    <option value="" disabled selected>--Pilih Jenis Kelamin--</option>
                                    <option value="L" {{$karyawan->jns_klmin == 'L' ? 'selected' : ''}}>Laki-laki</option>
                                    <option value="P" {{$karyawan->jns_klmin == 'P' ? 'selected' : ''}}>Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Alamat</label>
                            <div class="col-sm-10">
                                <textarea name="alamat" id="alamat" class="form-control" cols="2" rows="3" placeholder="Masukkan Alamat"
                                    style="resize : none">{{ $karyawan->alamat }}</textarea>
                            </div>
                        </div>

                        <div class="row justify-content-end">
                            <div class="col-sm-10 gap-3 d-flex">
                                <button type="submit" class="btn btn-info" name="simpan">Simpan</button>
                                <a href="{{ route('kyw') }}" class="btn btn-outline-danger ">Batal</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    {{-- </div> --}}
@endsection