@extends('layouts/contentNavbarLayout')

@section('title', 'Data Tim')

@section('content')

    {{-- <div class="container"> --}}
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('td') }}" class="text-reset fw-bold">
                Daftar Anggota Tim/</a></span> Edit Data Anggota Tim</h4>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    {{-- <h5 class="mb-0">Basic Layout</h5> <small class="text-muted float-end">Default label</small> --}}
                </div>
                <div class="card-body">
                    <form action="{{ route('up.td', $teamdetail->first()->id_team) }}" method="POST" class="form-item">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Nama Tim</label>
                            <div class="col-sm-10">
                                <select name="id_team" id="id_team" class="form-control">
                                    <option value="" disabled selected>--Pilih Nama Tim--</option>
                                    <option value="{{ $teamdetail->first()->id_team }}" selected>{{ $teamdetail->first()->teamlist->list_tim }}</option>
                                    @foreach ($teamlist as $tl)
                                        <option value="{{ $tl->id }}"
                                            {{ $teamdetail->first()->id_team == $tl->id ? 'selected' : '' }}>
                                            {{ $tl->list_tim }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-default-name">Nama Anggota 1</label>
                                <div class="col-sm-10">
                                    <select name="id_karyawan[]" id="id_team" class="form-control">
                                        <option value="" disabled selected>--Pilih Nama Karyawan--</option>
                                        <option value="{{$teamdetail[0]->id_karyawan}}" selected>{{$teamdetail[0]->karyawan->nama}}</option>
                                        @foreach ($karyawan as $k)
                                            <option value="{{ $k->id }}">
                                                {{ $k->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-default-name">Nama Anggota 2</label>
                                <div class="col-sm-10">
                                    <select name="id_karyawan[]" id="id_team" class="form-control">
                                        <option value="" disabled selected>--Pilih Nama Karyawan--</option>
                                        <option value="{{$teamdetail[1]->id_karyawan}}" selected>{{$teamdetail[1]->karyawan->nama}}</option>
                                        @foreach ($karyawan as $k)
                                            <option value="{{ $k->id }}">
                                                {{ $k->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Pekerjaan</label>
                            <div class="col-sm-10">
                                <select name="id_jobdesk" id="id_jobdesk" class="form-control">
                                    <option value="" disabled selected>--Pilih Nama Pekerjaan--</option>
                                    @foreach ($jobdesk as $jd)
                                        <option value="{{ $jd->id }}"
                                            {{ $teamdetail->first()->id_jobdesk == $jd->id ? 'selected' : '' }}>
                                            {{ $jd->jobdesk }} {{ $jd->jenistiket->nama_tiket ?? '' }}</option>
                                    @endforeach
                                </select>
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
