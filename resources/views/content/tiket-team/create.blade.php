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
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5>Data Pekerjaan</h5>
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
                            <div class="col col-sm">
                                <input type="text" class="form-control  @error('no_tiket') is-invalid @enderror"
                                    name='no_tiket' id="basic-default-name" placeholder="Masukkan No Tiket">
                            </div>
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Tiket</label>
                            <div class="col-sm">
                                <input type="text" class="form-control" readonly
                                    value="{{ auth()->user()->jobdesk->jenistiket->nama_tiket }}" id="basic-default-name"
                                    placeholder="Masukkan Kode Jobdesk">
                                <input type="hidden" class="form-control" name='id_j_tiket'
                                    value="{{ auth()->user()->jobdesk->detail_kerja }}" id="basic-default-name"
                                    placeholder="">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Nama Pelanggan</label>
                            <div class="col-sm">
                                <input type="text" class="form-control  @error('no_tiket') is-invalid @enderror"
                                    name='nama_pic' id="basic-default-name" placeholder="Masukkan Nama Pelanggan">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">No Pic</label>
                            <div class="col-sm">
                                <input type="number" class="form-control  @error('no_tiket') is-invalid @enderror"
                                    name='no_pic' id="basic-default-name" placeholder="Masukkan Nomor Pelanggan">
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
                                <textarea name="ket" id="alamat" class="form-control" cols="2" rows="3"
                                    placeholder="Masukkan Keterangan Tiket" style="resize : none"></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">lokasi</label>
                            <div class="col input-group">
                                <button class="btn btn-primary lokasi" type="button" id=""><span
                                        class="tf-icons bx bx-location-plus"></span></button>
                                <input type="text" class="form-control" id='lokasi' placeholder="lokasi"
                                    aria-label="Example text with button addon" aria-describedby="button-addon1">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name"></label>
                            <div class="col">
                                <div id="map"></div>
                            </div>
                        </div>
                </div>
                {{-- <hr class="my-0"> --}}
            </div>

            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5>Data Material</h5>
                    {{-- <h5 class="mb-0">Basic Layout</h5> <small class="text-muted float-end">Default label</small> --}}
                </div>
                <div class="card-body">
                    <p class="card-text">Material yang tersedia : </p>
                    <div class="table-responsive text-nowrap mb-3">
                        <table class="table">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama Material</th>
                                    <th>Jumlah</th>
                                </tr>
                                @php
                                    $no = 1;
                                @endphp
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        @foreach ($saldo as $s)
                                            {{ $s->material->nama_material }} </br>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($saldo as $s)
                                            {{ $s->total_jumlah }} {{ $s->total_jumlah >= 1000 ? 'm' : 'pcs' }}</br>
                                        @endforeach
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Input Material</label>
                        <div class="col-sm-7 mb-2">
                            <select name="id_material[]" class="form-control @error('id_material') is-invalid @enderror">
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

                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5>Dokumentasi</h5>
                </div>
                <div class="card-body">

                    <div class="row justify-content-end">
                        <div class="col-sm-10 gap-3 d-flex">
                            <button type="submit" class="btn btn-info" name="simpan">Simpan</button>
                            <a href="{{ route('tiket') }}" class="btn btn-outline-danger ">Batal</a>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
    </div>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        var lokasi = document.getElementById('lokasi');
        var x = document.getElementById('lo');


        $('.lokasi').on('click', function() {
            var map = L.map('map');
            map.setView([-3.3081595923597558, 114.58849816578518], 17);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            let marker, circle, zoomed;

            navigator.geolocation.watchPosition(successCallback, errorCallback);

            function successCallback(pos) {

                if (marker) {
                    map.removeLayer(marker);
                    // map.removeLayer(circle);
                }

                const lat = pos.coords.latitude;
                const long = pos.coords.longitude;
                const accuracy = pos.coords.accuracy;

                lokasi.value = lat + "," + long;
                marker = L.marker([lat, long]).addTo(map);
                map.setView([lat, long], 17);

                circle = L.circle([lat, long], {
                    radius: accuracy
                }).addTo(map);

                if (!zoomed) {
                    zoomed = map.fitBounds(circle.getBounds());
                }
            }

            function errorCallback(error) {
                switch (error.code) {
                    case error.PERMISSION_DENIED:
                        x.innerHTML =
                            '<div class="position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 5000"><div class="bs-toast toast fade show bg-danger" role="alert" aria-live="assertive" aria-atomic="true"><div class="toast-header"><i class="bx bx-bell me-2"></i><div class="me-auto fw-semibold">Error</div><button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button></div><div class="toast-body">Tidak dapat izin menggunakan lokasi.</div></div></div>'
                        // x.timeOut = setTimeout(()=>x.remove(), 5000)
                        break;
                        // case error.POSITION_UNAVAILABLE:
                        //     x.innerHTML = "Location information is unavailable."
                        //     break;
                    case error.TIMEOUT:
                        x.innerHTML =
                            '<div class="position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 5000"><div class="bs-toast toast fade show bg-danger" role="alert" aria-live="assertive" aria-atomic="true"><div class="toast-header"><i class="bx bx-bell me-2"></i><div class="me-auto fw-semibold">Error</div><button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button></div><div class="toast-body">The request to get user location timed out.</div></div></div>'
                        break;
                    case error.UNKNOWN_ERROR:
                        x.innerHTML =
                            '<div class="position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 5000"><div class="bs-toast toast fade show bg-danger" role="alert" aria-live="assertive" aria-atomic="true"><div class="toast-header"><i class="bx bx-bell me-2"></i><div class="me-auto fw-semibold">Error</div><button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button></div><div class="toast-body">An unknown error occurred.</div></div></div>'
                        break;
                }

            }

        });

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
