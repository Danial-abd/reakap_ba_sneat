<?php

namespace App\Http\Controllers;

use App\Models\Beritaacara;
use App\Models\Teamdetail;
use App\Models\Teamlist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PHPUnit\Framework\Test;
use PDF;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;

class BeritaacaraController extends Controller
{
    public function index()
    {

        if (auth()->user()->jobdesk->jobdesk == "Teknisi") {
            $team = auth()->user()->teamdetail->teamlist->list_tim;
            $beritaacara = Beritaacara::with(['teamdetail'])->whereHas('teamdetail', function ($query) use ($team){
                $query->whereHas('teamlist', function ($query) use ($team){
                    $query->where('list_tim', $team);
                });
            })->orderBy('updated_at', 'ASC')->filter(request(['search', 'bulan', 'tahun']))->get();
            $teamlist = Teamlist::all();
            $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
            return view('content.ba.index', compact('beritaacara', 'teamlist','tglnow'));
        }
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $beritaacara = Beritaacara::with(['teamdetail'])->orderBy('updated_at', 'ASC')->filter(request(['search', 'bulan', 'tahun']))->get();
        $teamlist = Teamlist::all();
        return view('content.ba.index', compact('beritaacara','teamlist','tglnow'));
    }


    public function create()
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $teamlist = Teamlist::all();
        $teamdetail = Teamdetail::with(['teamlist'])->orderBy('id_team', 'ASC')->get();

        return view('content.ba.create', compact('teamdetail', 'teamlist','tglnow'));
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
        $noBA = $request->no_ba;
        $cekNo = Beritaacara::where('no_ba', $noBA)->get();
        $hitung = $cekNo->count();
        
        if($hitung > 0 ){
            return redirect()->route('tbh.ba')->with('error', 'No Tiket Sudah Terdaftar');
        }

        $this->validate($request, [
            'file_ba' => 'required|mimes:pdf',
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
            ],
        );
        return redirect('/ba')->with('success', 'Berhasil Menambahkan Data');
    }

    public function edit($id)
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $teamdetail = Teamdetail::with(['teamlist'])->orderBy('id_team', 'ASC')->get();
        $beritaacara = Beritaacara::find($id);
        return view('content.ba.edit', compact('teamdetail', 'beritaacara','tglnow'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'file_ba' => 'mimes:pdf'
        ]);

        $beritaacara = Beritaacara::find($id);

        if ($request->file('file_ba') == null) {
            $beritaacara->update([
                'no_ba' => $request->no_ba,
                'id_tim' => $request->id_tim
            ],);
            return redirect('/ba');
        } else {
            $filename = time() . '.' . $request->file('file_ba')->getClientOriginalname();
            $request->file('file_ba')->move(public_path('/doc'), $filename);

            $beritaacara->update([
                'file_ba' => $filename,
                'no_ba' => $request->no_ba,
                'id_tim' => $request->id_tim
            ],);
            return redirect('/ba');
        }
    }

    public function delete($id)
    {
        $beritaacara = Beritaacara::find($id);
        $beritaacara->delete();
        return redirect('/ba');
    }
}
