@extends('layouts/contentNavbarLayout')

@section('title', 'Data Berita Acara')

@section('content')

    {{-- <div class="container"> --}}
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('ba') }}" class="text-reset fw-bold">
                Daftar Berita Acara/</a></span> Input Data Berita Acara</h4>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    {{-- <h5 class="mb-0">Basic Layout</h5> <small class="text-muted float-end">Default label</small> --}}
                </div>
                <div class="card-body">
                    <form action="{{ route('up.ba', $beritaacara->id) }}" method="POST" class="form-item" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">No Berita Acara</label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ $beritaacara->no_ba }}" class="form-control" name='no_ba' id="basic-default-name"
                                    placeholder="Masukkan Nama Tim">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Nama Tim</label>
                            <div class="col-sm-10">
                                <select name="id_tim" class="form-control">
                                    <option value="" disabled selected>--Pilih Nama Tim--</option>
                                    @foreach ($teamdetail as $td)
                                        <option value="{{ $td->id }}" {{$beritaacara->id_tim == $td->id ? 'selected' : '' }}>{{ $td->teamlist->list_tim }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Upload File</label>
                            <div class="col-sm-10">
                                <input class="form-control" value="{{ $beritaacara->no_ba }}" name="file_ba" type="file" id="formFile">
                                <label class="col-sm-6 col-form-label" for="basic-default-name">File yang sudah diupload = {{ $beritaacara->no_ba }} .pdf</label>
                            </div>
                            
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-sm-10 gap-3 d-flex">
                                <button type="submit" class="btn btn-info" name="simpan">Simpan</button>
                                <a href="{{ route('ba') }}" class="btn btn-outline-danger ">Batal</a>
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
