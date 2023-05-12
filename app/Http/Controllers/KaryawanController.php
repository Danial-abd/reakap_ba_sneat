<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Teamlist;
use Carbon\Carbon;
use PDF;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $teamlist = Teamlist::all();
        $karyawan = Karyawan::all();
        return view('content.karyawan.index', compact('karyawan','teamlist','tglnow'));
    }

    public function search(Request $request)
    {
        $search = $request->search;

        if ($search == null) {
            $karyawan = Karyawan::all();
            return view('content.karyawan.index', compact('karyawan'));
        } else {
            $karyawan = Karyawan::where('nama', 'LIKE', '%' . $search . '%')
                ->orWhere('nik', 'LIKE', '%' . $search . '%')
                ->get();
            return view('content.karyawan.index', compact('karyawan'));
        }
    }

    public function create()
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $cek = Karyawan::count();

        if($cek == 0){
            $num = 16010050;
        }else{
            $get = Karyawan::all()->last();
            $num = 160100 . (int)substr($get->nik, -2) + 1;
        }
        return view('content.karyawan.create', compact('num','tglnow'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        Karyawan::create($request->except(['_token', 'submit']));
        return redirect('karyawan');
    }

    public function edit($id)
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $karyawan = Karyawan::find($id);
        return view('content.karyawan.edit', compact('karyawan','tglnow'));
    }

    public function update(Request $request, $id)
    {
        $karyawan = Karyawan::find($id);
        $karyawan->update($request->except(['_token', 'submit']));
        return redirect('karyawan');
    }

    public function delete($id)
    {
        $karyawan = Karyawan::find($id);
        $karyawan->delete();
        return redirect('karyawan');
    }

    public function print()
    {
        $karyawan = Karyawan::all();
        $pdfname = 'Laporan Data Karyawan.pdf';
        $pdf = PDF::loadview('content.karyawan.print', ['karyawan' => $karyawan, 'pdfname' => $pdfname]);
        return $pdf->stream($pdfname); 
    }
}
