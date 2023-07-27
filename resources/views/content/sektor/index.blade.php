@extends('layouts/contentNavbarLayout')

@section('title', 'Data Sektor')

@section('content')

    {{-- <div class="container"> --}}
    <h4 class="fw-bold py-3 mb-4">
        List Sektor
    </h4>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">

                    <div class="col mt-2 d-grid mx-auto">
                        <a href="{{ route('sektor-tbh') }}" class="btn btn-primary">Tambah Sektor</a>
                    </div>
                    {{-- <div class="col mt-2 d-grid mx-auto">
                                <a href=" " target="_blank" class="btn btn-success">Print</a>
                            </div> --}}
                </div>

                <dir class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead class="table-light">
                                <tr>
                                    <th>NO</th>
                                    <th>Nama Sektor</th>
                                    <th>Tim</th>
                                    <th>Job</th>
                                    <th>Tambah Tim</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($sektor as $s)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $s->sektor }}</td>
                                        <td>
                                            @foreach ($s->teamlist as $index => $tl)
                                                {{ $tl->list_tim }}
                                                @foreach ($teamdetail as $index => $td)
                                                    @if ($tl->id == $td->id_team)
                                                        {{ $td->karyawan->nama }}
                                                        @if ($index % 2 !== 0)
                                                            <br>
                                                        @else
                                                            -
                                                        @endif
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($s->teamlist as $index => $tl)
                                                @foreach ($teamdetail as $index => $td)
                                                    @if ($tl->id == $td->id_team)
                                                        @if ($index % 2 === 0)
                                                            Teknisi {{ $td->jobdesk->jenistiket->nama_tiket }}
                                                            <br>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        </td>
                                        <td>
                                            <a href="{{ route('sektor-edt', $s->id) }}" class="btn btn-sm btn-warning"
                                                title="Tambah Tim"><span class="bx bxs-user-plus"></span></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </dir>
            </div>
        </div>
    </div>
    </div>
    {{-- </div> --}}
@endsection
