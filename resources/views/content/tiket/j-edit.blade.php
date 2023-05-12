@extends('layouts/contentNavbarLayout')

@section('title', 'Data Jobdesk')

@section('content')

    {{-- <div class="container"> --}}
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('jt') }}" class="text-reset fw-bold">
                Tiket Pekerjaan/</a></span> Edit Data Tiket Pekerjaan</h4>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    {{-- <h5 class="mb-0">Basic Layout</h5> <small class="text-muted float-end">Default label</small> --}}
                </div>
                <div class="card-body">
                    <form action="{{ route('up.jt', $jenistiket->id) }}" method="POST" class="form-item">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Nama Tiket</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name='nama_tiket' value='{{ $jenistiket->nama_tiket }}' id="basic-default-name"
                                    placeholder="Masukkan Nama Tiket">
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-sm-10 gap-3 d-flex">
                                <button type="submit" class="btn btn-info" name="simpan">Simpan</button>
                                <a href="{{ route('jt') }}" class="btn btn-outline-danger ">Batal</a>
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
