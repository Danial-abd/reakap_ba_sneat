@extends('layouts/contentNavbarLayout')

@section('title', 'Data Tim')

@section('content')

    {{-- <div class="container"> --}}
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('td') }}" class="text-reset fw-bold">
                Daftar Anggota Tim/</a></span> Input Data Anggota Tim</h4>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    {{-- <h5 class="mb-0">Basic Layout</h5> <small class="text-muted float-end">Default label</small> --}}
                </div>
                <div class="card-body">
                    <form action="{{ route('spn.td') }}" method="POST" class="form-item">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Nama Tim</label>
                            <div class="col-sm-10">
                            <select name="id_team" id="id_team" class="form-control">
                                <option value="" disabled selected>--Pilih Nama Tim--</option>
                                    @foreach($teamlist as $tl)
                                        
                                        <option value="{{$tl->id}}">{{$tl->list_tim}}</option>    
                                    
                                    @endforeach
                            </select>
                        </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Nama Anggota</label>
                            <div class="col-sm-10">
                            <select name="id_karyawan" class="form-control">
                                <option value="" disabled selected>--Pilih Nama Karyawan--</option>
                                    @foreach($karyawan as $k)
                                        <option value="{{$k->id}}">{{$k->nama}}</option>    
                                    @endforeach
                            </select>
                        </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Pekerjaan</label>
                            <div class="col-sm-10">
                            <select name="id_jobdesk" id="id_jobdesk" class="form-control">
                                <option value="" disabled selected>--Pilih Nama Pekerjaan--</option>
                                    @foreach($jobdesk as $jd)
                                        <option value="{{$jd->id}}">{{$jd->jobdesk}} {{ $jd->jenistiket->nama_tiket }}</option>    
                                    @endforeach
                            </select>
                        </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Ketarangan</label>
                            <div class="col-sm-10">
                                <textarea name="ket" id="alamat" class="form-control" cols="2" rows="3" placeholder="Masukkan Alamat"
                                    style="resize : none"></textarea>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-sm-10 gap-3 d-flex">
                                <button type="submit" class="btn btn-info" name="simpan">Simpan</button>
                                <a href="{{ route('td') }}" class="btn btn-outline-danger ">Batal</a>
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
