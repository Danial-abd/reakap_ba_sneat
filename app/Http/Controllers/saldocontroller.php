<?php

namespace App\Http\Controllers;

use App\Models\Jenistiket;
use App\Models\Lmaterial;
use App\Models\saldomaterial;
use App\Models\Teamdetail;
use App\Models\Teamlist;
use App\Models\Tikettim;
use PDF;
use DateTime;
use Illuminate\Contracts\Database\Eloquent\Builder;
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

        $idpsb = Teamdetail::where('id_jobdesk', 3)->select('id_team')->groupBy('id_team')->pluck('id_team');
        // dd($req->bulan);

        $sisa = saldomaterial::where(function ($query) use ($blnakhir, $idpsb) {
            $query->whereMonth('created_at', $blnakhir)->whereIn('id_tim', $idpsb);
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



            // dd($stimakhir->sum('total_jumlah'));
            if (auth()->user()->teamdetail->id_jobdesk == 3) {
                $saldotim = saldomaterial::where(function ($query) use ($id) {
                    $query->where('id_tim', $id);
                })->where(function ($query) use ($bln) {
                    $query->whereMonth('created_at', $bln);
                })->select('id_tim', 'id_material', DB::raw('SUM(jumlah - digunakan) as total_jumlah,  SUM(jumlah) as jumlah, SUM(digunakan) as guna'))->groupBy('id_material', 'id_tim')->get();
                if ($stimakhir->sum('total_jumlah') > 0) {
                    $info = "Anda Belum Mengembalikan semua Material di bulan sebelumnya";
                    return view('content.saldom.saldo', compact('saldotim', 'team', 'tglnow', 'jenistiket', 'tdetail', 'teamlist', 'info'));
                } else {
                    $info = null;
                    return view('content.saldom.saldo', compact('saldotim', 'team', 'tglnow', 'jenistiket', 'tdetail', 'teamlist', 'info'));
                }
            }

            $saldotim = saldomaterial::where(function ($query) use ($id) {
                $query->where('id_tim', $id);
            })->select('id_tim', 'id_material', DB::raw('SUM(jumlah - digunakan) as total_jumlah,  SUM(jumlah) as jumlah, SUM(digunakan) as guna'))->groupBy('id_material', 'id_tim')->get();
            return view('content.saldom.saldo', compact('saldotim', 'team', 'tglnow', 'jenistiket', 'tdetail', 'teamlist'));
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

        $material = Lmaterial::where('job', 'PSB')->get();

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
        return view('content.saldom.update', compact('bln', 'nickname', 'tl', 'saldotim', 'bln', 'material', 'tglnow'));
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
        $material = Lmaterial::where('job', 'PSB')->get();

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

    public function index_total(Request $req)
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $jtiket = Jenistiket::all();
        $teampsb = Teamdetail::where('id_jobdesk', 3)->select('id_team')->groupBy('id_team')->pluck('id_team');
        $teamggn = Teamdetail::where('id_jobdesk', 7)->select('id_team')->groupBy('id_team')->pluck('id_team');
        $teammtn = Teamdetail::where('id_jobdesk', 8)->select('id_team')->groupBy('id_team')->pluck('id_team');


        if ($req->bulan == null) {
            
            $bulan = date('m');
            $tiketggn = Tikettim::whereMonth('created_at', $bulan)->where('id_j_tiket', 1)->count();
            $tiketpsb = Tikettim::whereMonth('created_at', $bulan)->where('id_j_tiket', 2)->count();
            $tiketmtn = Tikettim::whereMonth('created_at', $bulan)->where('id_j_tiket', 3)->count();

            $saldopsb = saldomaterial::where(function ($query) use ($bulan) {
                $query->whereMonth('created_at', $bulan);
            })->where('ket', null)->whereIn('id_tim', $teampsb)->select('id_material', DB::raw('SUM(jumlah - digunakan) as total_jumlah, SUM(jumlah) as jumlah, SUM(digunakan) as guna'))->groupBy('id_material')->get();
            $saldoggn = saldomaterial::where(function ($query) use ($bulan) {
                $query->whereMonth('created_at', $bulan);
            })->where('ket', null)->whereIn('id_tim', $teamggn)->select('id_material', DB::raw('SUM(jumlah - digunakan) as total_jumlah, SUM(jumlah) as jumlah, SUM(digunakan) as guna'))->groupBy('id_material')->filter(request(['search', 'bulan']))->get();
            $saldomtn = saldomaterial::where(function ($query) use ($bulan) {
                $query->whereMonth('created_at', $bulan);
            })->where('ket', null)->whereIn('id_tim', $teammtn)->select('id_material', DB::raw('SUM(jumlah - digunakan) as total_jumlah, SUM(jumlah) as jumlah, SUM(digunakan) as guna'))->groupBy('id_material')->filter(request(['search', 'bulan']))->get();

            return view('content.saldom.ts', compact('tiketggn', 'tiketmtn', 'tiketpsb', 'saldopsb', 'saldomtn', 'saldoggn', 'jtiket', 'tglnow'));
        
        } else if ($req->bulan != null) {

            $bulan = $req->bulan;
            $tiketggn = Tikettim::whereMonth('created_at', $bulan)->where('id_j_tiket', 1)->count();
            $tiketpsb = Tikettim::whereMonth('created_at', $bulan)->where('id_j_tiket', 2)->count();
            $tiketmtn = Tikettim::whereMonth('created_at', $bulan)->where('id_j_tiket', 3)->count();

            $saldopsb = saldomaterial::where(function ($query) use ($bulan) {
                $query->whereMonth('created_at', $bulan);
            })->where('ket', null)->whereIn('id_tim', $teampsb)->select('id_material', DB::raw('SUM(jumlah - digunakan) as total_jumlah, SUM(jumlah) as jumlah, SUM(digunakan) as guna'))->groupBy('id_material')->filter(request(['search', 'bulan']))->get();
            $saldoggn = saldomaterial::where(function ($query) use ($bulan) {
                $query->whereMonth('created_at', $bulan);
            })->where('ket', null)->whereIn('id_tim', $teamggn)->select('id_material', DB::raw('SUM(jumlah - digunakan) as total_jumlah, SUM(jumlah) as jumlah, SUM(digunakan) as guna'))->groupBy('id_material')->filter(request(['search', 'bulan']))->get();
            $saldomtn = saldomaterial::where(function ($query) use ($bulan) {
                $query->whereMonth('created_at', $bulan);
            })->where('ket', null)->whereIn('id_tim', $teammtn)->select('id_material', DB::raw('SUM(jumlah - digunakan) as total_jumlah, SUM(jumlah) as jumlah, SUM(digunakan) as guna'))->groupBy('id_material')->filter(request(['search', 'bulan']))->get();


            return view('content.saldom.ts', compact('tiketggn', 'tiketmtn', 'tiketpsb', 'saldopsb', 'saldomtn', 'saldoggn', 'jtiket', 'tglnow'));
        }
    }

    public function pengembalian(Request $req)
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $blnnow = date('m');
        $blnakhir = $blnnow - 1;

        $idpsb = Teamdetail::where('id_jobdesk', 3)->select('id_team')->groupBy('id_team')->pluck('id_team');

        $sisa = saldomaterial::where(function ($query) use ($blnakhir, $idpsb) {
            $query->whereMonth('created_at', $blnakhir)->whereIn('id_tim', $idpsb);
        })->select('id_tim', 'id_material', DB::raw('SUM(jumlah - digunakan) as total_jumlah, SUM(jumlah) as jumlah, SUM(digunakan) as guna'))->groupBy('id_material')->groupBy('id_tim')->orderBy('id_tim', 'ASC')->get();

        $teampsb = Teamlist::whereHas('teamdetail', function ($query) {
            $query->where('id_jobdesk', 3);
        })->get();


        if ($req->bulan == null) {
            $bln = date('m');
            $saldo = saldomaterial::where(function ($query) use ($bln) {
                $query->whereMonth('created_at', $bln);
            })->select('id_tim', 'id_material', DB::raw('SUM(jumlah - digunakan) as total_jumlah, SUM(jumlah) as jumlah, SUM(digunakan) as guna,  SUM(digunakan) as guna'))->groupBy('id_tim', 'id_material')->orderBy('id_tim', 'ASC')->filter(request(['search', 'bulan']))->get();
            $pengembalian = saldomaterial::where(function ($query) use ($bln) {
                $query->whereMonth('created_at', $bln);
            })->where('ket', 'Pengembalian')->select('id_tim', 'id_material', DB::raw('SUM(jumlah - digunakan) as total_jumlah, SUM(jumlah) as jumlah'))->groupBy('id_tim', 'id_material')->orderBy('id_tim', 'ASC')->filter(request(['search', 'bulan']))->get();

            if ($sisa->sum('total_jumlah') > 0) {
                $reminder = "Beberapa Tim masih belum melakukan pengembalian material";
                return view('content.saldom.mk', compact('pengembalian', 'saldo', 'teampsb', 'tglnow', 'reminder'));
            } else {
                $reminder = null;
                return view('content.saldom.mk', compact('pengembalian', 'saldo', 'teampsb', 'tglnow', 'reminder'));
            }
        } else if ($req->bulan != null) {
            $bln = $req->bulan;
            $saldo = saldomaterial::where(function ($query) use ($bln) {
                $query->whereMonth('created_at', $bln);
            })->select('id_tim', 'id_material', DB::raw('SUM(jumlah - digunakan) as total_jumlah, SUM(jumlah) as jumlah, SUM(digunakan) as guna'))->groupBy('id_tim', 'id_material')->orderBy('id_tim', 'ASC')->filter(request(['search', 'bulan']))->get();
            $pengembalian = saldomaterial::where(function ($query) use ($bln) {
                $query->whereMonth('created_at', $bln);
            })->where('ket', 'Pengembalian')->select('id_tim', 'id_material', DB::raw('SUM(jumlah - digunakan) as total_jumlah, SUM(jumlah) as jumlah, SUM(digunakan) as guna'))->groupBy('id_tim', 'id_material')->orderBy('id_tim', 'ASC')->filter(request(['search', 'bulan']))->get();

            if ($sisa->sum('total_jumlah') > 0) {
                $reminder = "Beberapa Tim masih belum melakukan pengembalian material";
                return view('content.saldom.mk', compact('pengembalian', 'saldo', 'teampsb', 'tglnow', 'reminder'));
            } else {
                $reminder = null;
                return view('content.saldom.mk', compact('pengembalian', 'saldo', 'teampsb', 'tglnow', 'reminder'));
            }
        }
    }

    public function print_mk(Request $req)
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

        $carbon = Carbon::createFromDate(null, $bln, null)->isoFormat('MMMM');
        $teampsb = Teamdetail::where('id_jobdesk', 3)->select('id_team')->groupBy('id_team')->pluck('id_team');

        $saldopsb = saldomaterial::whereMonth('created_at', $bln)->whereIn('id_tim', $teampsb)->select('id_tim', 'id_material', DB::raw('SUM(jumlah - digunakan) as total_jumlah, SUM(jumlah) as jumlah, SUM(digunakan) as guna'))->groupBy('id_tim', 'id_material')->filter(request(['search', 'bulan']))->havingRaw('SUM(jumlah - digunakan) > 0')->get();

        $teampsb = Teamdetail::where('id_jobdesk', 3)->select('id_team')->groupBy('id_team')->pluck('id_team');

        $team = Teamlist::whereIn('id', $teampsb)->get();

        // dd($team);

        // dd($saldopsb);
        $pdfname = 'Pengembalian Material bulan-' . $carbon . '.pdf';
        $name = 'Pengembalian Material';
        $pdf = PDF::loadview('content.saldom.pk', ['team' => $team, 'bln' => $carbon, 'saldopsb' => $saldopsb, 'pdfname' => $name])->setPaper('A4', 'potrait');
        return $pdf->stream($pdfname);
    }

    public function print_tm(Request $req)
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

        $teampsb = Teamdetail::where('id_jobdesk', 3)->select('id_team')->groupBy('id_team')->pluck('id_team');
        $teamggn = Teamdetail::where('id_jobdesk', 7)->select('id_team')->groupBy('id_team')->pluck('id_team');
        $teammtn = Teamdetail::where('id_jobdesk', 8)->select('id_team')->groupBy('id_team')->pluck('id_team');

        $saldopsb = saldomaterial::whereMonth('created_at', $bln)
            ->where('ket', null)->whereIn('id_tim', $teampsb)->select('id_material', DB::raw('SUM(jumlah - digunakan) as total_jumlah, SUM(jumlah) as jumlah, SUM(digunakan) as guna'))->groupBy('id_material')->filter(request(['search', 'bulan']))->get();
        $saldoggn = saldomaterial::whereMonth('created_at', $bln)
        ->where('ket', null)->whereIn('id_tim', $teamggn)->select('id_material', DB::raw('SUM(jumlah - digunakan) as total_jumlah, SUM(jumlah) as jumlah, SUM(digunakan) as guna'))->groupBy('id_material')->get();
        $saldomtn = saldomaterial::whereMonth('created_at', $bln)
        ->where('ket', null)->whereIn('id_tim', $teammtn)->select('id_material', DB::raw('SUM(jumlah - digunakan) as total_jumlah, SUM(jumlah) as jumlah, SUM(digunakan) as guna'))->groupBy('id_material')->get();

        $tiketggn = Tikettim::whereMonth('created_at', $bln)->where('id_j_tiket', 1)->count();
        $tiketpsb = Tikettim::whereMonth('created_at', $bln)->where('id_j_tiket', 2)->count();
        $tiketmtn = Tikettim::whereMonth('created_at', $bln)->where('id_j_tiket', 3)->count();

        // dd($saldopsb);
        $pdfname = 'Total Material-' . $carbon . '.pdf';
        $name = 'Total Material Pekerjaan';
        $pdf = PDF::loadview('content.saldom.tm', [
            'tiketpsb' => $tiketpsb,
            'tiketggn' => $tiketggn,
            'tiketmtn' => $tiketmtn,
            'bln' => $carbon,
            'saldopsb' => $saldopsb,
            'saldoggn' => $saldoggn,
            'saldomtn' => $saldomtn,
            'pdfname' => $name
        ])->setPaper('A4', 'potrait');
        return $pdf->stream($pdfname);
    }
}
