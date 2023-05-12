@extends('layouts/contentNavbarLayout')

@section('title', 'Data Berita Acara')

@section('content')

    {{-- <div class="container"> --}}
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('td') }}" class="text-reset fw-bold">
                Rekap Berita Acara/</a></span>Input Rekap Berita Acara</h4>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    {{-- <h5 class="mb-0">Basic Layout</h5> <small class="text-muted float-end">Default label</small> --}}
                </div>
                <div class="card-body">
                    <form action="{{ route('up.rba', $rekapba->id) }}" method="POST" class="form-item" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">No Berita Acara</label>
                            <div class="col-sm-10">
                                <select name="id_ba" class="form-control">
                                    <option value="" disabled selected>--Pilih Berita Acara--</option>
                                    @foreach ($beritaacara as $ba)
                                        <option value="{{ $ba->id }}" {{$rekapba->id_ba == $ba->id ? 'selected' : '' }}>Nama Tim : {{ $ba->teamdetail->teamlist->list_tim }},  No BA : {{ $ba->no_ba }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Nama Tim</label>
                            <div class="col-sm-10">
                                <select name="id_tiket" class="form-control">
                                    <option value="" disabled selected>--Pilih Tiket--</option>
                                    @foreach ($tikettim as $tik)
                                        <option value="{{ $tik->id }}" {{$rekapba->id_tiket == $tik->id ? 'selected' : '' }}>Tiket : {{ $tik->tiketlist->no_tiket }},  Jenis Tiket : {{ $tik->tiketlist->jenistiket->nama_tiket }}, Tim : {{ $tik->teamdetail->teamlist->list_tim }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-sm-10 gap-3 d-flex">
                                <button type="submit" class="btn btn-info" name="simpan">Simpan</button>
                                <a href="{{ route('rba') }}" class="btn btn-outline-danger ">Batal</a>
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