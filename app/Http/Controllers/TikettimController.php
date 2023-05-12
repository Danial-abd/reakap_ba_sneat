<?php

namespace App\Http\Controllers;

use App\Models\Jenistiket;
use App\Models\Teamdetail;
use App\Models\Teamlist;
use App\Models\Tiketlist;
use App\Models\Tikettim;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class TikettimController extends Controller
{
    public function index(Request $request)
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        if (auth()->user()->jobdesk->jobdesk == "Teknisi") {
            $team = auth()->user()->teamdetail->teamlist->list_tim;

            $teamdetail = Teamdetail::all();
            $teamlist = Teamlist::all();
            $jenistiket = Jenistiket::all();

            $tiktim = Tikettim::with(['teamdetail'])->whereHas('teamdetail', function ($query) use ($team) {
                $query->whereHas('teamlist', function ($query) use ($team) {
                    $query->where('list_tim', $team);
                });
            })->filter(request(['search', 'bulan', 'tahun']))->get();
            return view('content.tiket-team.index', compact('tiktim', 'teamlist', 'jenistiket', 'teamdetail','tglnow'));
        }
        $teamdetail = Teamdetail::all();
        $teamlist = Teamlist::all();
        $jenistiket = Jenistiket::all();
        $tiktim = Tikettim::orderBy('id_teknisi', 'ASC')->filter(request(['search', 'bulan', 'tahun', 'team', 'jtiket']))->get();
        return view('content.tiket-team.index', compact('tiktim', 'teamlist', 'jenistiket', 'teamdetail','tglnow'));
    }

    public function create()
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $bln = '02';
        // date('m')
        if (auth()->user()->jobdesk->jobdesk == "Teknisi") {
            $tiket = auth()->user()->jobdesk->detail_kerja;

            $teamdetail = Teamdetail::with(['teamlist'])->orderBy('id_team', 'ASC')->get();

            $tiketlist = Tiketlist::with(['jenistiket'])->where(function ($query) use ($bln) {
                $query->whereMonth('created_at',$bln);
            })->whereHas('jenistiket', function ($query) use ($tiket) {
                $query->where('nama_tiket', 'LIKE', '%' . $tiket . '%');
            })->get();

            return view('content.tiket-team.create', compact('teamdetail', 'tiketlist','tglnow'));
        }
        $teamdetail = Teamdetail::with(['teamlist'])->orderBy('id_team', 'ASC')->get();
        $tiketlist = Tiketlist::where(function ($query) use ($bln) {
            $query->whereMonth('updated_at',$bln);
        })->with(['jenistiket'])->orderBy('id_j_tiket', 'ASC')->get();
        return view('content.tiket-team.create', compact('teamdetail', 'tiketlist','tglnow'));
    }

    public function print(Request $req)
    {
        $jtiket = $req->jtiket;
        $bln = $req->bulan;
        $tik = Tikettim::orderBy('id_teknisi', 'ASC')->filter(request(['search', 'bulan', 'tahun', 'jtiket']));
        $tiktim = $tik->get();

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
            $pdf = PDF::loadview('content.tiket-team.print', ['tiktim' => $tiktim, 'pdfname' => $name, 'hitung' => $hitung])->setPaper('A4','landscape');
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
            $pdf = PDF::loadview('content.tiket-team.print', ['tiktim' => $tiktim, 'pdfname' => $name, 'hitung' => $hitung])->setPaper('A4','landscape');
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
            $pdf = PDF::loadview('content.tiket-team.print', ['tiktim' => $tiktim, 'pdfname' => $name, 'hitung' => $hitung])->setPaper('A4','landscape');
            return $pdf->stream($pdfname);
        } else {

            $hitung = Teamlist::withCount(['tikettims' => function (Builder $query) use ($bln){
                $query->whereMonth('created_at', $bln);
            }])->get();
            // $hitung = Teamlist::withCount(['tikettims'])->get();
            $pdfname = 'Laporan Seluruh Tiket.pdf';
            $name = 'Laporan Seluruh Tiket';
            $pdf = PDF::loadview('content.tiket-team.print', ['tiktim' => $tiktim, 'pdfname' => $name, 'hitung' => $hitung])->setPaper('A4','landscape');
            return $pdf->stream($pdfname);
        }
    }

    public function store(Request $request)
    {   
        $noTiket = $request->id_tiket;
        $cekNo = Tikettim::where('id_tiket', $noTiket)->get();
        $hitung = $cekNo->count();
        
        if($hitung > 0 ){
            return redirect()->route('tbh.tiket')->with('error', 'No Tiket Sudah Terdaftar');
        }
        
        $id = $request->id_teknisi;
        $id_tim = Teamdetail::where('id', $id)->value('id_team');
        Tikettim::create(
            [
                'id_teknisi' => $id,
                'id_tiket' => $request->id_tiket,
                'id_tim' => $id_tim,
            ]
        );
        return redirect('/tiket_team')->with('success', 'Data Berhasil di Tambahkan');
    }

    public function edit($id)
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $bln = date('m');
        if (auth()->user()->jobdesk->jobdesk == "Teknisi") {
            $tiket = auth()->user()->jobdesk->detail_kerja;

            $tiktim = Tikettim::find($id);

            $teamdetail = Teamdetail::with(['teamlist'])->orderBy('id_team', 'ASC')->get();

            $tiketlist = Tiketlist::with(['jenistiket'])->where(function ($query) use ($bln) {
                $query->whereMonth('created_at',$bln);
            })->whereHas('jenistiket', function ($query) use ($tiket) {
                $query->where('nama_tiket', 'LIKE', '%' . $tiket . '%');
            })->get();

            return view('content.tiket-team.edit', compact('teamdetail','tiktim', 'tiketlist','tglnow'));
        }
        $teamdetail = Teamdetail::with(['teamlist'])->orderBy('id_team', 'ASC')->get();
        $tiketlist = Tiketlist::where(function ($query) use ($bln) {
            $query->whereMonth('created_at',$bln);
        })->with(['jenistiket'])->orderBy('id_j_tiket', 'ASC')->get();
        $tiktim = Tikettim::find($id);
        return view('content.tiket-team.edit', compact('teamdetail', 'tiketlist', 'tiktim','tglnow'));
    }

    public function update(Request $request, $id)
    {
        $tiktim = Tikettim::find($id);
        $id = $request->id_teknisi;
        $id_tim = Teamdetail::where('id', $id)->value('id_team');
        $tiktim->update( [
            'id_teknisi' => $id,
            'id_tiket' => $request->id_tiket,
            'id_tim' => $id_tim,
        ]);
        return redirect('/tiket_team');
    }

    public function delete($id)
    {
        $tiktim = Tikettim::find($id);
        $tiktim->delete();
        return redirect('tiket_team');
    }
}
