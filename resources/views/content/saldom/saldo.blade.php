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

                @if (auth()->user()->teamdetail->id_jobdesk == 3)
                <div class="alert alert-info" role="alert">
                    Harap dilakukan pengembalian ke kantor jika ada material yang belum habis di akhir bulan!!
                </div>
                    @if ($info != null)
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Reminder!!</strong> {{ $info }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                @endif
            </div>
    @endif
    @if (auth()->user()->jobdesk->jobdesk == 'Master' || auth()->user()->jobdesk->jobdesk == 'Admin')
        <div class="table-responsive">
            <table class="table-borderless align-middle">
                <tr>
                    <td class="col-md-7">
                        <h4 name="judul" class="fw-bold py-3 mb-4">
                            Saldo Material Tim Pasang Baru
                        </h4>
                    </td>

                    <form action="" method="get" class="form-item" enctype="multipart/form-data">
                        <td class="col-md-2">
                            <select name="jtiket" class="form-control mb-4">
                                <option value="" disabled selected>-Pekerjaan-</option>
                                @foreach ($jenistiket as $jt)
                                    <option value="{{ $jt->nama_tiket }}">{{ $jt->nama_tiket }}</option>
                                @endforeach
                            </select>
                        </td>
                        @php
                            $bln = date('m');
                        @endphp
                        <td class="col-md-2">
                            <select name="bulan" class="form-control mb-4">
                                <option value="" disabled selected>--Bulan--</option>
                                <option value="">Semua Data</option>
                                <option value="01" {{ $bln == 1 ? 'selected' : '' }}>Januari</option>
                                <option value="03" {{ $bln == 03 ? 'selected' : '' }}>Maret</option>
                                <option value="02" {{ $bln == 02 ? 'selected' : '' }}>Februari</option>
                                <option value="04" {{ $bln == 04 ? 'selected' : '' }}>April</option>
                                <option value="05" {{ $bln == 05 ? 'selected' : '' }}>Mei</option>
                                <option value="06" {{ $bln == 06 ? 'selected' : '' }}>Juni</option>
                                <option value="07" {{ $bln == 07 ? 'selected' : '' }}>Juli</option>
                                <option value="08" {{ $bln == 8 ? 'selected' : '' }}>Agustus</option>
                                <option value="09" {{ $bln == 9 ? 'selected' : '' }}>September</option>
                                <option value="10" {{ $bln == 10 ? 'selected' : '' }}>Oktober</option>
                                <option value="11" {{ $bln == 11 ? 'selected' : '' }}>November</option>
                                <option value="12" {{ $bln == 012 ? 'selected' : '' }}>Desember</option>
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
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Berhasil!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (Session::has('error'))
                    <div class="position-fixed top-0 end-0 p-3" style="z-index: 5000">
                        <div class="bs-toast toast fade show bg-warning" role="alert" aria-live="assertive"
                            aria-atomic="true">
                            <div class="toast-header"><i class="bx bx-bell me-2"></i>
                                <div class="me-auto fw-semibold">Error</div><button type="button" class="btn-close"
                                    data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                            <div class="toast-body">{{ session('error') }}</div>
                        </div>
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
                                        <option value="01" {{ $bln == 1 ? 'selected' : '' }}>Januari</option>
                                        <option value="03" {{ $bln == 03 ? 'selected' : '' }}>Maret</option>
                                        <option value="02" {{ $bln == 02 ? 'selected' : '' }}>Februari</option>
                                        <option value="04" {{ $bln == 04 ? 'selected' : '' }}>April</option>
                                        <option value="05" {{ $bln == 05 ? 'selected' : '' }}>Mei</option>
                                        <option value="06" {{ $bln == 06 ? 'selected' : '' }}>Juni</option>
                                        <option value="07" {{ $bln == 07 ? 'selected' : '' }}>Juli</option>
                                        <option value="08" {{ $bln == 8 ? 'selected' : '' }}>Agustus</option>
                                        <option value="09" {{ $bln == 9 ? 'selected' : '' }}>September</option>
                                        <option value="10" {{ $bln == 10 ? 'selected' : '' }}>Oktober</option>
                                        <option value="11" {{ $bln == 11 ? 'selected' : '' }}>November</option>
                                        <option value="12" {{ $bln == 012 ? 'selected' : '' }}>Desember</option>
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
                            </div>
                        </div>
                    </div>
                </div>



                @for ($i = 0; $i < $teampsb->count(); $i++)
                    {{-- @for ($y = 0; $y < $tdetail->count(); $y++) --}}
                    {{-- @if ($team[$i]->id == $tdetail[$y]->id) --}}
                    <h5 class="pd-1 mb-4">
                        {{-- {{ $tdetail[$y]->jobdesk->jenistiket->nama_tiket }} --}}
                    </h5>

                    <div class="card mb-4 table-responsive">
                        <div class="card-header d-flex align-item-start justify-content-between">
                            <h5 class="align-middle">
                                {{ $teampsb[$i]->list_tim }}
                            </h5>

                            <a href="{{ route('edt.sld', [$teampsb[$i]->id, $bulan]) }}"
                                class="btn mt-0 btn-primary">Input
                                Pengembalian Material</a>
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
                                    {{-- @foreach ($saldo as $saldo) --}}
                                    @for ($q = 0; $q < $saldo->count(); $q++)
                                        @if ($saldo[$q]->id_tim == $teampsb[$i]->id)
                                            <tbody class="table-border-bottom-0">
                                                <tr>
                                                    <td>
                                                        {{ $saldo[$q]->material->nama_material }}
                                                    </td>
                                                    <td>
                                                        {{ $saldo[$q]->jumlah }}
                                                    </td>
                                                    <td>
                                                        {{ $saldo[$q]->guna }}
                                                    </td>
                                                    <td>
                                                        {{ $saldo[$q]->total_jumlah }}
                                                    </td>
                                                    <td>
                                                        {{ $saldo[$q]->total_jumlah == '0' ? 'Material Habis' : 'Pengembalian' }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        @endif
                                    @endfor
                                    {{-- @endforeach --}}
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
                    {{-- @endif --}}
                    {{-- @endfor --}}
                @endfor
            </div>
    @endif

    {{-- </div> --}}
    <script>
        // var x = document.getElementById('lo');
        // @if (Session::has('error'))
        //     x.innerHTML =
        //         '<div class="position-fixed top-0 end-0 translate-middle-x p-3" style="z-index: 5000"><div class="bs-toast toast fade show bg-danger" role="alert" aria-live="assertive" aria-atomic="true"><div class="toast-header"><i class="bx bx-bell me-2"></i><div class="me-auto fw-semibold">Error</div><button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button></div><div class="toast-body">Tidak dapat izin menggunakan lokasi.</div></div></div>'

        {{-- <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div> --}}
            <
            div class = "position-fixed top-0 end-0 translate-middle-x p-3"
        style = "z-index: 5000" >
            <
            div class = "bs-toast toast fade show bg-warning"
        role = "alert"
        aria - live = "assertive"
        aria - atomic = "true" >
            <
            div class = "toast-header" > < i class = "bx bx-bell me-2" > < /i> <
        div class = "me-auto fw-semibold" > Error < /div><button type="button" class="btn-close"
        data - bs - dismiss = "toast"
        aria - label = "Close" > < /button> < /
        div > <
            div class = "toast-body" > {{ session('error') }} < /div> < /
        div > <
            /div>
        // @endif
    </script>
@endsection
