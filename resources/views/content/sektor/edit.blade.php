@extends('layouts/contentNavbarLayout')

@section('title', 'Tambah Tim')

@section('content')

    {{-- <div class="container"> --}}
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('lm') }}" class="text-reset fw-bold">
                Data Material/</a></span> Input Data Sektor</h4>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    {{-- <h5 class="mb-0">Basic Layout</h5> <small class="text-muted float-end">Default label</small> --}}
                </div>
                <div class="card-body">
                    <form action="{{ route('sektor-up', $sektor->id) }}" method="POST"class="form-item">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Nama Sektor</label>
                            <div class="col-sm-10 mb-2">
                                <input type="text" class="form-control" readonly id="basic-default-name"
                                    placeholder="Masukkan Sektor Baru" value="{{ $sektor->sektor }}">
                                <input type="text" hidden class="form-control" name='sektor' readonly
                                    id="basic-default-name" placeholder="Masukkan Sektor Baru" value="{{ $sektor->id }}">
                            </div>
                        </div>
                        @forelse ($sektor->teamlist as $i => $sl)
                            {{-- @if ($i % 2 === 0) --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label" for="basic-default-name">Tim</label>
                                    <div class="col-md-9 col-8 mb-2">
                                        <select name="id_tim[]" id="id_team" class="form-control">
                                            <option value="" disabled selected>--Pilih Nama Tim--</option>
                                            @php
                                                $t = 0;
                                            @endphp
                                            @foreach ($teamlist as $tl)
                                                <option value="{{ $tl->id }}"
                                                    {{ $tl->id == $sl->id ? 'selected' : '' }}>
                                                    {{ $tl->list_tim }}&nbsp;&nbsp;
                                                    @foreach ($teamdetail as $index => $td)
                                                        @if ($tl->id == $td->id_team)
                                                            {{ $td->karyawan->nama }}
                                                            @if ($index % 2 === 0)
                                                                -
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                </option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="col-auto">
                                        <button type="button" class="hapus btn btn-info">Hapus</button>
                                    </div>


                                </div>
                            {{-- @endif --}}
                        @empty
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Tim</label>
                            <div class="col-md-9 col-8 mb-2">
                                <select name="id_tim[]" id="id_team" class="form-control">
                                    <option value="" disabled selected>--Pilih Nama Tim--</option>
                                    @php
                                        $t = 0;
                                    @endphp
                                     @foreach ($teamlist as $tl)
                                     <option value="{{ $tl->id }}">
                                         {{ $tl->list_tim }}&nbsp;&nbsp;
                                         @foreach ($teamdetail as $index => $td)
                                             @if ($tl->id == $td->id_team)
                                                 {{ $td->karyawan->nama }}
                                                 @if ($index % 2 === 0)
                                                     -
                                                 @endif
                                             @endif
                                         @endforeach
                                     </option>
                                 @endforeach
                                </select>

                            </div>
                            <div class="col-auto">
                                <button type="button" class="hapus btn btn-info">Hapus</button>
                            </div>
                        </div>
                        @endforelse

                        <div class="sektor"></div>

                        <div class="row justify-content-end">
                            <div class="col-sm-10 gap-3 d-flex">
                                <button type="button" class="addsektor btn btn-info">Tambah Tim</button>
                                <button type="submit" class="btn btn-info" name="simpan">Simpan</button>
                                <a href="{{ route('sektor') }}" class="btn btn-outline-danger ">Batal</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
        $('.addsektor').on('click', function() {
            addsektor();
        });

        function addsektor() {
            // ++i;
            var sektor =
                ' <div class="row mb-3"> <label class="col-sm-2 col-form-label" for="basic-default-name">Tim</label><div class="col-md-9 col-8 mb-2"><select name="id_tim[]" id="id_team" class="form-control"><option value="" disabled selected>--Pilih Nama Tim--</option> @php$t = 0; @endphp @foreach ($teamlist as $tl)<option value="{{ $tl->id }}">{{ $tl->list_tim }}&nbsp;&nbsp; @foreach ($teamdetail as $index => $td)@if ($tl->id == $td->id_team){{ $td->karyawan->nama }}@if ($index % 2 === 0)-@endif @endif @endforeach</option>@endforeach</select></div><div class="col-auto"><button type="button" class="hapus btn btn-info">Hapus</button></div></div>';

            $('.sektor').append(sektor);
        };
        $('.hapus').live('click', function() {
            $(this).parent().parent().remove();
        });
    </script>
    {{-- </div> --}}
@endsection
