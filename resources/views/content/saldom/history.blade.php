@extends('layouts/contentNavbarLayout')

@section('title', 'History Pengembalian')

@section('content')

    {{-- <div class="container"> --}}
    <div class="table-responsive">
        <table class="table-borderless align-middle">
            <tr>
                <td class="col-md-7">
                    <h4 name="judul" class="fw-bold py-3 mb-4">
                        History Pegembalian
                    </h4>
                </td>

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
                        data-bs-target="#accordion1" aria-expanded="false" aria-controls="accordionOne">
                        Filter
                    </button>
                </h2>

                <div id="accordion1" class="accordion-collapse collapse" data-bs-parent="#accordionExample" style="">
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
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>
                                        No
                                    </th>
                                    <th>
                                        Waktu Pengembalian
                                    </th>
                                    <th>
                                        Nama Tim
                                    </th>
                                    <th>
                                        Nama Material
                                    </th>
                                    <th>
                                        Jumlah Pengembalian
                                    </th>
                                    <th>
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($saldo as $saldo)
                                <tr class="bwh">
                                    <td>
                                        {{ $i++ }}

                                    </td>
                                    <td>
                                        {{ $saldo->updated_at }}
                                    </td>
                                    <td>
                                        {{ $saldo->teamlist->list_tim }}
                                    </td>
                                    <td>
                                        {{ $saldo->material->nama_material }}
                                    </td>
                                    <td>
                                        {{ $saldo->digunakan }}
                                    </td>
                                    <td>
                                        <a href="{{route('e.hsld', $saldo->id)}}" class="btn btn-warning bx-tada-hover"><span class="fa-solid fa-pen-to-square"></span></a>
                                        <a href="{{route('dlt.hsld', $saldo->id)}}" class="btn btn-danger bx-tada-hover"><span class="bx bxs-trash"></span></a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
            
        </div>

    @endsection
    {{-- @foreach ($saldo as $s)
                <div class="card accordion-item mt-2">
                    <h2 class="accordion-header" id="{{'c'. $s->id_saldo}}">
                        <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                            data-bs-target="{{'#a' . $s->id_saldo }}" aria-expanded="false" aria-controls="{{'b'. $s->id_saldo}}">
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <td>
                                            {{ $i++ }}
                                        </td>
                                        <td>
                                            {{ $s->created_at }}
                                        </td>
                                        <td>
                                            {{ $s->teamlist->list_tim }}
                                        </td>
                                        <td>
                                            {{ $s->material->nama_material }}
                                        </td>
                                        <td>
                                            {{ $s->digunakan }}
                                        </td>
                                    </tr>
                                </table>
                            </div>  
                        </button>
                    </h2>
                    <div id="{{'a'. $s->id_saldo}}" class="accordion-collapse collapse" aria-labelledby="{{'c'. $s->id_saldo}}"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            Dessert ice cream donut oat cake jelly-o pie sugar plum cheesecake. Bear claw dragée oat cake
                            dragée ice
                            cream halvah tootsie roll. Danish cake oat cake pie macaroon tart donut gummies. Jelly beans
                            candy canes
                            carrot cake. Fruitcake chocolate chupa chups.
                        </div>
                    </div>
                </div>
            @endforeach --}}
