<?php

namespace App\Http\Controllers;

use App\Models\Beritaacara;
use App\Models\saldomaterial;
use App\Models\Jenistiket;
use App\Models\Lmaterial as mtr;
use App\Models\Lmaterial;
use App\Models\Teamdetail;
use App\Models\Teamlist;
use App\Models\Tiketlist;
use App\Models\Tikettim;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use PDF;

class TikettimController extends Controller
{
    public function index(Request $request)
    {
        $bln = '06';
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        if (auth()->user()->jobdesk->jobdesk == "Teknisi") {
            $team = auth()->user()->teamdetail->teamlist->list_tim;

            $teamdetail = Teamdetail::all();
            $teamlist = Teamlist::all();
            $jenistiket = Jenistiket::all();

            $tiktim = Tikettim::with(['teamdetail'])->where(function ($query) use ($bln) {
                $query->whereMonth('created_at', $bln);
            })->whereHas('teamdetail', function ($query) use ($team) {
                $query->whereHas('teamlist', function ($query) use ($team) {
                    $query->where('list_tim', $team);
                });
            })->filter(request(['search', 'bulan', 'tahun']))->orderBy('created_at', 'DESC')->get();
            return view('content.tiket-team.index', compact('tiktim', 'teamlist', 'jenistiket', 'teamdetail', 'tglnow'));
        }
        $teamdetail = Teamdetail::all();
        $teamlist = Teamlist::all();
        $jenistiket = Jenistiket::all();
        $tiktim = Tikettim::orderBy('id_teknisi', 'ASC')->filter(request(['search', 'bulan', 'tahun', 'team', 'jtiket']))->orderBy('created_at', 'desc')->get();
        return view('content.tiket-team.index', compact('tiktim', 'teamlist', 'jenistiket', 'teamdetail', 'tglnow'));
    }

    public function create()
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $bln = date('m');
        $jenistiket = Jenistiket::all();
        $material = mtr::all();
        $id_tim = auth()->user()->teamdetail->teamlist->id;

        // dd($id_tim);

