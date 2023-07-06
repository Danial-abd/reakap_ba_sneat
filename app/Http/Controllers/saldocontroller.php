<?php

namespace App\Http\Controllers;

use App\Models\Jenistiket;
use App\Models\Lmaterial;
use App\Models\saldomaterial;
use App\Models\Teamdetail;
use App\Models\Teamlist;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class saldocontroller extends Controller
{
    public function index()
    {
        $bln = '06';
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $jenistiket = Jenistiket::all();
        $blnakhir = $bln - 1;

        $saldo = saldomaterial::where(function ($query) use ($bln) {
            $query->whereMonth('created_at', $bln);
        })->select('id_tim', 'id_material', DB::raw('SUM(jumlah - digunakan) as total_jumlah, SUM(jumlah) as jumlah, SUM(digunakan) as guna'))->groupBy('id_material')->groupBy('id_tim')->orderBy('id_tim', 'ASC')->get();

        $sisa = saldomaterial::where(function ($query) use ($blnakhir) {
            $query->whereMonth('created_at', $blnakhir);
        })->select('id_tim', 'id_material', DB::raw('SUM(jumlah - digunakan) as total_jumlah, SUM(jumlah) as jumlah, SUM(digunakan) as guna'))->groupBy('id_material')->groupBy('id_tim')->orderBy('id_tim', 'ASC')->get();

        $team = Teamlist::select('teamlist.id as id', 'list_tim')
            ->join('saldo_material', 'teamlist.id', '=', 'saldo_material.id_tim')
            ->groupBy('list_tim', 'id')
            ->get();

        $tdetail = Teamdetail::select('teamdetail.id_team as id', 'id_jobdesk')
            ->join('teamlist', 'teamdetail.id', '=', 'teamlist.id')
            ->groupBy('id', 'id_jobdesk')->get();

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
                $info = "Pastikan Sudah Mengembalikan Material Bulan Sebelumnya";
                return view('content.saldom.saldo', compact('saldotim', 'team', 'tglnow', 'jenistiket', 'tdetail', 'teamlist','info'));
            } else {
                $info = null;
                return view('content.saldom.saldo', compact('saldotim', 'team', 'tglnow', 'jenistiket', 'tdetail', 'teamlist','info'));
            }
            
        }

        if ($sisa->sum('total_jumlah') > 0) {
            $reminder = "Beberapa Tim masih belum mengembalikan material dibulan sebelumnya";
            return view('content.saldom.saldo', compact('saldo', 'team', 'tglnow', 'jenistiket', 'tdetail', 'teamlist','reminder'));
        } else {
            $reminder = null;
            return view('content.saldom.saldo', compact('saldo', 'team', 'tglnow', 'jenistiket', 'tdetail', 'teamlist','reminder'));
        }
    }

    public function edit(Request $req, $id)
    {
        $bln = date('m');
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $material = Lmaterial::all();
        $saldotim = saldomaterial::where(function ($query) use ($id) {
            $query->where('id_tim', $id);
        })->where(function ($query) use ($bln) {
            $query->whereMonth('created_at', $bln);
        })->select('id_tim', 'id_material', DB::raw('SUM(jumlah - digunakan) as total_jumlah,  SUM(jumlah) as jumlah, SUM(digunakan) as guna'))->groupBy('id_material', 'id_tim')->get();

        if ($saldotim->count() == 0) {
            return redirect()->route('sld')->with('error', 'Data Kosong');
        }

        // dd($saldotim);
        return view('content.saldom.update', compact('saldotim', 'material', 'tglnow'));
    }

    public function update(Request $req, $id_tim)
    {

        $data = $req->all();

        if (count($data['id_material']) > 0) {
            foreach ($data['id_material'] as $item => $value) {
                $data2 = array(
                    'id_material' => $data['id_material'][$item],
                    'jumlah' => 0,
                    'digunakan' => $data['jumlah'][$item],
                    'id_tim' => $id_tim,
                    'ket' => 'Pengembalian',
                );
                saldomaterial::create($data2);
            }
        }
        return redirect('/sld');
    }
}
