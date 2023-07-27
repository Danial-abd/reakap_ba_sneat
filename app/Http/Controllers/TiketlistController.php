<?php

namespace App\Http\Controllers;

use App\Models\Jenistiket;
use App\Models\Tiketlist;
use App\Models\Tikettim;
use Carbon\Carbon;
use Illuminate\Http\Request;
use filter;
use PDF;

class TiketlistController extends Controller
{

    //index
    public function psindex(Request $req)
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $bln = date('m');

        // dd($req->all);
        if ($req->all() == null) {
            $tiktim = Tikettim::orderBy('id_teknisi', 'ASC')->whereMonth('created_at', $bln)->where('status', 'Belum di cek')->where('id_j_tiket', 2)->filter(request(['search', 'bulan']))->orderBy('created_at', 'desc')->get();
            $tikrev =  Tikettim::orderBy('id_teknisi', 'ASC')->whereMonth('created_at', $bln)->where('status', 'revisi')->where('id_j_tiket', 2)->filter(request(['search', 'bulan']))->orderBy('created_at', 'desc')->get();
            $tikacc =  Tikettim::orderBy('id_teknisi', 'ASC')->whereMonth('created_at', $bln)->where('status', 'approved')->where('id_j_tiket', 2)->filter(request(['search', 'bulan']))->orderBy('created_at', 'desc')->get();
            return view('content.tiket.psb.t-index', compact('tglnow','tikrev','tikacc', 'tiktim'));
        } elseif ($req->all() != null) {
            $tikrev =  Tikettim::orderBy('id_teknisi', 'ASC')->where('status', 'revisi')->where('id_j_tiket', 2)->filter(request(['search', 'bulan']))->orderBy('created_at', 'desc')->get();
            $tikacc =  Tikettim::orderBy('id_teknisi', 'ASC')->where('status', 'approved')->where('id_j_tiket', 2)->filter(request(['search', 'bulan']))->orderBy('created_at', 'desc')->get();
            $tiktim = Tikettim::orderBy('id_teknisi', 'ASC')->where('status', 'Input Baru')->where('id_j_tiket', 2)->filter(request(['search', 'bulan']))->orderBy('created_at', 'desc')->get();

            return view('content.tiket.psb.t-index', compact('tglnow','tikrev','tikacc', 'tiktim'));
        }
    }

    public function ggnindex(Request $req)
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $bln = date('m');

        // dd($req->all);
        if ($req->all() == null) {
            $tiktim = Tikettim::orderBy('id_teknisi', 'ASC')->whereMonth('created_at', $bln)->where('status', 'Input Baru')->where('id_j_tiket', 1)->filter(request(['search', 'bulan']))->orderBy('created_at', 'desc')->get();

            return view('content.tiket.ggn.t-index', compact('tglnow', 'tiktim'));
        } elseif ($req->all() != null) {
            $tiktim = Tikettim::orderBy('id_teknisi', 'ASC')->where('status', 'Input Baru')->where('id_j_tiket', 1)->filter(request(['search', 'bulan']))->orderBy('created_at', 'desc')->get();

            return view('content.tiket.ggn.t-index', compact('tglnow', 'tiktim'));
        }
        // return view('content.tiket.ggn.t-index', compact('tglnow'), [
        //     "tiketlist" => Tiketlist::with(['jenistiket'])
        //         ->whereHas('jenistiket', function ($query) {
        //             $query->where('id', '1');
        //         })->filter(request(['search','bulan']))->get()
        // ]);
    }

    public function mtnindex(Request $req)
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $bln = date('m');

        // dd($req->all);
        if ($req->all() == null) {
            $tiktim = Tikettim::orderBy('id_teknisi', 'ASC')->whereMonth('created_at', $bln)->where('status', 'Input Baru')->where('id_j_tiket', 3)->filter(request(['search', 'bulan']))->orderBy('created_at', 'desc')->get();

            return view('content.tiket.mtn.t-index', compact('tglnow', 'tiktim'));
        } elseif ($req->all() != null) {
            $tiktim = Tikettim::orderBy('id_teknisi', 'ASC')->where('status', 'Input Baru')->where('id_j_tiket', 3)->filter(request(['search', 'bulan']))->orderBy('created_at', 'desc')->get();

            return view('content.tiket.mtn.t-index', compact('tglnow', 'tiktim'));
        }
    }

    public function print()
    {
        $hasil = Tiketlist::with(['jenistiket'])
            ->whereHas('jenistiket', function ($query) {
                $query->where('id', '1');
            })->filter(request(['search', 'bulan', 'tahun']))->get();

        $pdfname = 'Laporan Data Tiket Gangguan.pdf';
        $pdf = PDF::loadview('content.tiket.ggn.print', ['tiketlist' => $hasil, 'pdfname' => $pdfname]);
        return $pdf->stream($pdfname);
    }

    public function printpsb()
    {
        $hasil = Tiketlist::with(['jenistiket'])
            ->whereHas('jenistiket', function ($query) {
                $query->where('id', '2');
            })->filter(request(['search', 'bulan', 'tahun']))->get();

        $pdfname = 'Laporan Data Tiket Gangguan.pdf';
        $pdf = PDF::loadview('content.tiket.psb.print', ['tiketlist' => $hasil, 'pdfname' => $pdfname]);
        return $pdf->stream($pdfname);
    }

    public function printmtn()
    {
        $hasil = Tiketlist::with(['jenistiket'])
            ->whereHas('jenistiket', function ($query) {
                $query->where('id', '3');
            })->filter(request(['search', 'bulan', 'tahun']))->get();

        $pdfname = 'Laporan Data Tiket Gangguan.pdf';
        $pdf = PDF::loadview('content.tiket.mtn.print', ['tiketlist' => $hasil, 'pdfname' => $pdfname]);
        return $pdf->stream($pdfname);
    }

    public function ggnedit($id)
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $jenistiket = Jenistiket::all();
        $tiketlist = Tiketlist::find($id);
        return view('content.tiket.t-edit', compact('jenistiket', 'tiketlist', 'tglnow'));
    }

    public function ggnupdate(Request $request, $id)
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $tiketlist = Tiketlist::find($id);
        $tiketlist->update($request->except(['_token', 'submit']));

        $id_tiket = $request->id_j_tiket;

        if ($id_tiket == '1') {
            return redirect('/ggntiket')->compact('tglnow');
        } elseif ($id_tiket == '2') {
            return redirect('/psbtiket')->compact('tglnow');
        } elseif ($id_tiket == '3') {
            return redirect('/mtntiket')->compact('tglnow');
        }
    }

    public function pscreate()
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $jenistiket = Jenistiket::where('id', '2')->first();
        return view('content.tiket.psb.t-create', compact('jenistiket', 'tglnow'));
    }

    public function ggncreate()
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $jenistiket = Jenistiket::where('id', '1')->first();
        return view('content.tiket.ggn.t-create', compact('jenistiket', 'tglnow'));
    }

    public function mtncreate()
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $jenistiket = Jenistiket::where('id', '3')->first();
        return view('content.tiket.mtn.t-create', compact('jenistiket', 'tglnow'));
    }

    public function psstore(Request $request)
    {
        $noTiket = $request->no_tiket;
        $cekNo = Tiketlist::where('no_tiket', $noTiket)->get();
        $hitung = $cekNo->count();

        if ($hitung > 0) {
            return redirect()->route('tbh.psb')->with('error', 'No Tiket Sudah Terdaftar');
        }

        Tiketlist::create($request->validate([
            'id_j_tiket' => 'required',
            'no_tiket' => 'required',
            'nama_pic' => 'required',
            'no_pic' => 'required',
            'alamat' => 'required',
            'ket' => 'nullable'
        ]));
        return redirect('/psbtiket')->with('success', 'Berhasil Menambahkan Data');
    }

    public function ggnstore(Request $request)
    {
        $noTiket = $request->no_tiket;
        $cekNo = Tiketlist::where('no_tiket', $noTiket)->get();
        $hitung = $cekNo->count();

        if ($hitung > 0) {
            return redirect()->route('tbh.ggn')->with('error', 'No Tiket Sudah Terdaftar');
        }

        Tiketlist::create($request->validate([
            'id_j_tiket' => 'required',
            'no_tiket' => 'required',
            'nama_pic' => 'required',
            'no_pic' => 'required',
            'alamat' => 'required',
            'ket' => 'nullable'
        ]));
        return redirect('/ggntiket')->with('success', 'Berhasil Menambahkan Data');
    }

    public function mtnstore(Request $request)
    {
        $noTiket = $request->no_tiket;
        $cekNo = Tiketlist::where('no_tiket', $noTiket)->get();
        $hitung = $cekNo->count();

        if ($hitung > 0) {
            return redirect()->route('tbh.mtn')->with('error', 'No Tiket Sudah Terdaftar');
        }

        Tiketlist::create($request->validate([
            'id_j_tiket' => 'required',
            'no_tiket' => 'required',
            'nama_pic' => 'required',
            'no_pic' => 'required',
            'alamat' => 'required',
            'ket' => 'nullable'
        ]));
        return redirect('/mtntiket')->with('success', 'Berhasil Menambahkan Data');
    }

    public function ggndelete($id)
    {

        $id_tiket = Tiketlist::where('id', $id)->value('id_j_tiket');
        if ($id_tiket == '1') {

            $tiketlist = Tiketlist::find($id);
            $tiketlist->delete();
            return redirect('/ggntiket');
        } elseif ($id_tiket == '2') {
            $tiketlist = Tiketlist::find($id);
            $tiketlist->delete();

            return redirect('/psbtiket');
        } elseif ($id_tiket == '3') {
            $tiketlist = Tiketlist::find($id);
            $tiketlist->delete();
            return redirect('/mtntiket');
        }
    }
}
