@extends('layouts/contentNavbarLayout')

@section('title', 'Saldo Material Tim')

@section('content')

    {{-- <div class="container"> --}}
    {{-- form print --}}
    @if (auth()->user()->jobdesk->jobdesk == 'Teknisi')
        <h4 name="judul" class="fw-bold py-3 mb-4">
            Saldo Material
        </h4>
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                {{-- <h5>Data Material</h5> --}}
                {{-- <h5 class="mb-0">Basic Layout</h5> <small class="text-muted float-end">Default label</small> --}}
            </div>
            <div class="card-body">
                <p class="card-text">Material yang tersedia : </p>
                <div class="table-responsive text-nowrap mb-3">
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Material</th>
                                <th>Saldo</th>
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
                <div class="alert alert-info" role="alert">
                    Harap dilakukan pengembalian ke kantor jika ada material yang belum habis di akhir bulan!!
                </div>
                @if ($info != null)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Reminder!!</strong> {{ $info }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
    @endif
    @if (auth()->user()->jobdesk->jobdesk == 'Master' || auth()->user()->jobdesk->jobdesk == 'Admin')
        <div class="table-responsive">
            <table class="table-borderless align-middle">
                <tr>
                    <td class="col-md-7">
                        <h4 name="judul" class="fw-bold py-3 mb-4">
                            Saldo Material Tim
                        </h4>
                    </td>

                    <form action="{{ route('print.tiket') }}" method="get" class="form-item"
                        enctype="multipart/form-data">
                        <td class="col-md-2">
                            <select name="jtiket" class="form-control mb-4">
                                <option value="" disabled selected>-Pekerjaan-</option>
                                @foreach ($jenistiket as $jt)
                                    <option value="{{ $jt->nama_tiket }}">{{ $jt->nama_tiket }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="col-md-2">
                            <select name="bulan" class="form-control mb-4">
                                <option value="" disabled selected>--Bulan--</option>
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </td>
                        <td class="col-md-2 col-2">
                            <input type="text" readonly class="form-control mb-4 ms-1" value="<?php $tahun = date('Y');
                            echo $tahun; ?>">
                            <input type="hidden" name="tahun" class="form-control mb-4" value="<?php $tahun = date('Y');
                            echo $tahun; ?>">
                        </td>
                        <td>
                            <button type="submit" target="_blank" class="btn btn-info mb-4 float-end ms-2"
                                name="cari">print</button>
                        </td>
                    </form>

                </tr>
            </table>
        </div>
        {{-- /form print --}}

        <div class="row justify-content-center">
            <div class="col-md-12">
                @if (Session::has('success'))
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>Berhasil!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (Session::has('error'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if ($reminder != null)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Reminder!!</strong> {{ $reminder }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card accordion-item mb-4">
                    <h2 class="accordion-header" id="headingOne">
                        <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                            data-bs-target="#accordionOne" aria-expanded="false" aria-controls="accordionOne">
                            Filter
                        </button>
                    </h2>

                    <div id="accordionOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample"
                        style="">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-md-6 col-12 mt-2">
                                    <form action="" method="GET" class="form-item">
                                        <div class="input-group">
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text" id="basic-addon-search31"><i
                                                        class="bx bx-search"></i></span>
                                                <input type="text" name="search" class="form-control"
                                                    placeholder="Cari Nama dan No Tiket" aria-label="Search..."
                                                    aria-describedby="basic-addon-search31">
                                            </div>
                                        </div>
                                </div>
                                <div class="col-6 col-sm-3 ms-0 mt-2 d-grid mx-auto">
                                    <select name="bulan" class="form-control">
                                        <option value="" disabled selected>--Bulan--</option>
                                        <option value="01">Januari</option>
                                        <option value="02">Februari</option>
                                        <option value="03">Maret</option>
                                        <option value="04">April</option>
                                        <option value="05">Mei</option>
                                        <option value="06">Juni</option>
                                        <option value="07">Juli</option>
                                        <option value="08">Agustus</option>
                                        <option value="09">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">Desember</option>
                                    </select>
                                </div>
                                <div class="col-6 col-sm-3 me-0 mt-2 d-grid mx-auto">
                                    <select name="jtiket" class="form-control">
                                        <option value="" disabled selected>-Pekerjaan-</option>
                                        @foreach ($jenistiket as $jt)
                                            <option value="{{ $jt->nama_tiket }}">{{ $jt->nama_tiket }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-9 mt-2 d-grid mx-auto">
                                    <select name="team" class="form-control">
                                        <option value="" disabled selected>-Nama Tim-</option>
                                        @foreach ($teamlist as $teamlist)
                                            <option value="{{ $teamlist->list_tim }}">{{ $teamlist->list_tim }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col mt-2 d-grid mx-auto">
                                    <button type="submit" class="btn btn-info" name="cari">Cari</button>
                                </div>
                                </form>

                                {{-- /form pencarian --}}
                                {{-- @if (auth()->user()->jobdesk->jobdesk == 'Teknisi')
                                <div class="col-2 col-md-2 mt-2 d-grid mx-auto">
                                    <a href="{{ route('tbh.tiket') }}" class="btn btn-primary">Tambah Data</a>
                                </div>
                            @endif --}}
                            </div>
                        </div>
                    </div>
                </div>

                @for ($i = 0; $i < $team->count(); $i++)
                    @for ($y = 0; $y < $tdetail->count(); $y++)
                        @if ($team[$i]->id == $tdetail[$y]->id)
                            <h5 class="pd-1 mb-4">
                                {{ $tdetail[$y]->jobdesk->jenistiket->nama_tiket }}
                            </h5>

                            <div class="card mb-4 table-responsive">
                                <div class="card-header d-flex align-item-start justify-content-between">
                                    <h5 class="align-middle">
                                        {{ $team[$i]->list_tim }}
                                    </h5>

                                    <a href="{{ route('edt.sld', $team[$i]->id) }}" class="btn mt-0 btn-primary">Update
                                        Data</a>
                                    {{-- <button type="button"  class="btn mt-0 btn-primary">Update Data</button> --}}

                                </div>
                                <div class="card-body">
                                    <div class="table-responsive text-nowrap">
                                        <table class="table">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Nama Material</th>
                                                    <th>Jumlah</th>
                                                    <th>Digunakan</th>
                                                    <th>Saldo</th>
                                                    <th>Ket</th>
                                                </tr>
                                            </thead>
                                            @for ($j = 0; $j < $saldo->count(); $j++)
                                                @if ($team[$i]->id == $saldo[$j]->id_tim)
                                                    <tbody class="table-border-bottom-0">
                                                        <tr>
                                                            <td>
                                                                {{ $saldo[$j]->material->nama_material }}
                                                            </td>
                                                            <td>
                                                                {{ $saldo[$j]->jumlah }}
                                                            </td>
                                                            <td>
                                                                {{ $saldo[$j]->guna }}
                                                            </td>
                                                            <td>
                                                                {{ $saldo[$j]->total_jumlah }}
                                                            </td>
                                                            <td>
                                                                {{ $saldo[$j]->total_jumlah == '0' ? 'Material Habis' : 'Pengembalian' }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                @endif
                                            @endfor
                                            @if ($saldo->count() == 0)
                                                <tbody class="table-border-bottom-0">
                                                    <tr>
                                                        <td colspan="5" align="center">
                                                            Material Kosong
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            @endif
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endfor
                @endfor
            </div>
    @endif

    {{-- </div> --}}
@endsection
