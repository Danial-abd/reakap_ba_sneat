<?php

namespace App\Http\Controllers;

use App\Models\Jenistiket;
use App\Models\Lmaterial;
use App\Models\saldomaterial;
use App\Models\Teamdetail;
use App\Models\Teamlist;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class saldocontroller extends Controller
{
    public function index(Request $req)
    {
        $bln = date('m');
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $search = $req->search;
        $jenistiket = Jenistiket::all();
        $blnakhir = $bln - 1;

        // dd($req->bulan);

        $sisa = saldomaterial::where(function ($query) use ($blnakhir) {
            $query->whereMonth('created_at', $blnakhir);
        })->select('id_tim', 'id_material', DB::raw('SUM(jumlah - digunakan) as total_jumlah, SUM(jumlah) as jumlah, SUM(digunakan) as guna'))->groupBy('id_material')->groupBy('id_tim')->orderBy('id_tim', 'ASC')->get();

        $teampsb = Teamlist::whereHas('teamdetail', function ($query) {
            $query->where('id_jobdesk', 3);
        })->get();

        $team = Teamlist::all();

        // Teamlist::with('saldo')->orderBy('id', 'ASC')->get();

        $tdetail = Teamdetail::all();

        $teamlist = Teamlist::all();

        //tim

        if (auth()->user()->jobdesk->jobdesk == "Teknisi") {

            $tim = auth()->user()->teamdetail->teamlist->list_tim;

            $id = Teamlist::where('list_tim', $tim)->pluck('id')->first();

            $stimakhir = saldomaterial::where(function ($query) use ($id) {
                $query->where('id_tim', $id);
            })->where(function ($query) use ($blnakhir) {
                $query->whereMonth('created_at', $blnakhir);
            })->select('id_tim', 'id_material', DB::raw('SUM(jumlah - digunakan) as total_jumlah,  SUM(jumlah) as jumlah, SUM(digunakan) as guna'))->groupBy('id_material', 'id_tim')->get();

            $saldotim = saldomaterial::where(function ($query) use ($id) {
                $query->where('id_tim', $id);
            })->where(function ($query) use ($bln) {
                $query->whereMonth('created_at', $bln);
            })->select('id_tim', 'id_material', DB::raw('SUM(jumlah - digunakan) as total_jumlah,  SUM(jumlah) as jumlah, SUM(digunakan) as guna'))->groupBy('id_material', 'id_tim')->get();

            // dd($stimakhir->sum('total_jumlah'));

            if ($stimakhir->sum('total_jumlah') > 0) {
                $info = "Anda Belum Mengembalikan semua Material di bulan sebelumnya";
                return view('content.saldom.saldo', compact('saldotim', 'team', 'tglnow', 'jenistiket', 'tdetail', 'teamlist', 'info'));
            } else {
                $info = null;
                return view('content.saldom.saldo', compact('saldotim', 'team', 'tglnow', 'jenistiket', 'tdetail', 'teamlist', 'info'));
            }
        }

        //pencarian bulan index
        if ($req->bulan == null) {
            $bulan = date('m');
            $saldo = saldomaterial::where(function ($query) use ($bln) {
                $query->whereMonth('created_at', $bln);
            })->select('id_tim', 'id_material', DB::raw('SUM(jumlah - digunakan) as total_jumlah, SUM(jumlah) as jumlah, SUM(digunakan) as guna'))->groupBy('id_tim', 'id_material')->orderBy('id_tim', 'ASC')->filter(request(['search', 'bulan']))->get();

            if ($sisa->sum('total_jumlah') > 0) {
                $reminder = "Beberapa Tim masih belum mengembalikan material dibulan sebelumnya";
                return view('content.saldom.saldo', compact('saldo', 'teampsb', 'tglnow', 'jenistiket', 'tdetail', 'bulan', 'teamlist', 'reminder'));
            } else {
                $reminder = null;
                return view('content.saldom.saldo', compact('saldo', 'teampsb', 'tglnow', 'jenistiket', 'tdetail', 'bulan', 'teamlist', 'reminder', 'search'));
            }
        } elseif ($req->bulan != null) {
            $bulan = $req->bulan;
            $saldo = saldomaterial::where(function ($query) use ($bulan) {
                $query->whereMonth('created_at', $bulan);
            })->select('id_tim', 'id_material', DB::raw('SUM(jumlah - digunakan) as total_jumlah, SUM(jumlah) as jumlah, SUM(digunakan) as guna'))->groupBy('id_material')->groupBy('id_tim')->orderBy('id_tim', 'ASC')->filter(request(['search', 'bulan']))->get();

            if ($sisa->sum('total_jumlah') > 0) {
                $reminder = "Beberapa Tim masih belum mengembalikan material dibulan sebelumnya";
                return view('content.saldom.saldo', compact('saldo', 'teampsb', 'tglnow', 'jenistiket', 'tdetail', 'bulan', 'teamlist', 'reminder'));
            } else {
                $reminder = null;
                return view('content.saldom.saldo', compact('saldo', 'teampsb', 'tglnow', 'jenistiket', 'tdetail', 'bulan', 'teamlist', 'reminder', 'search'));
            }
        }
    }

    public function edit(Request $req, $id, $bulan)
    {
        $bln = $bulan;

        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $nickname = 'sld';
        $tl = Teamlist::find($id);

        $material = Lmaterial::all();

        $saldotim = saldomaterial::with('teamlist')->where(function ($query) use ($id) {
            $query->where('id_tim', $id);
        })->where(function ($query) use ($bln) {
            $query->whereMonth('created_at', $bln);
        })->select('id_tim', 'id_material', DB::raw('SUM(jumlah - digunakan) as total_jumlah,  SUM(jumlah) as jumlah, SUM(digunakan) as guna'))->groupBy('id_material', 'id_tim')->get();

        if ($saldotim->count() == 0) {
            return redirect()->route('sld')->with('error', 'Data Kosong');
        }

        if ($saldotim->sum('total_jumlah') == 0) {
            return redirect()->route('sld')->with('success', 'Material Habis, Tidak Perlu Pengembalian');
        }

        // dd($saldotim);
        return view('content.saldom.update', compact('nickname', 'tl', 'saldotim', 'bln', 'material', 'tglnow'));
    }

    public function update(Request $req, $id_tim, $bln)
    {
        // dd($bln);
        $tglold = Carbon::now()->subMonth()->format('Y-m-d H:i:s');
        $tglnow = Carbon::now()->format('Y-m-d H:i:s');

        $blnow = date('m');

        // dd($tglold);

        $saldotim = saldomaterial::where(function ($query) use ($id_tim) {
            $query->where('id_tim', $id_tim);
        })->where(function ($query) use ($bln) {
            $query->whereMonth('created_at', $bln);
        })->select('id_tim', 'id_material', DB::raw('SUM(jumlah - digunakan) as total_jumlah,  SUM(jumlah) as jumlah, SUM(digunakan) as guna'))->groupBy('id_material', 'id_tim')->get();

        $data = $req->all();
        $id = $id_tim;

        if ($bln == $blnow) {
            if (count($data['id_material']) > 0) {
                foreach ($data['id_material'] as $item => $value) {
                    foreach ($saldotim as $s) {
                        if ($s->id_material == $data['id_material'][$item] and $s->total_jumlah < $data['jumlah'][$item]) {
                            $sa = $s->id_material;
                            $tanggal = $s->created_at;
                            $material = Lmaterial::where('id', $sa)->pluck('nama_material');
                            return redirect()->route('edt.sld', [$id, $bln])->with('error', $material[0]);
                        }
                    }

                    $data2 = array(
                        'id_material' => $data['id_material'][$item],
                        'jumlah' => 0,
                        'digunakan' => $data['jumlah'][$item],
                        'id_tim' => $id_tim,
                        'created_at' => $tglnow,
                        'ket' => 'Pengembalian',
                    );
                    saldomaterial::create($data2);
                }
            }
        } else if ($bln != $blnow) {
            if (count($data['id_material']) > 0) {
                foreach ($data['id_material'] as $item => $value) {
                    foreach ($saldotim as $s) {
                        if ($s->id_material == $data['id_material'][$item] and $s->total_jumlah < $data['jumlah'][$item]) {
                            $sa = $s->id_material;
                            $tanggal = $s->created_at;
                            $material = Lmaterial::where('id', $sa)->pluck('nama_material');
                            return redirect()->route('edt.sld', [$id, $bln])->with('error', $material[0]);
                        }
                    }

                    $data2 = array(
                        'id_material' => $data['id_material'][$item],
                        'jumlah' => 0,
                        'digunakan' => $data['jumlah'][$item],
                        'id_tim' => $id_tim,
                        'created_at' => $tglold,
                        'ket' => 'Pengembalian',
                    );
                    saldomaterial::create($data2);
                }
            }
        }

        return redirect('/saldo');
    }

    public function index_history()
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $jenistiket = Jenistiket::all();
        $teamlist = Teamlist::all();
        $reminder = null;

        $saldo = saldomaterial::where('ket', 'pengembalian')->orderBy('created_at', 'DESC')->get();

        return view('content.saldom.history', compact('saldo', 'tglnow', 'jenistiket', 'teamlist', 'reminder'));
    }

    public function edit_history(Request $req, $id)
    {
        // $bln = '06';
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');

        $saldotim = saldomaterial::find($id);
        $teamlist = Teamlist::all();
        $material = Lmaterial::all();

        $id_material = $saldotim->id_material;
        $id_tim = $saldotim->id_tim;
        // $saldo = saldomaterial::whereMonth('created_at',$bln)->where( function ($query) use ($id_material){
        //     $query->where('id_material', $id_material);
        // })->where( function ($query) use ($id_tim){
        //     $query->where('id_tim', $id_tim);
        // })->get();

        // dd($saldo);

        return view('content.saldom.ehistory', compact('saldotim', 'tglnow', 'teamlist', 'material'));
    }

    public function update_history(Request $req, $id)
    {
        $saldotim = saldomaterial::find($id);
        $bln = $saldotim->created_at;
        $id_material = $req->id_material;
        $id_tim = $req->id_tim;
        $jumlah = $req->jumlah;

        // $saldotim->delete();

        $saldo = saldomaterial::where('created_at', $bln)->where(function ($query) use ($id_material) {
            $query->where('id_material', $id_material);
        })->where(function ($query) use ($id_tim) {
            $query->where('id_tim', $id_tim);
        })->get();

        $sumjumlah = $saldo->sum('jumlah');
        $sumsisa =  $saldo->sum('digunakan');

        $sumst = $saldotim->digunakan;

        $total = $sumjumlah - $sumsisa + $sumst;

        if ($total < $jumlah) {
            return redirect()->route('e.hsld', $id)->with('error', 'Jumlah Material Melebihi sisa saldo');
        } else {

            $saldotim->update([
                'id_material' => $id_material,
                'digunakan' => $jumlah,
                'ket' => 'Pengembalian'
            ]);

            return redirect()->route('hsld');
        }
    }

    public function delete_history($id)
    {
        $hs = saldomaterial::find($id);
        $hs->delete();
        return redirect('/history-saldo');
    }
}
