@extends('layouts/contentNavbarLayout')

@section('title', 'Rekap Tiket Tim')

@section('content')

    {{-- <div class="container"> --}}
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('tiket') }}" class="text-reset fw-bold">
                Rekap Tiket/</a></span> Tambah Rekap Data</h4>
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
                    <form action="{{ route('spn.tiket') }}" method="POST" class="form-item">
                        @csrf
                        @if (auth()->user()->jobdesk->jobdesk == 'Teknisi')
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-default-name">Nama Tim</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" readonly
                                        value="{{ auth()->user()->teamdetail->teamlist->list_tim }} {{ auth()->user()->teamdetail->karyawan->nama }}"
                                        id="basic-default-name" placeholder="Masukkan Kode Jobdesk">
                                    <input type="hidden" class="form-control" name='id_teknisi'
                                        value="{{ auth()->user()->role_t }}" id="basic-default-name"
                                        placeholder="Masukkan Kode Jobdesk">
                                </div>
                            </div>
                        @else
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-default-name">Nama Tim</label>
                                <div class="col-sm-10">
                                    <select name="id_teknisi" id="id_team" class="form-control">
                                        <option value="" disabled selected>--Pilih Nama Tim--</option>
                                        @foreach ($teamdetail as $td)
                                            <option value="{{ $td->id }}">{{ $td->teamlist->list_tim }} ,
                                                {{ $td->karyawan->nama }}, {{ $td->jobdesk->jobdesk }}
                                                {{ $td->jobdesk->detail_kerja }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">No Tiket</label>
                            <div class="col-sm-10">
                                <select name="id_tiket" id="id_team" class="form-control">
                                    <option value="" disabled selected>--Pilih Tiket--</option>
                                    @foreach ($tiketlist as $tl)
                                        <option value="{{ $tl->id }}">{{ $tl->no_tiket }},
                                            {{ $tl->jenistiket->nama_tiket }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-sm-10 gap-3 d-flex">
                                <button type="submit" class="btn btn-info" name="simpan">Simpan</button>
                                <a href="{{ route('tiket') }}" class="btn btn-outline-danger ">Batal</a>
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
