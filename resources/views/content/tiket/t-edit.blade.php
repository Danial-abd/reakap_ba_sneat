@extends('layouts/contentNavbarLayout')

@section('title', 'Data Tiket '.$tiketlist->jenistiket->nama_tiket.'')

@section('content')

    {{-- <div class="container"> --}}
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="
        @if ($tiketlist->jenistiket->nama_tiket == "Pasang Baru")
            {{ route("psb") }}
        @elseif ($tiketlist->jenistiket->nama_tiket == "Gangguan")
            {{ route("ggn") }}
        @elseif ($tiketlist->jenistiket->nama_tiket == "Maintenance")
            {{ route("mtn") }}
        @endif
        " class="text-reset fw-bold">
        Tiket {{ $tiketlist->jenistiket->nama_tiket }}/</a></span> Edit Data Tiket {{ $tiketlist->jenistiket->nama_tiket }}</h4>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    {{-- <h5 class="mb-0">Basic Layout</h5> <small class="text-muted float-end">Default label</small> --}}
                </div>
                <div class="card-body">
                    <form action="{{ route('up.ggn', $tiketlist->id) }}" method="POST" class="form-item">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Jenis Tiket</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" readonly name=''
                                    value="{{ $tiketlist->jenistiket->nama_tiket }}" id="basic-default-name"
                                    placeholder="Masukkan Kode Jobdesk">
                                    <input type="hidden" class="form-control" readonly name='id_j_tiket'
                                    value="{{ $tiketlist->id_j_tiket }}" id="basic-default-name"
                                    placeholder="Masukkan Kode Jobdesk">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">No Tiket</label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ $tiketlist->no_tiket }}" class="form-control" name='no_tket' id="basic-default-name"
                                    placeholder="Masukkan NIK Karyawan">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ $tiketlist->nama_pic }}" class="form-control" name='nama_pic' id="basic-default-name"
                                    placeholder="Masukkan Nama Karyawan">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">No Handphone</label>
                            <div class="col-sm-10">
                                <input type="number" value="{{ $tiketlist->no_pic }}" class="form-control" name='no_pic' id="basic-default-name"
                                    placeholder="Masukkan No Handphone">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Alamat</label>
                            <div class="col-sm-10">
                                <textarea name="alamat" id="alamat" class="form-control" cols="2" rows="3" placeholder="Masukkan Alamat"
                                    style="resize : none">{{ $tiketlist->alamat }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Ket</label>
                            <div class="col-sm-10">
                                <textarea name="ket" id="alamat" class="form-control" cols="2" rows="3" placeholder="Masukkan Keterangan"
                                    style="resize : none">{{ $tiketlist->ket }}</textarea>
                            </div>
                        </div>

                        <div class="row justify-content-end">
                            <div class="col-sm-10 gap-3 d-flex">
                                <button type="submit" class="btn btn-info" name="simpan">Simpan</button>
                                <a href="" class="btn btn-outline-danger ">Batal</a>
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