<?php

namespace App\Http\Controllers;

use App\Models\Beritaacara;
use App\Models\Lmaterial;
use App\Models\saldomaterial;
use App\Models\Teamdetail;
use App\Models\Teamlist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Test;
use PDF;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;

class BeritaacaraController extends Controller
{
    public function index()
    {
        // ->where(function ($query) use ($bln) {
        //     $query->whereMonth('created_at', $bln);
        // })
        $bln = date('m');
        if (auth()->user()->jobdesk->jobdesk == "Teknisi") {
            $team = auth()->user()->teamdetail->teamlist->list_tim;
            $beritaacara = Beritaacara::with(['teamdetail'])->whereHas('teamdetail', function ($query) use ($team) {
                $query->whereHas('teamlist', function ($query) use ($team) {
                    $query->where('list_tim', $team);
                });
            })->orderBy('created_at', 'DESC')->filter(request(['search', 'bulan', 'tahun']))->get();
            $teamlist = Teamlist::all();
            $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
            return view('content.ba.index', compact('beritaacara', 'teamlist', 'tglnow'));
        }
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $beritaacara = Beritaacara::with(['teamdetail'])->orderBy('updated_at', 'ASC')->filter(request(['search', 'bulan', 'tahun']))->get();
        $teamlist = Teamlist::all();
        // $saldomaterial = saldomaterial::all();
        $material = Lmaterial::all();
        return view('content.ba.index', compact('material', 'beritaacara', 'teamlist', 'tglnow'));
    }


    public function create()
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $teamlist = Teamlist::all();
        $material = Lmaterial::all();
        $teamdetail = Teamdetail::with(['teamlist'])->orderBy('id_team', 'ASC')->get();

        return view('content.ba.create', compact('teamdetail', 'teamlist', 'tglnow', 'material'));
    }

    public function show($id)
    {
        $beritaacara = Beritaacara::find($id);
        $file = $beritaacara->file_ba;
        $pathToFile = public_path('doc/' . $file);

        return response()->file($pathToFile);
    }

    public function print()
    {
        $beritaacara = Beritaacara::with(['teamdetail'])->orderBy('updated_at', 'ASC')->filter(request(['search', 'bulan', 'tahun', 'team']))->get();
        $pdfname = 'Laporan Berita Acara.pdf';
        $pdf = PDF::loadview('content.ba.print', ['beritaacara' => $beritaacara, 'pdfname' => $pdfname]);
        return $pdf->stream($pdfname);
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

    public function store(Request $request)
    {
        $data = $request->all();
        $noBA = $request->no_ba;
        $idba = Beritaacara::max('id');
        $cekNo = Beritaacara::where('no_ba', $noBA)->get();
        $hitung = $cekNo->count();

        $id_ba = $idba + 1;

        if ($hitung > 0) {
            return redirect()->route('tbh.ba')->with('error', 'No Tiket Sudah Terdaftar');
        }

        $jmlcek = $request->jumlah[0];
        // dd($jmlcek);
        if ($jmlcek != null) {
            $request->validate([
                'jumlah'        => 'required',
                'no_ba'         => 'required',
                'file_ba'       => 'required|mimes:pdf',
                'id_material'   => 'required',

            ]);

            $filename = time() . '.' . $request->file('file_ba')->getClientOriginalname();
            $request->file('file_ba')->move(public_path('/doc'), $filename);

            $id = $request->id_tim;
            $id_tim = Teamdetail::where('id', $id)->value('id_team');

            Beritaacara::create(
                [
                    'file_ba' => $filename,
                    'no_ba' => $request->no_ba,
                    'id_tim' => $id,
                    'id_tl' => $id_tim,
                    'id' => $id_ba,
                ],
            );

            if (count($data['id_material']) > 0) {


                // dd($data['id_material'][$item]);
                foreach ($data['id_material'] as $item => $value) {
                    if ($data['id_material'][$item] == 1) {
                        $data2 = array(
                            'id_material' => $data['id_material'][$item],
                            'id_ba' => $id_ba,
                            'jumlah' => $data['jumlah'][$item] * 1000,
                            'digunakan' => 0,
                            'id_tim' => $id_tim
                        );

                        saldomaterial::create($data2);
                    } else {
                        $data2 = array(
                            'id_material' => $data['id_material'][$item],
                            'id_ba' => $id_ba,
                            'jumlah' => $data['jumlah'][$item],
                            'digunakan' => 0,
                            'id_tim' => $id_tim
                        );

                        saldomaterial::create($data2);
                    }
                }
            }

            return redirect('/ba')->with('success', 'Berhasil Menambahkan Data');
        } else if ($jmlcek == null) {

            $request->validate([
                'jumlah'        => 'required|integer',
                'no_ba'         => 'required',
                'file_ba'       => 'required|mimes:pdf',
                'id_material'   => 'required',
            ]);

            return redirect('/ba')->with('success', 'Berhasil Menambahkan Data');
        }
    }

    public function edit($id)
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $teamdetail = Teamdetail::with(['teamlist'])->orderBy('id_team', 'ASC')->get();
        $beritaacara = Beritaacara::find($id);
        $material = Lmaterial::all();
        return view('content.ba.edit', compact('material', 'teamdetail', 'beritaacara', 'tglnow'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'file_ba' => 'mimes:pdf',
            // 'id_material'=>['required'],
            // 'jumlah'=>['required']
        ]);

        $data = $request->all();

        $beritaacara = Beritaacara::find($id);
        // $slmaterial = Beritaacara::with(['saldomaterial'])->find($id);

        saldomaterial::where('id_ba', $id)->delete();

        if ($request->file('file_ba') == null) {
            $beritaacara->update([
                'no_ba' => $request->no_ba,
                'id_tim' => $request->id_tim
            ],);
        } else {
            $filename = time() . '.' . $request->file('file_ba')->getClientOriginalname();
            $request->file('file_ba')->move(public_path('/doc'), $filename);

            $beritaacara->update([
                'file_ba' => $filename,
                'no_ba' => $request->no_ba,
                'id_tim' => $request->id_tim
            ],);
        }

        if (count($data['newid_material']) > 0) {
            foreach ($data['newid_material'] as $item => $value) {
                if ($data['newid_material'][$item] == 1) {
                    $data2 = array(
                        'id_material' => $data['newid_material'][$item],
                        'id_ba' => $id,
                        'jumlah' => $data['newjumlah'][$item] * 1000,
                        'digunakan' => 0,
                        'id_tim' => $request->id_tim,
                    );

                    saldomaterial::create($data2);
                } else {
                    $data2 = array(
                        'id_material' => $data['newid_material'][$item],
                        'id_ba' => $id,
                        'jumlah' => $data['newjumlah'][$item],
                        'digunakan' => 0,
                        'id_tim' => $request->id_tim,
                    );

                    saldomaterial::create($data2);
                }
            }
        }

        return redirect('/ba');
    }

    public function delete($id)
    {
        $beritaacara = Beritaacara::find($id);
        $file = $beritaacara->file_ba;
        $pathToFile = public_path('doc/' . $file);
        File::delete($pathToFile);
        $beritaacara->delete();
        return redirect('/ba');
    }
}
