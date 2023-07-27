@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}">
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>
@endsection

@section('content')
    <div class="row justify-content-center d-flex">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            @if (auth()->user()->jobdesk->jobdesk == 'Master' or auth()->user()->jobdesk->jobdesk == 'Admin')
                                <h5 class="card-title text-primary">Halo {{ auth()->user()->karyawan->nama }} 🎉</h5>
                                <p class="mb-4">Berikut Beberapa Informasi Progress Pekerjaan dan Data yang Terkumpul Bulan
                                    Ini
                                    : </p>
                                {{-- <p class="mb-4">You have done <span class="fw-bold">72%</span> more sales today. Check your new badge in your profile.</p> --}}

                                {{-- <a href="javascript:;" class="btn btn-sm btn-outline-primary">View Badges</a> --}}
                                <small class="mb-1 text-secondary">{{ $tglnow }}</small>

                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img src="{{ asset('assets/img/illustrations/man-with-laptop-light.png') }}" height="140"
                                alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                data-app-light-img="illustrations/man-with-laptop-light.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center d-flex">
            <div class="col-lg-4 col-md-4 order-1">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <h5 class="fw-semibold d-block mb-1">Pasang Baru</h5>
                                </div>
                                <span class="d-block mb-1 text-muted">Sudah Terinput</span>
                                <h3 class="card-title mb-2">{{ $inputpsb }}</h3>
                                <span class="d-block mb-1 text-muted">Tiket Approve</span>
                                <h3 class="card-title mb-2">{{ $updatedpsb }}</h3>
                                <span class="d-block mb-1 text-muted">Berita Acara</span>
                                <h3 class="card-title mb-2">{{ $bapsb }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <h5 class="fw-semibold d-block mb-1">Gangguan</h5>
                                </div>

                                <span class="d-block mb-1 text-muted">Update Teknisi</span>
                                <h3 class="card-title mb-2">{{ $updatedggn }}</h3>
                                <span class="d-block mb-1 text-muted">Berita Acara</span>
                                <h3 class="card-title mb-2">{{ $baggn }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 order-1">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <h5 class="fw-semibold d-block mb-1">Maintenance</h5>
                                </div>

                                <span class="d-block mb-1 text-muted">Update Teknisi</span>
                                <h3 class="card-title mb-2">{{ $updatedmtn }}</h3>
                                <span class="d-block mb-1 text-muted">Berita Acara</span>
                                <h3 class="card-title mb-2">{{ $bamtn }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <h5 class="fw-semibold d-block mb-1">Total</h5>
                                </div>
                                <span class="d-block mb-1 text-muted">Data Laporan Pekerjaan Aman</span>
                                <h3 class="card-title mb-2">{{ $inputtotal }}</h3>
                                <span class="d-block mb-1 text-muted">Berita Acara</span>
                                <h3 class="card-title mb-2">{{ $batotal }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    @elseif (auth()->user()->jobdesk->jobdesk == 'Teknisi')
        <h5 class="card-title text-primary mb-2">Halo {{ auth()->user()->karyawan->nama }} 🎉</h5>
        <h6 class="card-title mb-2">Teknisi {{ auth()->user()->jobdesk->jenistiket->nama_tiket }} |
            {{ auth()->user()->teamdetail->teamlist->list_tim ?? 'Team belum di daftarkan'}}</h6>
        <h6 class="card-title">{{ auth()->user()->karyawan->nik }} </h6>
        <h6 class="card-title">Sektor {{ auth()->user()->teamdetail->teamlist->sektor[0]->sektor ?? 'Belum Terdaftar' }}</h6>
        <p class="mb-4 mt-4">Total Pekerjaan selesai dan Berita Acara pengeluaran material yang digunakan Bulan Ini : </p>
        <p>(Data yang dihitung hanyalah data yang sudah direkap)</p>
        {{-- <p class="mb-4">You have done <span class="fw-bold">72%</span> more sales today. Check your new badge in your profile.</p> --}}

        {{-- <a href="javascript:;" class="btn btn-sm btn-outline-primary">View Badges</a> --}}
        <small class="mb-1 text-secondary">{{ $tglnow }}</small>
    </div>
    </div>
    <div class="col-sm-5 text-center text-sm-left">
        <div class="card-body pb-0 px-0 px-md-4">
            <img src="{{ asset('assets/img/illustrations/man-with-laptop-light.png') }}" height="140"
                alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png"
                data-app-light-img="illustrations/man-with-laptop-light.png">
        </div>
    </div>
    </div>
    </div>
    </div>
    <div class="row justify-content-start d-flex">
        <div class="col-lg-4 col-md-4 order-1">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <h5 class="fw-semibold d-block mb-1">Tiket {{ auth()->user()->jobdesk->jenistiket->nama_tiket }}</h5>
                            </div>
                            <span class="d-block mb-1 text-muted">Total</span>
                            <h3 class="card-title mb-2">{{ $hitungTeknisi[0]->tikettims_count ?? '0' }}</h3>

                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <h5 class="fw-semibold d-block mb-1">Berita Acara</h5>
                            </div>
                            <span class="d-block mb-1 text-muted">Total</span>
                            <h3 class="card-title mb-2">{{ $hitungTeknisi[0]->ba_count ?? '0' }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if (auth()->user()->jobdesk->jobdesk == 'Master' or auth()->user()->jobdesk->jobdesk == 'Admin')
            <div class="row justify-content-center d-flex">
                <div class="col-lg-12 mb-4 order-2">
                    <div class="card">
                        <div class="card-header">
                            <form action="" method="GET" class="form-item">

                                <div class="col mt-2 d-grid mx-auto">
                                    <select name="jtiket" class="form-control">
                                        <option value="" disabled selected>-Pekerjaan-</option>
                                        @foreach ($jenistiket as $jt)
                                            <option value="{{ $jt->id }}">{{ $jt->nama_tiket }}</option> 
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col mt-2 d-grid mx-auto">
                                    <button type="submit" class="btn btn-info" name="cari">Cari</button>
                                </div>
                            </form>

                        </div>
                        <div class="d-flex align-items-end row">
                            <div class="card-body">
                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead class="table-light">
                                            <tr>
                                                <th>NO</th>
                                                <th>Kode Tim</th>
                                                <th>Pekerjaan</th>
                                                <th>Tiket Update</th>
                                                <th>Input Berita Acara</th>
                                                <th>Total Rekap Data</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">
                                            <?php $no = 1; ?>
                                            @foreach ($hitung as $count)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $count->list_tim }}</td>
                                                    <td>
                                                        {{ $count->teamdetail->jobdesk->jenistiket->nama_tiket ?? 'Tim Kosong' }}
                                                    </td>
                                                    <td>{{ $count->tikettims_count ?? '0' }}</td>
                                                    <td>{{ $count->ba_count ?? '0' }}</td>
                                                    <td>{{ $count->rekapbas_count ?? '0' }}</td>
                                                    <td>
                                                        @if ($count->tikettims_count == '0')
                                                            Belum direkap
                                                        @elseif ($count->tikettims_count > $count->rekapbas_count)
                                                            Belum direkap
                                                        @elseif ($count->tikettims_count == $count->rekapbas_count)
                                                            Semua Data Terekap
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endif


    </div>


@endsection
