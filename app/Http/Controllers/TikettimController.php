<?php

namespace App\Http\Controllers;

use App\Models\Beritaacara;
use App\Models\Ggnpenyebab;
use App\Models\Ggntiket;
use App\Models\historyrev;
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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use PDF;

class TikettimController extends Controller
{
    public function index(Request $req)
    {
        $bln = date('m');

        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        if (auth()->user()->jobdesk->jobdesk == "Teknisi") {
            $team = auth()->user()->teamdetail->teamlist->list_tim;

            $teamdetail = Teamdetail::all();
            $teamlist = Teamlist::all();
            $jenistiket = Jenistiket::all();

            if ($req->all() == null) {
                $bulan = date('m');
                $tiktim = Tikettim::with(['ggnpenyebab'])->where(function ($query) use ($bln) {
                    $query->whereMonth('created_at', $bln);
                })->whereHas('teamdetail', function ($query) use ($team) {
                    $query->whereHas('teamlist', function ($query) use ($team) {
                        $query->where('list_tim', $team);
                    });
                })->filter(request(['search', 'bulan', 'tahun']))->orderBy('created_at', 'DESC')->get();
                return view('content.tiket-team.index', compact('bulan', 'tiktim', 'teamlist', 'jenistiket', 'teamdetail', 'tglnow'));
            } elseif ($req->all() != null) {
                $bulan = $req->bulan;
                $tiktim = Tikettim::with(['ggnpenyebab'])->whereHas('teamdetail', function ($query) use ($team) {
                    $query->whereHas('teamlist', function ($query) use ($team) {
                        $query->where('list_tim', $team);
                    });
                })->filter(request(['search', 'bulan', 'tahun']))->orderBy('created_at', 'DESC')->get();
                return view('content.tiket-team.index', compact('bulan', 'tiktim', 'teamlist', 'jenistiket', 'teamdetail', 'tglnow'));
            }
        }
        $teamdetail = Teamdetail::all();
        $teamlist = Teamlist::all();
        $jenistiket = Jenistiket::all();
        $tiktim = Tikettim::orderBy('id_tim', 'ASC')->filter(request(['search', 'bulan', 'tahun', 'team', 'jtiket']))->orderBy('created_at', 'desc')->get();
        return view('content.tiket-team.index', compact('tiktim', 'teamlist', 'jenistiket', 'teamdetail', 'tglnow'));
    }

    public function index_psb(Request $req)
    {
        $bln = date('m');
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $teamdetail = Teamdetail::all();
        $teamlist = Teamlist::all();
        $jenistiket = Jenistiket::all();
        if ($req->all() == null) {
            $tiktim = Tikettim::orderBy('id_tim', 'ASC')->whereMonth('updated_at', $bln)->where('id_j_tiket', 2)->where('status', 'Approved')->filter(request(['search', 'bulan', 'tahun', 'team']))->orderBy('created_at', 'desc')->get();
            return view('content.tiket-team.index-psb', compact('tiktim', 'teamlist', 'jenistiket', 'teamdetail', 'tglnow'));
        } elseif ($req->all() != null) {
            $tiktim = Tikettim::orderBy('id_tim', 'ASC')->where('id_j_tiket', 2)->where('status', 'Approved')->filter(request(['search', 'bulan', 'tahun', 'team']))->orderBy('created_at', 'desc')->get();
            return view('content.tiket-team.index-psb', compact('tiktim', 'teamlist', 'jenistiket', 'teamdetail', 'tglnow'));
        }
        $tiktim = Tikettim::orderBy('id_teknisi', 'ASC')->where('id_j_tiket', 2)->where('status', 'Approved')->filter(request(['search', 'bulan', 'tahun', 'team']))->orderBy('created_at', 'desc')->get();
        return view('content.tiket-team.index-psb', compact('tiktim', 'teamlist', 'jenistiket', 'teamdetail', 'tglnow'));
    }

    public function index_ggn(Request $req)
    {
        $bln = date('m');
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $teamdetail = Teamdetail::all();
        $teamlist = Teamlist::all();
        $jenistiket = Jenistiket::all();
        if ($req->all() == null) {
            $tiktim = Tikettim::orderBy('id_tim', 'ASC')->whereMonth('updated_at', $bln)->where('id_j_tiket', 1)->filter(request(['search', 'bulan', 'tahun']))->orderBy('created_at', 'desc')->get();
            return view('content.tiket-team.index-ggn', compact('tiktim', 'teamlist', 'jenistiket', 'teamdetail', 'tglnow'));
        } elseif ($req->all() != null) {
            $tiktim = Tikettim::orderBy('id_tim', 'ASC')->where('id_j_tiket', 1)->filter(request(['search', 'bulan', 'tahun']))->orderBy('created_at', 'desc')->get();
            return view('content.tiket-team.index-ggn', compact('tiktim', 'teamlist', 'jenistiket', 'teamdetail', 'tglnow'));
        }
        $tiktim = Tikettim::orderBy('id_teknisi', 'ASC')->where('id_j_tiket', 1)->filter(request(['search', 'bulan', 'tahun']))->orderBy('created_at', 'desc')->get();
        return view('content.tiket-team.index-ggn', compact('tiktim', 'teamlist', 'jenistiket', 'teamdetail', 'tglnow'));
    }

    public function index_mtn(Request $req)
    {
        $bln = date('m');
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $teamdetail = Teamdetail::all();
        $teamlist = Teamlist::all();
        $jenistiket = Jenistiket::all();
        if ($req->all() == null) {
            $tiktim = Tikettim::orderBy('id_tim', 'ASC')->whereMonth('updated_at', $bln)->where('id_j_tiket', 3)->filter(request(['search', 'bulan', 'tahun']))->orderBy('created_at', 'desc')->get();
            return view('content.tiket-team.index-mtn', compact('tiktim', 'teamlist', 'jenistiket', 'teamdetail', 'tglnow'));
        } elseif ($req->all() != null) {
            $tiktim = Tikettim::orderBy('id_tim', 'ASC')->where('id_j_tiket', 3)->filter(request(['search', 'bulan', 'tahun']))->orderBy('created_at', 'desc')->get();
            return view('content.tiket-team.index-mtn', compact('tiktim', 'teamlist', 'jenistiket', 'teamdetail', 'tglnow'));
        }
        $tiktim = Tikettim::orderBy('id_teknisi', 'ASC')->where('id_j_tiket', 3)->filter(request(['search', 'bulan', 'tahun']))->orderBy('created_at', 'desc')->get();
        return view('content.tiket-team.index-mtn', compact('tiktim', 'teamlist', 'jenistiket', 'teamdetail', 'tglnow'));
    }

