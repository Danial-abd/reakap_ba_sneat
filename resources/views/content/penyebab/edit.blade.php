@extends('layouts/contentNavbarLayout')

@section('title', 'Tambah Data Sektor')

@section('content')

    {{-- <div class="container"> --}}
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('pg') }}" class="text-reset fw-bold">
        Data Penyebab Gangguan/</a></span> Edit Data</h4>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    {{-- <h5 class="mb-0">Basic Layout</h5> <small class="text-muted float-end">Default label</small> --}}
                </div>
                <div class="card-body">
                    <form action="{{route('pg-up', $Ggnpenyebab->id)}}" method="POST"class="form-item">
                        @csrf

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Nama Penyebab</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="{{$Ggnpenyebab->penyebab}}" name='penyebab' id="basic-default-name"
                                    placeholder="Masukkan Penyebab Gangguan">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Nama Tim</label>
                            <div class="col-sm-10">
                                <select name="job" class="form-control  @error('job') is-invalid @enderror">
                                    <option value="" disabled selected>--Pilih Tiket--</option>
                                        <option value="GGN" {{ $Ggnpenyebab->job == 'GGN' ? 'selected' : ''}}>Gangguan</option>
                                        <option value="MTN" {{ $Ggnpenyebab->job == 'MTN' ? 'selected' : ''}}>Maintenance</option>
                                </select>
                                @error('job')
                                    <div class="invalid-feedback">
                                        Kolom Nama Tim harus di isi
                                    </div>
                                @enderror
                            </div>

                        </div>

                        <div class="row justify-content-end">
                            <div class="col-sm-10 gap-3 d-flex">
                                <button type="submit" class="btn btn-info" name="simpan">Simpan</button>
                                <a href="{{ route('pg') }}" class="btn btn-outline-danger ">Batal</a>
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