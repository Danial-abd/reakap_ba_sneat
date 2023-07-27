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
            @error('f_progress')
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> </br>
                    Harap Masukkan Foto Progress Kawan!!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @enderror
            @error('f_lokasi')
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> </br>
                    Harap Masukkan Foto Lokasi Kawan!!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @enderror
            @error('f_lap_tele')
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> </br>
                    Harap Masukkan Screenshoot Hasil Laporan dari Telegram Kawan!!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @enderror
            <form action="{{ route('spn.tiket') }}" method="POST" class="form-item" enctype="multipart/form-data">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5>Data Pekerjaan</h5>
                    </div>
                    <div class="card-body">
                        @csrf
                        
                        @if (auth()->user()->jobdesk->detail_kerja == 1)
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Penyebab Gangguan</label>
                                <div class="col-sm-10">
                                    <select name="id_ggn" id="ggn" onchange="showInputGgn()" class="form-control">
                                        <option value="" disabled selected>--Pilih Penyebab--</option>
                                        @foreach ($penyebab as $index => $penyebab)
                                            @if ($index != 0)
                                                <option value="{{ $penyebab->id }}">{{ $penyebab->penyebab }}</option>
                                            @endif
                                        @endforeach
                                        <option value="{{ $penyebab->first()->id }}">{{ $penyebab->first()->penyebab }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3" id="inputGgn" style="display: none;">
                                <label class="col-sm-2 col-form-label" for="ket_ggn">Lainnya</label>
                                <div class="col-sm">
                                    <input type="text" id="ket_ggn" class="form-control" name='ket_ggn' id="basic-default-name"
                                        placeholder="Masukkan Penyebab Gangguan">
                                </div>
                            </div>
                        @endif
                        @if (auth()->user()->jobdesk->jobdesk == 'Teknisi')
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Nama Tim</label>
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
                                <label class="col-sm-2 col-form-label">Nama Tim</label>
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
                            <label class="col-sm-2 col-form-label">No Tiket</label>
                            <div class="col col-sm">
                                <input type="text" class="form-control  @error('no_tiket') is-invalid @enderror"
                                    name='no_tiket' id="basic-default-name" placeholder="Masukkan No Tiket">
                                @error('no_tiket')
                                    <div class="invalid-feedback">
                                        {{ 'Harap isikan no tiket' }}
                                    </div>
                                @enderror
                            </div>
                            <label class="col-sm-2 col-form-label">Tiket</label>
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
                            <label class="col-sm-2 col-form-label">No Internet</label>
                            <div class="col-sm">
                                <input type="text" class="form-control  @error('no_inet') is-invalid @enderror"
                                    name='no_inet' placeholder="Masukkan Nomor Internet">
                                @error('no_inet')
                                    <div class="invalid-feedback">
                                        {{ 'Harap isikan nomor berlangganan' }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Nama Pelanggan</label>
                            <div class="col-sm">
                                <input type="text" class="form-control  @error('nama_pic') is-invalid @enderror"
                                    name='nama_pic' id="basic-default-name" placeholder="Masukkan Nama Pelanggan">
                                @error('nama_pic')
                                    <div class="invalid-feedback">
                                        {{ 'Harap isikan nama pelanggan' }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">No Pic</label>
                            <div class="col-sm">
                                <input type="number" class="form-control  @error('no_pic') is-invalid @enderror"
                                    name='no_pic' id="basic-default-name" placeholder="Masukkan Nomor Pelanggan">
                                @error('no_pic')
                                    <div class="invalid-feedback">
                                        {{ 'Harap isikan no pic' }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Alamat</label>
                            <div class="col-sm-10">
                                <textarea name="alamat" id="alamat" class="form-control  @error('alamat') is-invalid @enderror" cols="2"
                                    rows="3" placeholder="Masukkan Alamat" style="resize : none"></textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">
                                        {{ 'Harap isikan alamat pelanggan' }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Ket</label>
                            <div class="col-sm-10">
                                <textarea name="ket" id="alamat" class="form-control @error('ket') is-invalid @enderror" cols="2"
                                    rows="3" placeholder="Masukkan Keterangan Tiket" style="resize : none"></textarea>
                                @error('ket')
                                    <div class="invalid-feedback">
                                        {{ 'Harap isikan keterangan pekerjaan' }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">lokasi</label>
                            <div class="col input-group">
                                <button class="btn btn-primary lokasi" type="button" id=""><span
                                        class="tf-icons bx bx-location-plus"></span></button>
                                <input type="text" class="form-control @error('kordinat') is-invalid @enderror"
                                    id='lokasi' name="kordinat" placeholder="lokasi"
                                    aria-label="Example text with button addon" aria-describedby="button-addon1">
                                <input type="text" id="latitude" name='latitude' hidden>
                                <input type="text" id="longitude" name="longitude" hidden>
                                @error('kordinat')
                                    <div class="invalid-feedback">
                                        {{ 'Harap masukkan kordinat rumah pelanggan' }}
                                    </div>
                                @enderror

                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label"></label>
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
                                    @forelse ($saldo as $s)
                                        <tr>
                                            <td>
                                                {{ $s->material->nama_material }} </br>
                                            </td>
                                            <td>
                                                {{ $s->total_jumlah }} {{ $s->total_jumlah >= 1000 ? 'm' : 'pcs' }}</br>
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
                        @if ($saldo->count() == 0)
                            <div class="row mb-3">
                                <div class="col">
                                    <div class="alert alert-danger" role="alert">
                                        Harap Masukkan Berita Acara dengan Material Baru untuk Input Tiket
                                    </div>

                                </div>
                            </div>
                        @else
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

                    </div>
                </div>

                <div class="card mb-4 text-center">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5>Dokumentasi</h5>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-md-center mb-4 ">
                            <div class="col mb-4">
                                <div class="row">
                                    <label class="form-label">Foto Lokasi</label>
                                </div>
                                <div class="row mb-2">
                                    <img src="{{ asset('assets/img/illustrations/nopic.png') }}" id="lok"
                                        width="150" height="250">
                                </div>
                                <input type="file" id="actual-btn" name="f_lokasi" hidden accept="image/*"
                                    onchange="document.getElementById('lok').src = window.URL.createObjectURL(this.files[0])">
                                <label class="btn btn-primary" for="actual-btn"><span
                                        class="tf-icons bx bx-camera"></span></label>
                            </div>

                            <div class="col mb-4">
                                <div class="row">
                                    <label class="form-label">Foto Progress</label>
                                </div>
                                <div class="row mb-2">
                                    <img src="{{ asset('assets/img/illustrations/nopic.png') }}" id="prog"
                                        width="150" height="250" alt="">
                                </div>
                                <input type="file" id="btn-progress" name="f_progress" hidden accept="image/*"
                                    onchange="document.getElementById('prog').src = window.URL.createObjectURL(this.files[0])">
                                <label class="btn btn-primary" for="btn-progress"><span
                                        class="tf-icons bx bx-camera"></span></label>
                            </div>

                            <div class="col mb-4">
                                <div class="row">
                                    <label class="form-label">Laporan Telegram</label>
                                </div>
                                <div class="row mb-2">
                                    <img src="{{ asset('assets/img/illustrations/nopic.png') }}" id="tele"
                                        width="150" height="250" alt="">
                                </div>
                                <input type="file" id="btn-telegram" name="f_lap_tele" hidden accept="image/*"
                                    onchange="document.getElementById('tele').src = window.URL.createObjectURL(this.files[0])">
                                <label class="btn btn-primary" for="btn-telegram"><span
                                        class="tf-icons bx bx-camera"></span></label>
                            </div>
                        </div>

                        <div class="row justify-content-between">
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
        var corx = document.getElementById('latitude');
        var cory = document.getElementById('longitude');

        var x = document.getElementById('lo');

        $('.addmaterial').on('click', function() {
            addmaterial();
        });

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
                corx.value = lat;
                cory.value = long;
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

        function addmaterial() {
            // ++i;
            var material =
                '<div class ="row mb-3"><label class="col-sm-2 col-form-label" for="basic-default-name"></label><div class="col-sm-7 mb-2"><select name="id_material[]" class="form-control"><option value="" disabled selected>--Pilih Material--</option>@foreach ($material as $m)<option value="{{ $m->id }}">{{ $m->nama_material }}</option>@endforeach</select></div><div class="col col-sm mb-2"><input type="text" class="form-control" name="jumlah[]" placeholder="Jumlah"></div><div class="col-auto"><button type="button" class="hapus btn btn-info">hapus</button></div></div>';
            $('.material').append(material);
        };
        $('.hapus').live('click', function() {
            $(this).parent().parent().remove();
        });

        function showInputGgn() {
            var selectElement = document.getElementById('ggn');
            var inputField = document.getElementById('inputGgn');

            if (selectElement.value === '1') {
                inputField.style.display = '';
            } else {
                // Sembunyikan inputField untuk opsi lainnya
                inputField.style.display = 'none';
            }
        }
    </script>
    {{-- </div> --}}
@endsection