    public function create()
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $bln = date('m');
        $nickname = 'tiket';

        $jenistiket = Jenistiket::all();
        if (auth()->user()->teamdetail->jobdesk->jenistiket->id == '1') {
            $material = mtr::where('job', 'GGN')->get();
            $penyebab = Ggnpenyebab::where('job', 'GGN')->get();
        } else if (auth()->user()->teamdetail->jobdesk->jenistiket->id == '2') {
            $material = mtr::where('job', 'PSB')->get();
            $penyebab = null;
        } else if (auth()->user()->teamdetail->jobdesk->jenistiket->id == '3') {
            $material = mtr::where('job', 'MTN')->get();
            $penyebab = Ggnpenyebab::where('job', 'MTN')->get();
        }
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
            })->whereHas('teamlist', function ($query) use ($team) {
                $query->where('list_tim', $team);
            })->get();

            if (auth()->user()->teamdetail->id_jobdesk == 3) {
                $saldo = saldomaterial::where(function ($query) use ($bln) {
                    $query->whereMonth('created_at', $bln);
                })->whereHas('ba', function ($query) use ($team) {
                    $query->whereHas('teamlist', function ($query) use ($team) {
                        $query->where('list_tim', $team);
                    });
                })->orwhereHas('tikettim', function ($query) use ($team) {
                    $query->whereHas('teamlist', function ($query) use ($team) {
                        $query->where('list_tim', $team);
                    });
                })->where(function ($query) use ($bln) {
                    $query->whereMonth('created_at', $bln);
                })->select('id_material', DB::raw('SUM(jumlah - digunakan) as total_jumlah'))->groupBy('id_material')->get();
                // foreach ($berita as $idb){
            } else {
                $saldo = saldomaterial::whereHas('ba', function ($query) use ($team) {
                    $query->whereHas('teamlist', function ($query) use ($team) {
                        $query->where('list_tim', $team);
                    });
                })->orwhereHas('tikettim', function ($query) use ($team) {
                    $query->whereHas('teamlist', function ($query) use ($team) {
                        $query->where('list_tim', $team);
                    });
                })->select('id_material', DB::raw('SUM(jumlah - digunakan) as total_jumlah'))->groupBy('id_material')->get();
            }

            return view('content.tiket-team.create', compact('material', 'penyebab', 'saldo', 'jenistiket', 'teamdetail', 'tiketlist', 'tglnow'));
        }
        $teamdetail = Teamdetail::with(['teamlist'])->orderBy('id_team', 'ASC')->get();
        $tiketlist = Tiketlist::where(function ($query) use ($bln) {
            $query->whereMonth('updated_at', $bln);
        })->with(['jenistiket'])->orderBy('id_j_tiket', 'ASC')->get();
        return view('content.tiket-team.create', compact('nickname', 'material', 'penyebab', 'jenistiket', 'teamdetail', 'tiketlist', 'tglnow'));
    }

    public function print_psb(Request $req)
    {
        $jtiket = 2;
        $bln = $req->bulan;
        if ($bln == 1) {
            $carbon = "Januari";
        } else if ($bln == 2) {
            $carbon = "Februari";
        } else if ($bln == 3) {
            $carbon = "Maret";
        } else if ($bln == 4) {
            $carbon = "April";
        } else if ($bln == 5) {
            $carbon = "Mei";
        } else if ($bln == 6) {
            $carbon = "Juni";
        } else if ($bln == 7) {
            $carbon = "Juli";
        } else if ($bln == 8) {
            $carbon = "Agustus";
        } else if ($bln == 9) {
            $carbon = "September";
        } else if ($bln == 10) {
            $carbon = "Oktober";
        } else if ($bln == 11) {
            $carbon = "November";
        } else if ($bln == 12) {
            $carbon = "Desember";
        }
        $tik = Tikettim::orderBy('id_teknisi', 'ASC')->where('id_j_tiket', $jtiket)->filter(request(['search', 'bulan', 'tahun', 'jtiket']));
        $tiktim = $tik->get();
        $hitung = Teamlist::withCount(['tikettims' => function (Builder $query) use ($jtiket, $bln) {
            $query->whereHas('teamdetail', function ($query) use ($jtiket) {
                $query->whereHas('jobdesk', function ($query) use ($jtiket) {
                    $query->where('detail_kerja', $jtiket);
                });
            })->where('status', 'Approved')->whereMonth('created_at', $bln);
        }])->get();

        $pdfname = 'Laporan Tiket Pasang Baru-' . $carbon . '.pdf';
        $name = 'Laporan Tiket Pasang Baru';
        $pdf = PDF::loadview('content.tiket-team.print', ['tiktim' => $tiktim, 'pdfname' => $name, 'hitung' => $hitung])->setPaper('A4', 'landscape');
        return $pdf->stream($pdfname);
    }

    public function print_ggn(Request $req)
    {
        $jtiket = 1;
        $bln = $req->bulan;

        if ($bln == 1) {
            $carbon = "Januari";
        } else if ($bln == 2) {
            $carbon = "Februari";
        } else if ($bln == 3) {
            $carbon = "Maret";
        } else if ($bln == 4) {
            $carbon = "April";
        } else if ($bln == 5) {
            $carbon = "Mei";
        } else if ($bln == 6) {
            $carbon = "Juni";
        } else if ($bln == 7) {
            $carbon = "Juli";
        } else if ($bln == 8) {
            $carbon = "Agustus";
        } else if ($bln == 9) {
            $carbon = "September";
        } else if ($bln == 10) {
            $carbon = "Oktober";
        } else if ($bln == 11) {
            $carbon = "November";
        } else if ($bln == 12) {
            $carbon = "Desember";
        }

        $tik = Tikettim::orderBy('id_teknisi', 'ASC')->where('id_j_tiket', $jtiket)->filter(request(['search', 'bulan', 'tahun', 'jtiket']));
        $tiktim = $tik->get();
        $hitung = Teamlist::withCount(['tikettims' => function (Builder $query) use ($jtiket, $bln) {
            $query->whereHas('teamdetail', function ($query) use ($jtiket) {
                $query->whereHas('jobdesk', function ($query) use ($jtiket) {
                    $query->where('detail_kerja', $jtiket);
                });
            });
        }])->get();

        $pdfname = 'Laporan Tiket Gangguan-' . $carbon . '.pdf';
        $name = 'Laporan Tiket Gangguan';
        $pdf = PDF::loadview('content.tiket-team.print-ggn', ['tiktim' => $tiktim, 'pdfname' => $name, 'hitung' => $hitung])->setPaper('A4', 'landscape');
        return $pdf->stream($pdfname);
    }

    public function print_mtn(Request $req)
    {
        $jtiket = 3;
        $bln = $req->bulan;
        if ($bln == 1) {
            $carbon = "Januari";
        } else if ($bln == 2) {
            $carbon = "Februari";
        } else if ($bln == 3) {
            $carbon = "Maret";
        } else if ($bln == 4) {
            $carbon = "April";
        } else if ($bln == 5) {
            $carbon = "Mei";
        } else if ($bln == 6) {
            $carbon = "Juni";
        } else if ($bln == 7) {
            $carbon = "Juli";
        } else if ($bln == 8) {
            $carbon = "Agustus";
        } else if ($bln == 9) {
            $carbon = "September";
        } else if ($bln == 10) {
            $carbon = "Oktober";
        } else if ($bln == 11) {
            $carbon = "November";
        } else if ($bln == 12) {
            $carbon = "Desember";
        }
        $tik = Tikettim::orderBy('id_teknisi', 'ASC')->where('id_j_tiket', $jtiket)->filter(request(['search', 'bulan', 'tahun', 'jtiket']));
        $tiktim = $tik->get();
        $hitung = Teamlist::withCount(['tikettims' => function (Builder $query) use ($jtiket, $bln) {
            $query->whereHas('teamdetail', function ($query) use ($jtiket) {
                $query->whereHas('jobdesk', function ($query) use ($jtiket) {
                    $query->where('detail_kerja', $jtiket);
                });
            });
        }])->get();

        $pdfname = 'Laporan Tiket Maintenance-' . $carbon . '.pdf';
        $name = 'Laporan Tiket Maintenance';
        $pdf = PDF::loadview('content.tiket-team.print-mtn', ['tiktim' => $tiktim, 'pdfname' => $name, 'hitung' => $hitung])->setPaper('A4', 'landscape');
        return $pdf->stream($pdfname);
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
        $bln = date('m');
        $jmlcek = $request->jumlah[0];
        $data = $request->all();
        $status = 'Belum di Cek';
        $id = $request->id_teknisi;
        $id_tim = auth()->user()->teamdetail->teamlist->id;
        $tiktim = Tikettim::max('id');
        $id_tiktim = $tiktim + 1;
        $jt = auth()->user()->teamdetail->jobdesk->jenistiket->id;

        if (auth()->user()->teamdetail->id_jobdesk == 3) {
            $saldotim = saldomaterial::where(function ($query) use ($id_tim) {
                $query->where('id_tim', $id_tim);
            })->where(function ($query) use ($bln) {
                $query->whereMonth('created_at', $bln);
            })->select('id_tim', 'id_material', DB::raw('SUM(jumlah - digunakan) as total_jumlah,  SUM(jumlah) as jumlah, SUM(digunakan) as guna'))->groupBy('id_material', 'id_tim')->get();

            foreach ($data['id_material'] as $item => $value) {
                foreach ($saldotim as $s) {
                    if ($s->id_material == $data['id_material'][$item] and $s->total_jumlah < $data['jumlah'][$item]) {
                        $sa = $s->id_material;
                        $tanggal = $s->created_at;
                        $material = Lmaterial::where('id', $sa)->pluck('nama_material');
                        return redirect()->route('tbh.tiket', [$id, $bln])->with('error', '' . $material[0] . 'Melebili Sisa Material');
                    }
                }
            }
        } else {
            $saldotim = saldomaterial::where(function ($query) use ($id_tim) {
                $query->where('id_tim', $id_tim);
            })->select('id_tim', 'id_material', DB::raw('SUM(jumlah - digunakan) as total_jumlah,  SUM(jumlah) as jumlah, SUM(digunakan) as guna'))->groupBy('id_material', 'id_tim')->get();

            foreach ($data['id_material'] as $item => $value) {
                foreach ($saldotim as $s) {
                    if ($s->id_material == $data['id_material'][$item] and $s->total_jumlah < $data['jumlah'][$item]) {
                        $sa = $s->id_material;
                        $tanggal = $s->created_at;
                        $material = Lmaterial::where('id', $sa)->pluck('nama_material');
                        return redirect()->route('tbh.tiket', [$id, $bln])->with('error', '' . $material[0] . 'Melebili Sisa Material');
                    }
                }
            }
        }
        // dd($id_tim);

        $noTiket = $request->no_tiket;
        $cekNo = Tikettim::where('no_tiket', $noTiket)->get();
        $hitung = $cekNo->count();

        if ($hitung > 0) {
            return redirect()->route('tbh.tiket')->with('error', 'No Tiket Sudah Terdaftar');
        }

        if ($jmlcek != null) {
            if (auth()->user()->teamdetail->jobdesk->jenistiket->id == '3') {
                $request->validate([
                    'no_tiket' => 'required',
                    'nama_pic' => 'required',
                    'ket' => 'required',
                    'kordinat' => 'required',
                    'id_material' => 'required',
                    'f_lokasi' => 'required|image',
                    'f_progress' => 'required|image',
                    'f_lap_tele' => 'required|image',
                ]);
            } else {
                $request->validate([
                    'no_tiket' => 'required',
                    'no_inet' => 'required',
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

            if (auth()->user()->jobdesk->jenistiket->nama_tiket == 'Pasang Baru') {
                Tikettim::create([
                    'id' => $id_tiktim,
                    'id_teknisi' => $request->id_teknisi,
                    'id_tim' => $id_tim,
                    'id_j_tiket' => $request->id_j_tiket,
                    'no_tiket' => $request->no_tiket,
                    'no_inet' => $request->no_inet,
                    'nama_pic' => $request->nama_pic,
                    'no_pic' => $request->no_pic,
                    'alamat' => $request->alamat,
                    'ket' => $request->ket,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                    'status' => $status,
                    'ketrev' => 'Input Baru',
                    'f_lokasi' => 'uploads/lokasi/' . $g_lok,
                    'f_progress' => 'uploads/progress/' . $g_prg,
                    'f_lap_tele' => 'uploads/telegram/' . $g_tele,
                ]);
            } else if (auth()->user()->jobdesk->jenistiket->nama_tiket == 'Gangguan') {
                Tikettim::create([
                    'id' => $id_tiktim,
                    'id_teknisi' => $request->id_teknisi,
                    'id_tim' => $id_tim,
                    'id_j_tiket' => $request->id_j_tiket,
                    'no_tiket' => $request->no_tiket,
                    'no_inet' => $request->no_inet,
                    'nama_pic' => $request->nama_pic,
                    'no_pic' => $request->no_pic,
                    'alamat' => $request->alamat,
                    'ket' => $request->ket,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                    'f_lokasi' => 'uploads/lokasi/' . $g_lok,
                    'f_progress' => 'uploads/progress/' . $g_prg,
                    'f_lap_tele' => 'uploads/telegram/' . $g_tele,
                ]);

                Ggntiket::create([
                    'id_penyebab' => $request->id_ggn,
                    'id_tiket' => $id_tiktim,
                    'ket' => $request->ket_ggn
                ]);
            } else if (auth()->user()->jobdesk->jenistiket->nama_tiket == 'Maintenance') {
                Tikettim::create([
                    'id' => $id_tiktim,
                    'id_teknisi' => $request->id_teknisi,
                    'id_tim' => $id_tim,
                    'id_j_tiket' => $jt,
                    'no_tiket' => $request->no_tiket,
                    'nama_pic' => $request->nama_pic,
                    'ket' => $request->ket,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                    'f_lokasi' => 'uploads/lokasi/' . $g_lok,
                    'f_progress' => 'uploads/progress/' . $g_prg,
                    'f_lap_tele' => 'uploads/telegram/' . $g_tele,
                ]);

                Ggntiket::create([
                    'id_penyebab' => $request->id_ggn,
                    'id_tiket' => $id_tiktim,
                    'ket' => $request->ket_ggn
                ]);
            }

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

    public function edit($id, $bulan)
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $bln = $bulan;
        $buln = date('m');
        $nickname = 'tiket';
        $histrev = historyrev::where('id_tiket', $id)->get();
        $penyebab = Ggnpenyebab::all();

        if (auth()->user()->teamdetail->jobdesk->jenistiket->id == '1') {
            $material = mtr::where('job', 'GGN')->get();
        } else if (auth()->user()->teamdetail->jobdesk->jenistiket->id == '2') {
            $material = mtr::where('job', 'PSB')->get();
        } else if (auth()->user()->teamdetail->jobdesk->jenistiket->id == '3') {
            $material = mtr::where('job', 'MTN')->get();
        }
        if (auth()->user()->jobdesk->jobdesk == "Teknisi") {
            $tiket = auth()->user()->jobdesk->detail_kerja;
            $team = auth()->user()->teamdetail->teamlist->list_tim;
            $tiktim = Tikettim::find($id);

            $carbonDate = Carbon::parse($tiktim->created_at);
            $tngl = $carbonDate->format('m');

            $teamdetail = Teamdetail::with(['teamlist'])->orderBy('id_team', 'ASC')->get();

            $tiketlist = Tiketlist::with(['jenistiket'])->where(function ($query) use ($buln) {
                $query->whereMonth('created_at', $buln);
            })->whereHas('jenistiket', function ($query) use ($tiket) {
                $query->where('nama_tiket', 'LIKE', '%' . $tiket . '%');
            })->get();

            if (auth()->user()->teamdetail->id_jobdesk == 3) {
                $saldo = saldomaterial::where(function ($query) use ($bln) {
                    $query->whereMonth('created_at', $bln);
                })->whereHas('ba', function ($query) use ($team) {
                    $query->whereHas('teamlist', function ($query) use ($team) {
                        $query->where('list_tim', $team);
                    });
                })->orwhereHas('tikettim', function ($query) use ($team) {
                    $query->whereHas('teamlist', function ($query) use ($team) {
                        $query->where('list_tim', $team);
                    });
                })->where(function ($query) use ($bln) {
                    $query->whereMonth('created_at', $bln);
                })->select('id_material', DB::raw('SUM(jumlah - digunakan) as total_jumlah'))->groupBy('id_material')->get();
                // foreach ($berita as $idb){
            } else {
                $saldo = saldomaterial::whereHas('ba', function ($query) use ($team) {
                    $query->whereHas('teamlist', function ($query) use ($team) {
                        $query->where('list_tim', $team);
                    });
                })->orwhereHas('tikettim', function ($query) use ($team) {
                    $query->whereHas('teamlist', function ($query) use ($team) {
                        $query->where('list_tim', $team);
                    });
                })->select('id_material', DB::raw('SUM(jumlah - digunakan) as total_jumlah'))->groupBy('id_material')->get();
            }
            return view('content.tiket-team.edit', compact('bln', 'material', 'nickname', 'histrev', 'saldo', 'teamdetail', 'tiktim', 'tglnow', 'penyebab'));
            // return view('content.tiket-team.edit', compact('teamdetail', 'tiktim', 'tiketlist', 'tglnow'));
        }
        $teamdetail = Teamdetail::with(['teamlist'])->orderBy('id_team', 'ASC')->get();
        $tiketlist = Tiketlist::where(function ($query) use ($buln) {
            $query->whereMonth('created_at', $buln);
        })->with(['jenistiket'])->orderBy('id_j_tiket', 'ASC')->get();
        $tiktim = Tikettim::find($id);

        return view('content.tiket-team.edit', compact('material', 'nickname', 'histrev', 'saldo', 'teamdetail', 'tiketlist', 'tiktim', 'tglnow'));
    }

    public function detail(Request $req, $id)
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $bln = date('m');
        $nickname = 'tiket';
        $penyebab = Ggnpenyebab::all();
        $tiktim = Tikettim::find($id);
        $nickname = "tiket";
        // $saldom = saldomaterial::all();
        if ($tiktim->id_j_tiket == '1') {
            $title = 'Detail Data Gangguan';
            $material = mtr::where('job', 'GGN')->get();
            $penyebab = Ggnpenyebab::where('job', 'GGN')->get();
        } else if ($tiktim->id_j_tiket == '2') {
            $title = 'Detail Data Pasang Baru';
            $material = mtr::where('job', 'PSB')->get();
        } else if ($tiktim->id_j_tiket == '3') {
            $title = 'Detail Data Maintenance';
            $material = mtr::where('job', 'MTN')->get();
            $penyebab = Ggnpenyebab::where('job', 'MTN')->get();
        }

        $teamdetail = Teamdetail::with(['teamlist'])->orderBy('id_team', 'ASC')->get();
        $tiketlist = Tiketlist::where(function ($query) use ($bln) {
            $query->whereMonth('created_at', $bln);
        })->with(['jenistiket'])->orderBy('id_j_tiket', 'ASC')->get();


        $histrev = historyrev::where('id_tiket', $id)->get();

        return view('content.tiket-team.detail', compact('title', 'nickname', 'penyebab', 'histrev', 'material', 'teamdetail', 'tiketlist', 'tiktim', 'tglnow'));
    }

    public function updtl(Request $req, $id)
    {
        $tiktim = Tikettim::find($id);
        // $histrev = historyrev::all();

        $tiktim->update([
            'status' => $req->status,
            'ketrev' => $req->ketrev,
        ]);

        historyrev::create([
            'id_tiket' => $id,
            'status' => $req->status,
            'ketrev' => $req->ketrev,
        ]);

        return redirect('/psbtiket');
    }

    public function update(Request $request, $id, $bln)
    {
        $tiktim = Tikettim::find($id);
        $idt = $request->id_teknisi;
        $id_tim = auth()->user()->teamdetail->teamlist->id;

        $jmlcek = $request->jumlah[0];
        $data = $request->all();

        $tglold = Carbon::now()->subMonth()->format('Y-m-d H:i:s');
        $tglnow = Carbon::now()->format('Y-m-d H:i:s');

        $blnow = date('m');

        saldomaterial::where('id_tiket', $id)->delete();

        if (auth()->user()->teamdetail->id_jobdesk == 3) {
            $saldotim = saldomaterial::where(function ($query) use ($id_tim) {
                $query->where('id_tim', $id_tim);
            })->where(function ($query) use ($bln) {
                $query->whereMonth('created_at', $bln);
            })->select('id_tim', 'id_material', DB::raw('SUM(jumlah - digunakan) as total_jumlah,  SUM(jumlah) as jumlah, SUM(digunakan) as guna'))->groupBy('id_material', 'id_tim')->get();

            foreach ($data['id_material'] as $item => $value) {
                foreach ($saldotim as $s) {
                    if ($s->id_material == $data['id_material'][$item] and $s->total_jumlah < $data['jumlah'][$item]) {
                        $sa = $s->id_material;
                        $tanggal = $s->created_at;
                        $material = Lmaterial::where('id', $sa)->pluck('nama_material');
                        return redirect()->route('tbh.tiket', [$id, $bln])->with('error', '' . $material[0] . 'Melebili Sisa Material');
                    }
                }
            }
        } else {
            $saldotim = saldomaterial::where(function ($query) use ($id_tim) {
                $query->where('id_tim', $id_tim);
            })->select('id_tim', 'id_material', DB::raw('SUM(jumlah - digunakan) as total_jumlah,  SUM(jumlah) as jumlah, SUM(digunakan) as guna'))->groupBy('id_material', 'id_tim')->get();

            foreach ($data['id_material'] as $item => $value) {
                foreach ($saldotim as $s) {
                    if ($s->id_material == $data['id_material'][$item] and $s->total_jumlah < $data['jumlah'][$item]) {
                        $sa = $s->id_material;
                        $tanggal = $s->created_at;
                        $material = Lmaterial::where('id', $sa)->pluck('nama_material');
                        return redirect()->route('tbh.tiket', [$id, $bln])->with('error', '' . $material[0] . 'Melebili Sisa Material');
                    }
                }
            }
        }

        if (auth()->user()->jobdesk->jenistiket->nama_tiket == 'Gangguan') {
            Ggntiket::where('id_tiket', $id)->delete();
        } else if (auth()->user()->jobdesk->jenistiket->nama_tiket == 'Pasang Baru') {
            historyrev::create([
                'id_tiket' => $id,
                'status' => 'Belum di cek',
                'ketrev' => 'Revisi Selesai',
            ]);
        }

        if ($jmlcek != null) {
            $request->validate([
                'no_tiket' => 'required',
                'no_inet' => 'required',
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

            if (auth()->user()->jobdesk->jenistiket->nama_tiket == 'Pasang Baru') {
                $tiktim->update([
                    'id_teknisi' => $request->id_teknisi,
                    'id_tim' => $id_tim,
                    'id_j_tiket' => $request->id_j_tiket,
                    'no_tiket' => $request->no_tiket,
                    'nama_pic' => $request->nama_pic,
                    'no_pic' => $request->no_pic,
                    'alamat' => $request->alamat,
                    'ket' => $request->ket,
                    'status' => 'Belum di cek',
                    'ketrev' => 'Revisi Selesai',
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                ]);
            } else  if (auth()->user()->jobdesk->jenistiket->nama_tiket == 'Gangguan') {
                $tiktim->update([
                    'id_teknisi' => $request->id_teknisi,
                    'id_tim' => $id_tim,
                    'id_j_tiket' => $request->id_j_tiket,
                    'no_tiket' => $request->no_tiket,
                    'no_inet' => $request->no_inet,
                    'nama_pic' => $request->nama_pic,
                    'no_pic' => $request->no_pic,
                    'alamat' => $request->alamat,
                    'ket' => $request->ket,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                ]);

                Ggntiket::create([
                    'id_penyebab' => $request->id_ggn,
                    'id_tiket' => $id,
                    'ket' => $request->ket_ggn
                ]);
            }


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

    public function ps_banyak(Request $req)
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');

        if ($req->bulan == null) {
            $bln = date('m');
            $hitungkyg = Teamlist::withCount(['tikettims' => function ($query) use ($bln) {
                $query->whereHas('teamdetail', function ($query) {
                    $query->whereHas('jobdesk', function ($query) {
                        $query->where('detail_kerja', 2);
                    });
                })->where('status', 'Approved')->whereHas('teamlist', function ($query) {
                    $query->whereHas('sektor', function ($query) {
                        $query->where('sektor.id', 6);
                    });
                })->whereMonth('created_at', $bln);
            }])->orderBy('tikettims_count', 'DESC')->get();

            $hitungbjm = Teamlist::withCount(['tikettims' => function ($query) use ($bln) {
                $query->whereHas('teamdetail', function ($query) {
                    $query->whereHas('jobdesk', function ($query) {
                        $query->where('detail_kerja', 2);
                    });
                })->where('status', 'Approved')->whereHas('teamlist', function ($query) {
                    $query->whereHas('sektor', function ($query) {
                        $query->where('sektor.id', 7);
                    });
                })->whereMonth('created_at', $bln);
            }])->orderBy('tikettims_count', 'DESC')->get();

            $hitunguli = Teamlist::withCount(['tikettims' => function ($query) use ($bln) {
                $query->whereHas('teamdetail', function ($query) {
                    $query->whereHas('jobdesk', function ($query) {
                        $query->where('detail_kerja', 2);
                    });
                })->where('status', 'Approved')->whereHas('teamlist', function ($query) {
                    $query->whereHas('sektor', function ($query) {
                        $query->where('sektor.id', 8);
                    });
                })->whereMonth('created_at', $bln);
            }])->orderBy('tikettims_count', 'DESC')->get();

            $teamkyg = Teamlist::whereHas('sektor', function ($query) {
                $query->where('sektor.id', 6);
            })->whereHas('teamdetail', function ($query) {
                $query->whereHas('jobdesk', function ($query) {
                    $query->where('detail_kerja', 2);
                });
            })->get();

            $teambjm = Teamlist::whereHas('sektor', function ($query) {
                $query->where('sektor.id', 7);
            })->whereHas('teamdetail', function ($query) {
                $query->whereHas('jobdesk', function ($query) {
                    $query->where('detail_kerja', 2);
                });
            })->get();

            $teamuli = Teamlist::whereHas('sektor', function ($query) {
                $query->where('sektor.id', 8);
            })->whereHas('teamdetail', function ($query) {
                $query->whereHas('jobdesk', function ($query) {
                    $query->where('detail_kerja', 2);
                });
            })->get();

            // dd($team);
        } else  if ($req->bulan != null) {
            $bln = $req->bulan;
            $hitungkyg = Teamlist::withCount(['tikettims' => function ($query) use ($bln) {
                $query->whereHas('teamdetail', function ($query) {
                    $query->whereHas('jobdesk', function ($query) {
                        $query->where('detail_kerja', 2);
                    });
                })->where('status', 'Approved')->whereHas('teamlist', function ($query) {
                    $query->whereHas('sektor', function ($query) {
                        $query->where('sektor.id', 6);
                    });
                })->whereMonth('created_at', $bln);
            }])->orderBy('tikettims_count', 'DESC')->get();

            $hitungbjm = Teamlist::withCount(['tikettims' => function ($query) use ($bln) {
                $query->whereHas('teamdetail', function ($query) {
                    $query->whereHas('jobdesk', function ($query) {
                        $query->where('detail_kerja', 2);
                    });
                })->where('status', 'Approved')->whereHas('teamlist', function ($query) {
                    $query->whereHas('sektor', function ($query) {
                        $query->where('sektor.id', 7);
                    });
                })->whereMonth('created_at', $bln);
            }])->orderBy('tikettims_count', 'DESC')->get();

            $hitunguli = Teamlist::withCount(['tikettims' => function ($query) use ($bln) {
                $query->whereHas('teamdetail', function ($query) {
                    $query->whereHas('jobdesk', function ($query) {
                        $query->where('detail_kerja', 2);
                    });
                })->where('status', 'Approved')->whereHas('teamlist', function ($query) {
                    $query->whereHas('sektor', function ($query) {
                        $query->where('sektor.id', 8);
                    });
                })->whereMonth('created_at', $bln);
            }])->orderBy('tikettims_count', 'DESC')->get();

            $teamkyg = Teamlist::whereHas('sektor', function ($query) {
                $query->where('sektor.id', 6);
            })->whereHas('teamdetail', function ($query) {
                $query->whereHas('jobdesk', function ($query) {
                    $query->where('detail_kerja', 2);
                });
            })->get();

            $teambjm = Teamlist::whereHas('sektor', function ($query) {
                $query->where('sektor.id', 7);
            })->whereHas('teamdetail', function ($query) {
                $query->whereHas('jobdesk', function ($query) {
                    $query->where('detail_kerja', 2);
                });
            })->get();

            $teamuli = Teamlist::whereHas('sektor', function ($query) {
                $query->where('sektor.id', 8);
            })->whereHas('teamdetail', function ($query) {
                $query->whereHas('jobdesk', function ($query) {
                    $query->where('detail_kerja', 2);
                });
            })->get();

            // dd($team);
        }

        return view('content.report_tb.psbanyak', compact('bln', 'teambjm', 'teamuli', 'teamkyg', 'tglnow', 'hitungkyg', 'hitungbjm', 'hitunguli'));
    }

    public function printps_banyak(Request $req)
    {
        $bln = $req->bulan;

        if ($bln == 1) {
            $carbon = "Januari";
        } else if ($bln == 2) {
            $carbon = "Februari";
        } else if ($bln == 3) {
            $carbon = "Maret";
        } else if ($bln == 4) {
            $carbon = "April";
        } else if ($bln == 5) {
            $carbon = "Mei";
        } else if ($bln == 6) {
            $carbon = "Juni";
        } else if ($bln == 7) {
            $carbon = "Juli";
        } else if ($bln == 8) {
            $carbon = "Agustus";
        } else if ($bln == 9) {
            $carbon = "September";
        } else if ($bln == 10) {
            $carbon = "Oktober";
        } else if ($bln == 11) {
            $carbon = "November";
        } else if ($bln == 12) {
            $carbon = "Desember";
        }

        $hitungkyg = Teamlist::withCount(['tikettims' => function ($query) use ($bln) {
            $query->whereHas('teamdetail', function ($query) {
                $query->whereHas('jobdesk', function ($query) {
                    $query->where('detail_kerja', 2);
                });
            })->where('status', 'Approved')->whereHas('teamlist', function ($query) {
                $query->whereHas('sektor', function ($query) {
                    $query->where('sektor.id', 6);
                });
            })->whereMonth('created_at', $bln);
        }])->orderBy('tikettims_count', 'DESC')->take(3)->get();

        $hitungbjm = Teamlist::withCount(['tikettims' => function ($query) use ($bln) {
            $query->whereHas('teamdetail', function ($query) {
                $query->whereHas('jobdesk', function ($query) {
                    $query->where('detail_kerja', 2);
                });
            })->where('status', 'Approved')->whereHas('teamlist', function ($query) {
                $query->whereHas('sektor', function ($query) {
                    $query->where('sektor.id', 7);
                });
            })->whereMonth('created_at', $bln);
        }])->orderBy('tikettims_count', 'DESC')->take(3)->get();

        $hitunguli = Teamlist::withCount(['tikettims' => function ($query) use ($bln) {
            $query->whereHas('teamdetail', function ($query) {
                $query->whereHas('jobdesk', function ($query) {
                    $query->where('detail_kerja', 2);
                });
            })->where('status', 'Approved')->whereHas('teamlist', function ($query) {
                $query->whereHas('sektor', function ($query) {
                    $query->where('sektor.id', 8);
                });
            })->whereMonth('created_at', $bln);
        }])->orderBy('tikettims_count', 'DESC')->take(3)->get();

        $teamkyg = Teamlist::whereHas('sektor', function ($query) {
            $query->where('sektor.id', 6);
        })->whereHas('teamdetail', function ($query) {
            $query->whereHas('jobdesk', function ($query) {
                $query->where('detail_kerja', 2);
            });
        })->get();

        $teambjm = Teamlist::whereHas('sektor', function ($query) {
            $query->where('sektor.id', 7);
        })->whereHas('teamdetail', function ($query) {
            $query->whereHas('jobdesk', function ($query) {
                $query->where('detail_kerja', 2);
            });
        })->get();

        $teamuli = Teamlist::whereHas('sektor', function ($query) {
            $query->where('sektor.id', 8);
        })->whereHas('teamdetail', function ($query) {
            $query->whereHas('jobdesk', function ($query) {
                $query->where('detail_kerja', 2);
            });
        })->get();


        $pdfname = 'List Tim Ps-' . $carbon . '.pdf';
        $name = 'Tim Ps Terbanyak';
        $pdf = PDF::loadview('content.report_tb.printpsb', [
            'hitungkyg' => $hitungkyg,
            'hitungbjm' => $hitungbjm,
            'hitunguli' => $hitunguli,
            'pdfname' => $name,
            'bln' => $carbon,
            'teamkyg' => $teamkyg,
            'teambjm' => $teambjm,
            'teamuli' => $teamuli,
        ])->setPaper('A4', 'landscape');
        return $pdf->stream($pdfname);
    }

    public function ps_pf(Request $req)
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');

        if ($req->year == null) {
            $year = date('Y');
        } else if ($req->year != null) {
            $year = $req->year;
        }
        $perfpsb = Tikettim::select(
            DB::raw('MONTH(created_at) as month'),
            'sektor.sektor as sektor',
            DB::raw('COUNT(*) as count')
        )
            ->join('teamdetail', 'tiket_tim.id_teknisi', '=', 'teamdetail.id_karyawan')
            ->join('teamlist', 'teamdetail.id_team', '=', 'teamlist.id')
            ->join('sektor_tim', 'teamlist.id', '=', 'sektor_tim.id_tim')
            ->join('sektor', 'sektor_tim.id_sektor', '=', 'sektor.id')
            ->whereYear('created_at', $year)
            ->where('id_j_tiket', 2)
            ->where('status', 'Approved')
            ->groupBy('month', 'sektor')
            ->orderBy('month', 'asc')
            ->get();

        $blan = Tikettim::whereYear('created_at', $year)->select(DB::raw('MONTH(created_at) as month'))->groupBy('month')->get();

        $totalpsb = Tikettim::whereYear('created_at', $year)->where('id_j_tiket', 2)->where('status', 'Approved')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))->groupBy('month')->get();

        // dd($totalpsb);

        return view('content.report_tb.perf', compact('tglnow', 'perfpsb', 'totalpsb', 'blan'));
    }

    public function print_pf(Request $req)
    {
        $year = $req->year;

        $perfpsb = Tikettim::select(
            DB::raw('MONTH(created_at) as month'),
            'sektor.sektor as sektor',
            DB::raw('COUNT(*) as count')
        )
            ->join('teamdetail', 'tiket_tim.id_teknisi', '=', 'teamdetail.id_karyawan')
            ->join('teamlist', 'teamdetail.id_team', '=', 'teamlist.id')
            ->join('sektor_tim', 'teamlist.id', '=', 'sektor_tim.id_tim')
            ->join('sektor', 'sektor_tim.id_sektor', '=', 'sektor.id')
            ->whereYear('created_at', $year)
            ->where('id_j_tiket', 2)
            ->where('status', 'Approved')
            ->groupBy('month', 'sektor')
            ->orderBy('month', 'asc')
            ->get();

        $blan = Tikettim::whereYear('created_at', $year)->select(DB::raw('MONTH(created_at) as month'))->groupBy('month')->get();

        $totalpsb = Tikettim::whereYear('created_at', $year)->where('id_j_tiket', 2)->where('status', 'Approved')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))->groupBy('month')->get();

        $pdfname = 'Total Pemasangan Tahun ' . $year . '.pdf';
        $name = 'Total Pemasangan Tahun ' . $year;
        $pdf = PDF::loadview('content.report_tb.printperf', [
            'perfpsb' => $perfpsb,
            'blan' => $blan,
            'totalpsb' => $totalpsb,
            'pdfname' => $name,
            'year' => $year
        ])->setPaper('A4', 'potrait');
        return $pdf->stream($pdfname);
    }

    public function ggn_penyebab(Request $req)
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');

        if ($req->year == null) {
            $year = date('Y');
            $bln = date('m');
        } else if ($req->year != null) {
            $year = $req->year;
            $bln = $req->bulan;
        }

        $perfpsb = Tikettim::select(
            DB::raw('MONTH(created_at) as month'),
            'sektor.sektor as sektor',
            'ggn_penyebab.penyebab as penyebab',
            DB::raw('COUNT(*) as count')
        )
            ->join('teamdetail', 'tiket_tim.id_teknisi', '=', 'teamdetail.id_karyawan')
            ->join('teamlist', 'teamdetail.id_team', '=', 'teamlist.id')
            ->join('sektor_tim', 'teamlist.id', '=', 'sektor_tim.id_tim')
            ->join('sektor', 'sektor_tim.id_sektor', '=', 'sektor.id')
            ->join('ggn_tiket', 'tiket_tim.id', '=', 'ggn_tiket.id_tiket')
            ->join('ggn_penyebab', 'ggn_tiket.id_penyebab', '=', 'ggn_penyebab.id')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $bln)
            ->where('id_j_tiket', 1)
            ->groupBy('month', 'sektor', 'penyebab')
            ->orderBy('month', 'asc')
            ->get();

        // dd($perfpsb);

        $totalkyg = Tikettim::whereYear('created_at', $year)->whereMonth('created_at', $bln)
            ->whereHas('teamlist', function ($query) {
                $query->whereHas('sektor', function ($query) {
                    $query->where('sektor.id', 6);
                });
            })->where('id_j_tiket', 1)
            ->count();

        $totalbjm = Tikettim::whereYear('created_at', $year)->whereMonth('created_at', $bln)
            ->whereHas('teamlist', function ($query) {
                $query->whereHas('sektor', function ($query) {
                    $query->where('sektor.id', 7);
                });
            })->where('id_j_tiket', 1)
            ->count();

        $totaluli = Tikettim::whereYear('created_at', $year)->whereMonth('created_at', $bln)
            ->whereHas('teamlist', function ($query) {
                $query->whereHas('sektor', function ($query) {
                    $query->where('sektor.id', 8);
                });
            })->where('id_j_tiket', 1)
            ->count();

        return view('content.report_tb.gp', compact('tglnow', 'bln', 'perfpsb', 'totalkyg', 'totalbjm', 'totaluli'));
    }

    public function print_gp(Request $req)
    {
        
        if ($req->input('buttonType') === 'bulanan') {
            $year = $req->year;
            $bln = $req->bulan;

            if ($bln == 1) {
                $carbon = "Januari";
            } else if ($bln == 2) {
                $carbon = "Februari";
            } else if ($bln == 3) {
                $carbon = "Maret";
            } else if ($bln == 4) {
                $carbon = "April";
            } else if ($bln == 5) {
                $carbon = "Mei";
            } else if ($bln == 6) {
                $carbon = "Juni";
            } else if ($bln == 7) {
                $carbon = "Juli";
            } else if ($bln == 8) {
                $carbon = "Agustus";
            } else if ($bln == 9) {
                $carbon = "September";
            } else if ($bln == 10) {
                $carbon = "Oktober";
            } else if ($bln == 11) {
                $carbon = "November";
            } else if ($bln == 12) {
                $carbon = "Desember";
            }

            $perfpsb = Tikettim::select(
                DB::raw('MONTH(created_at) as month'),
                'sektor.sektor as sektor',
                'ggn_penyebab.penyebab as penyebab',
                DB::raw('COUNT(*) as count')
            )
                ->join('teamdetail', 'tiket_tim.id_teknisi', '=', 'teamdetail.id_karyawan')
                ->join('teamlist', 'teamdetail.id_team', '=', 'teamlist.id')
                ->join('sektor_tim', 'teamlist.id', '=', 'sektor_tim.id_tim')
                ->join('sektor', 'sektor_tim.id_sektor', '=', 'sektor.id')
                ->join('ggn_tiket', 'tiket_tim.id', '=', 'ggn_tiket.id_tiket')
                ->join('ggn_penyebab', 'ggn_tiket.id_penyebab', '=', 'ggn_penyebab.id')
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $bln)
                ->where('id_j_tiket', 1)
                ->groupBy('month', 'sektor', 'penyebab')
                ->orderBy('month', 'asc')
                ->get();

            $blan = Tikettim::whereYear('created_at', $year)->whereMonth('created_at', $bln)
                ->select(DB::raw('MONTH(created_at) as month'))
                ->groupBy('month')->get();

            $totalbjm = Tikettim::whereYear('created_at', $year)->whereHas('teamlist', function ($query) {
                $query->whereHas('sektor', function ($query) {
                    $query->where('sektor.id', 7);
                });
            })->where('id_j_tiket', 1)
                ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))->groupBy('month')->get();

            $totaluli = Tikettim::whereYear('created_at', $year)->whereHas('teamlist', function ($query) {
                $query->whereHas('sektor', function ($query) {
                    $query->where('sektor.id', 8);
                });
            })->where('id_j_tiket', 1)
                ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))->groupBy('month')->get();

            $totalkyg = Tikettim::whereYear('created_at', $year)->whereHas('teamlist', function ($query) {
                $query->whereHas('sektor', function ($query) {
                    $query->where('sektor.id', 6);
                });
            })->where('id_j_tiket', 1)
                ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))->groupBy('month')->get();

            $pdfname = 'Report Penyebab Gangguan bulan ' . $carbon . '.pdf';
            $name = 'Report Penyebab Gangguan bulan ' . $carbon;
            $pdf = PDF::loadview('content.report_tb.printgp', [
                'perfpsb' => $perfpsb,
                'blan' => $blan,
                'totalkyg' => $totalkyg,
                'totalbjm' => $totalbjm,
                'totaluli' => $totaluli,
                'pdfname' => $name,
                'year' => $year
            ])->setPaper('A4', 'potrait');
            
            return $pdf->stream($pdfname);

        } else if ($req->input('buttonType') === 'tahunan') {
            $year = $req->year;
            $perfpsb = Tikettim::select(
                DB::raw('MONTH(created_at) as month'),
                'sektor.sektor as sektor',
                'ggn_penyebab.penyebab as penyebab',
                DB::raw('COUNT(*) as count')
            )
                ->join('teamdetail', 'tiket_tim.id_teknisi', '=', 'teamdetail.id_karyawan')
                ->join('teamlist', 'teamdetail.id_team', '=', 'teamlist.id')
                ->join('sektor_tim', 'teamlist.id', '=', 'sektor_tim.id_tim')
                ->join('sektor', 'sektor_tim.id_sektor', '=', 'sektor.id')
                ->join('ggn_tiket', 'tiket_tim.id', '=', 'ggn_tiket.id_tiket')
                ->join('ggn_penyebab', 'ggn_tiket.id_penyebab', '=', 'ggn_penyebab.id')
                ->whereYear('created_at', $year)
                // ->whereMonth('created_at', $bln)
                ->where('id_j_tiket', 1)
                ->groupBy('month', 'sektor', 'penyebab')
                ->orderBy('month', 'asc')
                ->get();

            $blan = Tikettim::whereYear('created_at', $year)
                ->select(DB::raw('MONTH(created_at) as month'))
                ->groupBy('month')->get();

            $totalbjm = Tikettim::whereYear('created_at', $year)->whereHas('teamlist', function ($query) {
                $query->whereHas('sektor', function ($query) {
                    $query->where('sektor.id', 7);
                });
            })->where('id_j_tiket', 1)
                ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))->groupBy('month')->get();

            $totaluli = Tikettim::whereYear('created_at', $year)->whereHas('teamlist', function ($query) {
                $query->whereHas('sektor', function ($query) {
                    $query->where('sektor.id', 8);
                });
            })->where('id_j_tiket', 1)
                ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))->groupBy('month')->get();

            $totalkyg = Tikettim::whereYear('created_at', $year)->whereHas('teamlist', function ($query) {
                $query->whereHas('sektor', function ($query) {
                    $query->where('sektor.id', 6);
                });
            })->where('id_j_tiket', 1)
                ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))->groupBy('month')->get();

            $pdfname = 'Total Pemasangan Tahun ' . $year . '.pdf';
            $name = 'Total Pemasangan Tahun ' . $year;
            $pdf = PDF::loadview('content.report_tb.printgp', [
                'perfpsb' => $perfpsb,
                'blan' => $blan,
                'totalkyg' => $totalkyg,
                'totalbjm' => $totalbjm,
                'totaluli' => $totaluli,
                'pdfname' => $name,
                'year' => $year
            ])->setPaper('A4', 'potrait');
            return $pdf->stream($pdfname);
        }

   
    }
}
