<?php

namespace App\Http\Controllers;

use App\Models\Beritaacara;
use App\Models\Jenistiket;
use App\Models\RekapBa;
use App\Models\Teamdetail;
use App\Models\Teamlist;
use App\Models\Tiketlist;
use App\Models\Tikettim;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use PDF;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;

class RekapBaController extends Controller
{
    public function index(Request $request)
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        if (auth()->user()->jobdesk->jobdesk == "Teknisi") {
            $team = auth()->user()->teamdetail->teamlist->list_tim;
            $jenistiket = Jenistiket::all();
            $teamlist = Teamlist::all();

            $rekap = Rekapba::orderBy('updated_at', 'ASC')->whereHas('beritaacara', function ($query) use ($team) {
                $query->whereHas('teamdetail', function ($query) use ($team) {
                    $query->whereHas('teamlist', function ($query) use ($team) {
                        $query->where('list_tim', $team);
                    });
                });
            })->filter(request(['search', 'bulan', 'tahun']))->get();
            return view('content.r-ba.index', compact('rekap', 'teamlist', 'jenistiket', 'tglnow'));
        }

        $jenistiket = Jenistiket::all();
        $teamlist = Teamlist::all();

        return view('content.r-ba.index', compact('rekap', 'teamlist', 'jenistiket', 'tglnow'));
    }

    public function index_psb()
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $jenistiket = Jenistiket::all();
        $teamlist = Teamlist::all();
        $rba = 'psb';

        $rekap = Rekapba::orderBy('updated_at', 'ASC')->whereHas('beritaacara', function ($query) {
            $query->whereHas('teamdetail', function ($query) {
                $query->whereHas('jobdesk', function ($query) {
                    $query->where('detail_kerja', 2);
                });
            });
        })->filter(request(['search', 'bulan', 'tahun', 'team']))->get();

        return view('content.r-ba.index', compact('rba', 'rekap', 'teamlist', 'jenistiket', 'tglnow'));
    }

    public function index_ggn()
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $jenistiket = Jenistiket::all();
        $teamlist = Teamlist::all();
        $rba = 'ggn';

        $rekap = Rekapba::orderBy('updated_at', 'ASC')->whereHas('beritaacara', function ($query) {
            $query->whereHas('teamdetail', function ($query) {
                $query->whereHas('jobdesk', function ($query) {
                    $query->where('detail_kerja', 1);
                });
            });
        })->filter(request(['search', 'bulan', 'tahun', 'team']))->get();

        return view('content.r-ba.index', compact('rba', 'rekap', 'teamlist', 'jenistiket', 'tglnow'));
    }

    public function index_mtn()
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $jenistiket = Jenistiket::all();
        $teamlist = Teamlist::all();
        $rba = 'mtn';

        $rekap = Rekapba::orderBy('updated_at', 'ASC')->whereHas('beritaacara', function ($query) {
            $query->whereHas('teamdetail', function ($query) {
                $query->whereHas('jobdesk', function ($query) {
                    $query->where('detail_kerja', 3);
                });
            });
        })->filter(request(['search', 'bulan', 'tahun', 'team']))->get();

        return view('content.r-ba.index', compact('rba', 'rekap', 'teamlist', 'jenistiket', 'tglnow'));
    }

    public function show($id)
    {
        $beritaacara = Beritaacara::find($id);
        $file = $beritaacara->file_ba;
        $pathToFile = public_path('doc/' . $file);

        return response()->file($pathToFile);
    }

    public function print_psb(Request $req)
    {
        $bln = $req->bulan;
        $rekap = Rekapba::orderBy('updated_at', 'ASC')->whereHas('beritaacara', function ($query) {
            $query->whereHas('teamdetail', function ($query) {
                $query->whereHas('jobdesk', function ($query) {
                    $query->where('detail_kerja', 2);
                });
            });
        })->filter(request(['search', 'bulan', 'tahun', 'team']))->get();

        $hitung = Teamlist::withCount(['ba' => function ($query) use ($bln) {
            $query->whereHas('teamdetail', function ($query) {
                $query->whereHas('jobdesk', function ($query) {
                    $query->where('detail_kerja', 2);
                });
            })->whereMonth('created_at', $bln);
        }])->get();

        $pdfname = 'Rekap Berita Acara Pasang Baru.pdf';
        $name = 'Rekap Berita Acara Pasang Baru';
        $pdf = PDF::loadview('content.r-ba.print', ['rekap' => $rekap, 'pdfname' => $name, 'hitung' => $hitung])->setPaper('A4', 'potrait');
        return $pdf->stream($pdfname);
    }

    public function print_ggn(Request $req)
    {
        $bln = $req->bulan;
        $rekap = Rekapba::orderBy('updated_at', 'ASC')->whereHas('beritaacara', function ($query) {
            $query->whereHas('teamdetail', function ($query) {
                $query->whereHas('jobdesk', function ($query) {
                    $query->where('detail_kerja', 1);
                });
            });
        })->filter(request(['search', 'bulan', 'tahun', 'team']))->get();

        $hitung = Teamlist::withCount(['ba' => function ($query) use ($bln) {
            $query->whereHas('teamdetail', function ($query) {
                $query->whereHas('jobdesk', function ($query) {
                    $query->where('detail_kerja', 1);
                });
            })->whereMonth('created_at', $bln);
        }])->get();

        $pdfname = 'Rekap Berita Acara Gangguan.pdf';
        $name = 'Rekap Berita Acara Gangguan';
        $pdf = PDF::loadview('content.r-ba.print', ['rekap' => $rekap, 'pdfname' => $name, 'hitung' => $hitung])->setPaper('A4', 'potrait');
        return $pdf->stream($pdfname);
    }

    public function print_mtn(Request $req)
    {
        $bln = $req->bulan;
        $rekap = Rekapba::orderBy('updated_at', 'ASC')->whereHas('beritaacara', function ($query) {
            $query->whereHas('teamdetail', function ($query) {
                $query->whereHas('jobdesk', function ($query) {
                    $query->where('detail_kerja', 3);
                });
            });
        })->filter(request(['search', 'bulan', 'tahun', 'team']))->get();

        $hitung = Teamlist::withCount(['ba' => function ($query) use ($bln) {
            $query->whereHas('teamdetail', function ($query) {
                $query->whereHas('jobdesk', function ($query) {
                    $query->where('detail_kerja', 3);
                });
            })->whereMonth('created_at', $bln);
        }])->get();

        $pdfname = 'Rekap Berita Acara Maintenance.pdf';
        $name = 'Rekap Berita Acara Maintenance';
        $pdf = PDF::loadview('content.r-ba.print', ['rekap' => $rekap, 'pdfname' => $name, 'hitung' => $hitung])->setPaper('A4', 'potrait');
        return $pdf->stream($pdfname);
    }

    public function print(Request $req)
    {
        $jtiket = $req->jtiket;
        $bln = $req->bulan;
        $rekap = Rekapba::orderBy('updated_at', 'ASC')->filter(request(['search', 'jtiket', 'bulan', 'tahun', 'team']))->get();

        $req->validate([
            'jtiket' => ['required'],
            'bulan' => ['required'],
        ]);


        if ($jtiket == "Gangguan") {

            $hitung = Teamlist::withCount(['ba' => function (Builder $query) use ($jtiket, $bln) {
                $query->whereHas('teamdetail', function ($query) use ($jtiket) {
                    $query->whereHas('jobdesk', function ($query) use ($jtiket) {
                        $query->where('detail_kerja', $jtiket);
                    });
                })->whereMonth('created_at', $bln);
            }])->get();

            $pdfname = 'Rekap Berita Acara Gangguan.pdf';
            $name = 'Rekap Berita Acara Gangguan';
            $pdf = PDF::loadview('content.r-ba.print', ['rekap' => $rekap, 'pdfname' => $name, 'hitung' => $hitung])->setPaper('A4', 'potrait');
            return $pdf->stream($pdfname);
        } elseif ($jtiket == "Pasang Baru") {

            $hitung = Teamlist::withCount(['ba' => function (Builder $query) use ($jtiket, $bln) {
                $query->whereHas('teamdetail', function ($query) use ($jtiket) {
                    $query->whereHas('jobdesk', function ($query) use ($jtiket) {
                        $query->where('detail_kerja', $jtiket);
                    });
                })->whereMonth('created_at', $bln);
            }])->get();

            $pdfname = 'Rekap Berita Acara Pasang Baru.pdf';
            $name = 'Rekap Berita Acara Pasang Baru';
            $pdf = PDF::loadview('content.r-ba.print', ['rekap' => $rekap, 'pdfname' => $name, 'hitung' => $hitung])->setPaper('A4', 'potrait');
            return $pdf->stream($pdfname);
        } elseif ($jtiket == "Maintenance") {

            $hitung = Teamlist::withCount(['ba' => function (Builder $query) use ($jtiket, $bln) {
                $query->whereHas('teamdetail', function ($query) use ($jtiket) {
                    $query->whereHas('jobdesk', function ($query) use ($jtiket) {
                        $query->where('detail_kerja', $jtiket);
                    });
                })->whereMonth('created_at', $bln);
            }])->get();

            $pdfname = 'Rekap Berita Acara Maintenance.pdf';
            $name = 'Rekap Berita Acara Maintenance';
            $pdf = PDF::loadview('content.r-ba.print', ['rekap' => $rekap, 'pdfname' => $name, 'hitung' => $hitung])->setPaper('A4', 'potrait');
            return $pdf->stream($pdfname);
        } else {

            $hitung = Teamlist::withCount(['ba' => function (Builder $query) use ($bln) {
                $query->whereMonth('created_at', $bln);
            }])->get();

            $pdfname = 'Rekap Berita Acara dan Tiket Pengerjaan.pdf';
            $name = 'Rekap Berita dan Tiket Pengerjaan';
            $pdf = PDF::loadview('content.r-ba.print', ['rekap' => $rekap, 'pdfname' => $name, 'hitung' => $hitung])->setPaper('A4', 'potrait');
            return $pdf->stream($pdfname);
        }
    }

    public function mergepdf()
    {
        $ba = Beritaacara::with(['teamdetail'])->orderBy('updated_at', 'ASC')->filter(request(['search', 'bulan', 'tahun', 'team']))->pluck('file_ba');
        $pdf = PDFMerger::init();

        foreach ($ba as $file) {
            $pathToFile = public_path('doc/' . $file);
            $pdf->addPDF($pathToFile, 'all');
        }

        $fileName = time() . '.pdf';
        $pdf->merge();
        $pdf->save(public_path('doc/' . $fileName));

        return $pdf->stream(public_path('doc/' . $fileName));
    }

    public function create()
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $bln = date('m');
        if (auth()->user()->jobdesk->jobdesk == "Teknisi") {
            $team = auth()->user()->teamdetail->teamlist->list_tim;

            $tikettim = Tikettim::where(function ($query) use ($bln) {
                $query->whereMonth('created_at', $bln);
            })->with(['teamdetail'])->whereHas('teamdetail', function ($query) use ($team) {
                $query->whereHas('teamlist', function ($query) use ($team) {
                    $query->where('list_tim', $team);
                });
            })->get();
            $beritaacara = Beritaacara::where(function ($query) use ($bln) {
                $query->whereMonth('created_at', $bln);
            })->with(['teamdetail'])->whereHas('teamdetail', function ($query) use ($team) {
                $query->whereHas('teamlist', function ($query) use ($team) {
                    $query->where('list_tim', $team);
                });
            })->get();

            return view('content.r-ba.create', compact('beritaacara', 'tikettim', 'tglnow'));
        }

        $tikettim = Tikettim::where(function ($query) use ($bln) {
            $query->whereMonth('created_at', $bln);
        })->with(['teamdetail'])->orderBy('id_teknisi', 'ASC')->get();
        $beritaacara = Beritaacara::where(function ($query) use ($bln) {
            $query->whereMonth('created_at', $bln);
        })->with(['teamdetail'])->orderBy('updated_at', 'ASC')->get();

        return view('content.r-ba.create', compact('beritaacara', 'tikettim', 'tglnow'));
    }

    public function store(Request $request)
    {
        $noTiket = $request->id_tiket;
        $cekNo = RekapBa::where('id_tiket', $noTiket)->get();
        $hitung = $cekNo->count();

        if ($hitung > 0) {
            return redirect()->route('tbh.rba')->with('error', 'No Tiket Sudah Terdaftar');
        }

        $this->validate($request, [
            'id_tiket' => 'required',
        ]);

        $id = $request->id_ba;
        $id_tim = Beritaacara::where('id', $id)->value('id_tl');

        RekapBa::create([
            'id_ba' => $id,
            'id_tiket' => $request->id_tiket,
            'id_tim' => $id_tim,
        ]);
        return redirect('/rba')->with('success', 'Data Berhasil di Tambahkan');
    }

    public function edit($id)
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $bln = date('m');
        if (auth()->user()->jobdesk->jobdesk == "Teknisi") {
            $team = auth()->user()->teamdetail->teamlist->list_tim;

            $rekapba = RekapBa::find($id);

            $tikettim = Tikettim::where(function ($query) use ($bln) {
                $query->whereMonth('created_at', $bln);
            })->with(['teamdetail'])->whereHas('teamdetail', function ($query) use ($team) {
                $query->whereHas('teamlist', function ($query) use ($team) {
                    $query->where('list_tim', $team);
                });
            })->get();

            $beritaacara = Beritaacara::where(function ($query) use ($bln) {
                $query->whereMonth('created_at', $bln);
            })->with(['teamdetail'])->whereHas('teamdetail', function ($query) use ($team) {
                $query->whereHas('teamlist', function ($query) use ($team) {
                    $query->where('list_tim', $team);
                });
            })->get();

            return view('content.r-ba.edit', compact('beritaacara', 'tikettim', 'tglnow', 'rekapba'));
        }

        $tikettim = Tikettim::where(function ($query) use ($bln) {
            $query->whereMonth('created_at', $bln);
        })->with(['teamdetail'])->orderBy('id_teknisi', 'ASC')->get();
        $beritaacara = Beritaacara::where(function ($query) use ($bln) {
            $query->whereMonth('created_at', $bln);
        })->with(['teamdetail'])->orderBy('updated_at', 'ASC')->get();
        $rekapba = RekapBa::find($id);
        return view('content.r-ba.edit', compact('tikettim', 'beritaacara', 'rekapba', 'tglnow'));
    }

    public function update(Request $request, $id)
    {
        $rekapba = RekapBa::find($id);
        $id = $request->id_ba;
        $id_tim = Beritaacara::where('id', $id)->value('id_tl');

        $rekapba->update([
            'id_ba' => $id,
            'id_tiket' => $request->id_tiket,
            'id_tim' => $id_tim,
        ]);
        return redirect('/rba');
    }

    public function delete($id)
    {
        $rekapba = RekapBa::find($id);
        $rekapba->delete();
        return redirect('/rba');
    }
}
