@extends('layouts/contentNavbarLayout')

@section('title', 'Data Tiket ' . $tiketlist->jenistiket->nama_tiket . '')

@section('content')

    {{-- <div class="container"> --}}
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="" class="text-reset fw-bold">
                Tiket {{ $tiketlist->jenistiket->nama_tiket }}/</a></span> Tambah Data Tiket
        {{ $tiketlist->jenistiket->nama_tiket }}</h4>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    {{-- <h5 class="mb-0">Basic Layout</h5> <small class="text-muted float-end">Default label</small> --}}
                </div>
                <div class="card-body">
                    <form action="{{ route('spn.psb') }}" method="POST" class="form-item">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Jenis Tiket</label>
                            <div class="col-sm-10">
                                <select name="id_j_tiket" readonly id="id_j_tiket" readonly class="form-control">
                                    @foreach ($jenistiket as $jt)
                                        <option value="{{ $jt->id }}" {{$tiketlist->id_j_tiket == $jt->id ? 'selected' : '' }}>{{$jt->nama_tiket}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">No Tiket</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name='no_tiket' id="basic-default-name"
                                    placeholder="Masukkan No Tiket">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name='nama_pic' id="basic-default-name"
                                    placeholder="Masukkan Nama Pelanggan">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">No Handphone</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name='no_pic' id="basic-default-name"
                                    placeholder="Masukkan No Handphone">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Alamat</label>
                            <div class="col-sm-10">
                                <textarea name="alamat" id="alamat" class="form-control" cols="2" rows="3" placeholder="Masukkan Alamat"
                                    style="resize : none"></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Ket</label>
                            <div class="col-sm-10">
                                <textarea name="ket" id="alamat" class="form-control" cols="2" rows="3" placeholder="Masukkan Keterangan Tiket"
                                    style="resize : none"></textarea>
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
    {{-- </div> --}}
@endsection
