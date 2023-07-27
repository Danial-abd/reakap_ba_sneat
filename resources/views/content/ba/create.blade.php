@extends('layouts/contentNavbarLayout')

@section('title', 'Data Berita Acara')

@section('content')

    {{-- <div class="container"> --}}
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('ba') }}" class="text-reset fw-bold">
                Daftar Berita Acara/</a></span> Input Data Berita Acara</h4>
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
                    <form action="{{ route('spn.ba') }}" method="POST" class="form-item" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">No Berita Acara</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control  @error('no_ba') is-invalid @enderror"
                                    name='no_ba' id="basic-default-name" placeholder="Masukkan No Berita Acara">
                                @error('id_material')
                                    <div class="invalid-feedback">
                                        {{ 'Harap isikan masukkan no berita acara' }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Nama Tim</label>
                            <div class="col-sm-10">
                                @if (auth()->user()->jobdesk->jobdesk == 'Teknisi')
                                    <input type="text" class="form-control" readonly
                                        value="{{ auth()->user()->teamdetail->teamlist->list_tim }} {{ auth()->user()->teamdetail->karyawan->nama }}"
                                        id="basic-default-name" placeholder="Masukkan Kode Jobdesk">
                                    <input type="hidden" class="form-control" readonly name='id_tim'
                                        value="{{ auth()->user()->karyawan->id }}" id="basic-default-name"
                                        placeholder="Masukkan Kode Jobdesk">
                                @else
                                    <select name="id_tim" class="form-control">
                                        <option value="" disabled selected>--Pilih Nama Tim--</option>
                                        @foreach ($teamdetail as $td)
                                            <option value="{{ $td->id }}">{{ $td->teamlist->list_tim }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Upload File</label>
                            <div class="col-sm-10">
                                <input class="form-control @error('file_ba') is-invalid @enderror" name="file_ba"
                                    type="file" id="formFile">
                                @error('file_ba')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Input Material</label>
                            <div class="col-sm-7 mb-2">
                                <select name="id_material[]"
                                    class="form-control @error('id_material') is-invalid @enderror">
                                    <option value="" disabled selected>--Pilih Material--</option>
                                    @foreach ($material as $m)
                                        <option value="{{ $m->id }}">{{ $m->nama_material }}</option>
                                    @endforeach
                                </select>
                                @error('id_material')
                                    <div class="invalid-feedback">
                                        {{ 'Harap isikan nama material' }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col col-sm mb-2">
                                <input type="number" name="jumlah[]"
                                    class="form-control @error('jumlah') is-invalid @enderror" placeholder="Jumlah">
                                @error('jumlah')
                                    <div class="invalid-feedback">
                                        {{ 'Harap isikan jumlah material' }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-auto">
                                <button type="button" class="addmaterial btn btn-info">Tambah</button>
                            </div>
                        </div>

                        <div class="material"></div>

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
    <script>
        // var i = 0;
        $('.addmaterial').on('click', function() {
            addmaterial();
        });

        function addmaterial() {
            // ++i;
            var material =
                '<div class ="row mb-3"><label class="col-sm-2 col-form-label" for="basic-default-name"></label><div class="col-sm-7 mb-2"><select name="id_material[]" class="form-control"><option value="" disabled selected>--Pilih Material--</option>@foreach ($material as $m)<option value="{{ $m->id }}">{{ $m->nama_material }}</option>@endforeach</select></div><div class="col col-sm mb-2"><input type="text" class="form-control" name="jumlah[]" placeholder="Jumlah"></div><div class="col-auto"><button type="button" class="hapus btn btn-info">hapus</button></div></div>';
            $('.material').append(material);
        };
        $('.hapus').live('click', function() {
            $(this).parent().parent().remove();
        });
    </script>

@endsection