        if (auth()->user()->jobdesk->jobdesk == "Teknisi") {

            $tiket = auth()->user()->jobdesk->detail_kerja;
            $teamdetail = Teamdetail::with(['teamlist'])->orderBy('id_team', 'ASC')->get();

            $tiketlist = Tiketlist::with(['jenistiket'])->where(function ($query) use ($bln) {
                $query->whereMonth('created_at', $bln);
            })->whereHas('jenistiket', function ($query) use ($tiket) {
                $query->where('nama_tiket', 'LIKE', '%' . $tiket . '%');
            })->get();

            $team = auth()->user()->teamdetail->teamlist->list_tim;

            $sm = saldomaterial::all();

            $berita = Beritaacara::with(['teamdetail', 'saldomaterial'])->where(function ($query) use ($bln) {
                $query->whereMonth('created_at', $bln);
            })->whereHas('teamdetail', function ($query) use ($team) {
                $query->whereHas('teamlist', function ($query) use ($team) {
                    $query->where('list_tim', $team);
                });
            })->get();

            $saldo = saldomaterial::where(function ($query) use ($bln) {
                $query->whereMonth('created_at', $bln);
            })->whereHas('ba', function ($query) use ($team) {
                    $query->whereHas('teamdetail', function ($query) use ($team) {
                        $query->whereHas('teamlist', function ($query) use ($team) {
                            $query->where('list_tim', $team);
                        });
                    });
                })->orwhereHas('tikettim', function ($query) use ($team) {
                $query->whereHas('teamdetail', function ($query) use ($team) {
                    $query->whereHas('teamlist', function ($query) use ($team) {
                        $query->where('list_tim', $team);
                    });
                });
            })->where(function ($query) use ($bln) {
                $query->whereMonth('created_at', $bln);
            })->select('id_material', DB::raw('SUM(jumlah - digunakan) as total_jumlah'))->groupBy('id_material')->get();
            // foreach ($berita as $idb){
            //

            return view('content.tiket-team.create', compact('material', 'saldo', 'jenistiket', 'teamdetail', 'tiketlist', 'tglnow'));
        }
        $teamdetail = Teamdetail::with(['teamlist'])->orderBy('id_team', 'ASC')->get();
        $tiketlist = Tiketlist::where(function ($query) use ($bln) {
            $query->whereMonth('updated_at', $bln);
        })->with(['jenistiket'])->orderBy('id_j_tiket', 'ASC')->get();
        return view('content.tiket-team.create', compact('material', 'jenistiket', 'teamdetail', 'tiketlist', 'tglnow'));
    }

    public function print(Request $req)
    {
        $jtiket = $req->jtiket;
        $bln = $req->bulan;
        $tik = Tikettim::orderBy('id_teknisi', 'ASC')->filter(request(['search', 'bulan', 'tahun', 'jtiket']));
        $tiktim = $tik->get();

        $req->validate([
            'jtiket' => ['required'],
            'bulan' => ['required'],
        ]);

        if ($jtiket == "Gangguan") {

            $hitung = Teamlist::withCount(['tikettims' => function (Builder $query) use ($jtiket, $bln) {
                $query->whereHas('teamdetail', function ($query) use ($jtiket) {
                    $query->whereHas('jobdesk', function ($query) use ($jtiket) {
                        $query->where('detail_kerja', $jtiket);
                    });
                })->whereMonth('created_at', $bln);
            }])->get();

            $pdfname = 'Laporan Tiket Gangguan.pdf';
            $name = 'Laporan Tiket Gangguan';
            $pdf = PDF::loadview('content.tiket-team.print', ['tiktim' => $tiktim, 'pdfname' => $name, 'hitung' => $hitung])->setPaper('A4', 'landscape');
            return $pdf->stream($pdfname);
        } elseif ($jtiket == "Pasang Baru") {

            $hitung = Teamlist::withCount(['tikettims' => function (Builder $query) use ($jtiket, $bln) {
                $query->whereHas('teamdetail', function ($query) use ($jtiket) {
                    $query->whereHas('jobdesk', function ($query) use ($jtiket) {
                        $query->where('detail_kerja', $jtiket);
                    });
                })->whereMonth('created_at', $bln);
            }])->get();

            $pdfname = 'Laporan Tiket Pasang Baru.pdf';
            $name = 'Laporan Tiket Pasang Baru';
            $pdf = PDF::loadview('content.tiket-team.print', ['tiktim' => $tiktim, 'pdfname' => $name, 'hitung' => $hitung])->setPaper('A4', 'landscape');
            return $pdf->stream($pdfname);
        } elseif ($jtiket == "Maintenance") {

            $hitung = Teamlist::withCount(['tikettims' => function (Builder $query) use ($jtiket, $bln) {
                $query->whereHas('teamdetail', function ($query) use ($jtiket) {
                    $query->whereHas('jobdesk', function ($query) use ($jtiket) {
                        $query->where('detail_kerja', $jtiket);
                    });
                })->whereMonth('created_at', $bln);
            }])->get();

            $pdfname = 'Laporan Tiket Maintenance.pdf';
            $name = 'Laporan Tiket Maintenance';
            $pdf = PDF::loadview('content.tiket-team.print', ['tiktim' => $tiktim, 'pdfname' => $name, 'hitung' => $hitung])->setPaper('A4', 'landscape');
            return $pdf->stream($pdfname);
        } else {

            $hitung = Teamlist::withCount(['tikettims' => function (Builder $query) use ($bln) {
                $query->whereMonth('created_at', $bln);
            }])->get();
            // $hitung = Teamlist::withCount(['tikettims'])->get();
            $pdfname = 'Laporan Seluruh Tiket.pdf';
            $name = 'Laporan Seluruh Tiket';
            $pdf = PDF::loadview('content.tiket-team.print', ['tiktim' => $tiktim, 'pdfname' => $name, 'hitung' => $hitung])->setPaper('A4', 'landscape');
            return $pdf->stream($pdfname);
        }
    }

    public function store(Request $request)
    {
        $jmlcek = $request->jumlah[0];
        $data = $request->all();
        $status = 'Belum di Cek';
        $id = $request->id_teknisi;
        $id_tim = Teamdetail::where('id', $id)->value('id_team');
        $tiktim = Tikettim::max('id');
        $id_tiktim = $tiktim + 1;

        dd($id_tim);

        $noTiket = $request->id_tiket;
        $cekNo = Tikettim::where('id_tiket', $noTiket)->get();
        $hitung = $cekNo->count();

        if ($hitung > 0) {
            return redirect()->route('tbh.tiket')->with('error', 'No Tiket Sudah Terdaftar');
        }

        if ($jmlcek != null) {
            $request->validate([
                'no_tiket' => 'required',
                'nama_pic' => 'required',
                'no_pic' => 'required',
                'alamat' => 'required',
                'ket' => 'required',
                'kordinat' => 'required',
                'id_material' => 'required',
                'f_lokasi' => 'required|image',
                'f_progress' => 'required|image',
                'f_lap_tele' => 'required|image',
            ]);

            // dd($data['id_material']);

            $f_lok = $request->f_lokasi;
            $f_prog = $request->f_progress;
            $f_tele = $request->f_lap_tele;

            $name_lok = Str::slug($f_lok->getClientOriginalName());
            $name_prg = Str::slug($f_prog->getClientOriginalName());
            $name_tele = Str::slug($f_tele->getClientOriginalName());

            $g_lok = time() . '_' . $name_lok;
            $g_prg = time() . '_' . $name_prg;
            $g_tele = time() . '_' . $name_tele;

            $f_lok->move('uploads/lokasi/', $g_lok);
            $f_prog->move('uploads/progress/', $g_prg);
            $f_tele->move('uploads/telegram/', $g_tele);

            Tikettim::create([
                'id' => $id_tiktim,
                'id_teknisi' => $request->id_teknisi,
                'id_tim' => $id_tim,
                'id_j_tiket' => $request->id_j_tiket,
                'no_tiket' => $request->no_tiket,
                'nama_pic' => $request->nama_pic,
                'no_pic' => $request->no_pic,
                'alamat' => $request->alamat,
                'ket' => $request->ket,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'status' => $status,
                'f_lokasi' => 'uploads/lokasi/' . $g_lok,
                'f_progress' => 'uploads/progress/' . $g_prg,
                'f_lap_tele' => 'uploads/telegram/' . $g_tele,
            ]);

            if (count($data['id_material']) > 0) {
                foreach ($data['id_material'] as $item => $value) {
                    $data2 = array(
                        'id_material' => $data['id_material'][$item],
                        'id_tiket' => $id_tiktim,
                        'digunakan' => $data['jumlah'][$item],
                        'jumlah' => 0,
                        'id_tim' => $id_tim,
                    );

                    saldomaterial::create($data2);
                }
            }
        } else if ($jmlcek == null) {
            $request->validate([
                'jumlah' => 'required|integer',
                'no_tiket' => 'required',
                'nama_pic' => 'required',
                'no_pic' => 'required',
                'alamat' => 'required',
                'ket' => 'required',
                'kordinat' => 'required',
                'id_material' => 'required',
                'f_lokasi' => 'required|image',
                'f_progress' => 'required|image',
                'f_lap_tele' => 'required|image',
            ]);
        }
        return redirect('/tiket_team')->with('success', 'Data Berhasil di Tambahkan');
    }

    public function edit($id)
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $bln = date('m');
        // $saldom = saldomaterial::all();
        $material = Lmaterial::all();
        if (auth()->user()->jobdesk->jobdesk == "Teknisi") {
            $tiket = auth()->user()->jobdesk->detail_kerja;
            $team = auth()->user()->teamdetail->teamlist->list_tim;
            $tiktim = Tikettim::find($id);

            $teamdetail = Teamdetail::with(['teamlist'])->orderBy('id_team', 'ASC')->get();

            $tiketlist = Tiketlist::with(['jenistiket'])->where(function ($query) use ($bln) {
                $query->whereMonth('created_at', $bln);
            })->whereHas('jenistiket', function ($query) use ($tiket) {
                $query->where('nama_tiket', 'LIKE', '%' . $tiket . '%');
            })->get();

            $saldo = saldomaterial::where(function ($query) use ($team) {
                $query->whereHas('ba', function ($query) use ($team) {
                    $query->whereHas('teamdetail', function ($query) use ($team) {
                        $query->whereHas('teamlist', function ($query) use ($team) {
                            $query->where('list_tim', $team);
                        });
                    });
                });
            })->orwhereHas('tikettim', function ($query) use ($team) {
                $query->whereHas('teamdetail', function ($query) use ($team) {
                    $query->whereHas('teamlist', function ($query) use ($team) {
                        $query->where('list_tim', $team);
                    });
                });
            })->where(function ($query) use ($bln) {
                $query->whereMonth('created_at', $bln);
            })->select('id_material', DB::raw('SUM(jumlah - digunakan) as total_jumlah'))->groupBy('id_material')->get();

            // return view('content.tiket-team.edit', compact('teamdetail', 'tiktim', 'tiketlist', 'tglnow'));
        }
        $teamdetail = Teamdetail::with(['teamlist'])->orderBy('id_team', 'ASC')->get();
        $tiketlist = Tiketlist::where(function ($query) use ($bln) {
            $query->whereMonth('created_at', $bln);
        })->with(['jenistiket'])->orderBy('id_j_tiket', 'ASC')->get();
        $tiktim = Tikettim::find($id);

        return view('content.tiket-team.edit', compact('material', 'saldo', 'teamdetail', 'tiketlist', 'tiktim', 'tglnow'));
    }

    public function update(Request $request, $id)
    {
        $tiktim = Tikettim::find($id);
        $idt = $request->id_teknisi;
        $id_tim = Teamdetail::where('id', $idt)->value('id_team');
        
        dd($id_tim);

        //
        $jmlcek = $request->jumlah[0];
        $data = $request->all();

        saldomaterial::where('id_tiket', $id)->delete();

        if ($jmlcek != null) {
            $request->validate([
                'no_tiket' => 'required',
                'nama_pic' => 'required',
                'no_pic' => 'required',
                'alamat' => 'required',
                'ket' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'id_material' => 'required',
            ]);

            // dd($data['id_material']);
            if ($request->hasFile('f_lokasi')) {
                File::delete(public_path($tiktim->f_lokasi));
                $f_lok = $request->f_lokasi;
                $name_lok = Str::slug($f_lok->getClientOriginalName());
                $g_lok = time() . '_' . $name_lok;
                $f_lok->move('uploads/lokasi/', $g_lok);
                $tiktim->update([
                    'f_lokasi' => 'uploads/lokasi/' . $g_lok,
                ]);
            }
            if ($request->hasFile('f_progress')) {
                File::delete(public_path($tiktim->f_progress));
                $f_prog = $request->f_progress;
                $name_prg = Str::slug($f_prog->getClientOriginalName());
                $g_prg = time() . '_' . $name_prg;
                $f_prog->move('uploads/progress/', $g_prg);
                $tiktim->update([
                    'f_progress' => 'uploads/progress/' . $g_prg,
                ]);
            }
            if ($request->hasFile('f_lap_tele')) {
                File::delete(public_path($tiktim->f_lap_tele));
                $f_tele = $request->f_lap_tele;
                $name_tele = Str::slug($f_tele->getClientOriginalName());
                $g_tele = time() . '_' . $name_tele;
                $f_tele->move('uploads/telegram/', $g_tele);
                $tiktim->update([
                    'f_lap_tele' => 'uploads/telegram/' . $g_tele,
                ]);
            }

            $tiktim->update([
                'id_teknisi' => $request->id_teknisi,
                'id_tim' => $id_tim,
                'id_j_tiket' => $request->id_j_tiket,
                'no_tiket' => $request->no_tiket,
                'nama_pic' => $request->nama_pic,
                'no_pic' => $request->no_pic,
                'alamat' => $request->alamat,
                'ket' => $request->ket,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);

            if (count($data['id_material']) > 0) {
                foreach ($data['id_material'] as $item => $value) {
                    $data2 = array(
                        'id_material' => $data['id_material'][$item],
                        'id_tiket' => $id,
                        'digunakan' => $data['jumlah'][$item],
                        'jumlah' => 0,
                        'id_tim' => $id_tim,
                    );

                    saldomaterial::create($data2);
                }
            }
            return redirect('/tiket_team');
        } else if ($jmlcek == null) {
            $request->validate([
                'jumlah' => 'required|integer',
                'no_tiket' => 'required',
                'nama_pic' => 'required',
                'no_pic' => 'required',
                'alamat' => 'required',
                'ket' => 'required',
                'kordinat' => 'required',
                'id_material' => 'required',
                'f_lokasi' => 'required|image',
                'f_progress' => 'required|image',
                'f_lap_tele' => 'required|image',
            ]);
        }
        //
        // $tiktim->update([
        //     'id_teknisi' => $id,
        //     'id_tiket' => $request->id_tiket,
        //     'id_tim' => $id_tim,
        // ]);
    }

    public function delete($id)
    {
        $tiktim = Tikettim::find($id);
        $lokasi = $tiktim->f_lokasi;
        $progress = $tiktim->f_progress;
        $tele = $tiktim->f_lap_tele;
        File::delete(public_path($lokasi));
        File::delete(public_path($progress));
        File::delete(public_path($tele));
        $tiktim->delete();
        return redirect('tiket_team');
    }
}
