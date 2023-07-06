@extends('layouts/contentNavbarLayout')

@section('title', 'Rekap Tiket Tim')

@section('content')

    {{-- <div class="container"> --}}

    <h4 class="fw-bold py-3 mb-4">
        <p><span class="text-muted fw-light"><a href="{{ route('sld') }}" class="text-reset fw-bold">
                    Saldo Material Tim/ </a></span></p>Update Data {{ $saldotim[0]->teamlist->list_tim }}
    </h4>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if (Session::has('error'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('up.sld', $saldotim[0]->id_tim ) }}" method="POST" class="form-item" enctype="multipart/form-data">
            @csrf
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5>Data Material</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Material yang tersedia : </p>
                    <div class="table-responsive text-nowrap mb-3">
                        <table class="table mb-4">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama Material</th>
                                    <th>Sisa Saldo</th>
                                </tr>
                                @php
                                    $no = 1;
                                @endphp
                            </thead>
                            <tbody>
                                @forelse ($saldotim as $s)
                                    <tr>
                                        <td>
                                            {{ $s->material->nama_material }} </br>
                                        </td>
                                        <td>
                                            {{ $s->total_jumlah }} {{ $s->total_jumlah > 50 ? 'm' : 'pcs' }}</br>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="align-middle" colspan="2" align="center">
                                            Material Kosong
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($saldotim->count() == 0)
                        <div class="row mb-3">
                            <div class="col">
                                <div class="alert alert-danger" role="alert">
                                    Harap Masukkan Berita Acara dengan Material Baru untuk Input Tiket
                                </div>

                            </div>
                        </div>
                    @else
                        <h6 class="mb-4">Update Data Pengembalian</h6>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Input Material</label>
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
                    @endif
                    <div class="material"></div>

                    <div class="row mt-4 justify-content-between">
                        <div class="col-sm-10 gap-3 d-flex">
                            <button type="submit" class="btn btn-info" name="simpan">Simpan</button>
                            <a href="{{ route('sld') }}" class="btn btn-outline-danger ">Batal</a>
                        </div>
                    </div>

                </div>
            </div>
            </form>
        </div>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        var x = document.getElementById('lo');

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
    {{-- </div> --}}
@endsection
