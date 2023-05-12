<?php

namespace App\Http\Controllers;

use App\Models\Jobdesk;
use App\Models\Karyawan;
use App\Models\Teamdetail;
use App\Models\Teamlist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;

class TeamdetailController extends Controller
{
    public function index(Request $request)
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $search = $request->search;

        $teamlist = Teamlist::all();

        if ($search == null) {
            $teamdetail = Teamdetail::with(['teamlist'])->orderBy('id_team', 'ASC')->get();
            return view('content.team.detail_team.index', compact('teamdetail','tglnow'));
        } else {
            $teamdetail = Teamdetail::with(['teamlist'])->orderBy('id_team', 'ASC')->filter(request(['search']))->get();
            return view('content.team.detail_team.index', compact('teamdetail','tglnow'));
        }
    }

    public function create()
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $jobdesk = Jobdesk::where('jobdesk','Teknisi')->get();
        $karyawan = Karyawan::all();
        $teamlist = Teamlist::all();
        return view('content.team.detail_team.create', compact('teamlist','karyawan','jobdesk','tglnow'));
    }

    public function store(Request $request)
    {
        Teamdetail::create($request->except(['_token','submit']));
        return redirect('td');
    }

    public function edit($id)
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $jobdesk = Jobdesk::all();
        $karyawan = Karyawan::all();
        $teamlist = Teamlist::all();
        $teamdetail = Teamdetail::find($id);
        return view('content.team.detail_team.edit', compact('teamlist','teamdetail','karyawan','jobdesk','tglnow')); 
    }

    public function update(Request $request, $id)
    {
        $teamdetail = Teamdetail::find($id);
        $teamdetail->update($request->except(['_token','submit']));
        return redirect('td');
    }

    public function delete($id)
    {
        $teamdetail = Teamdetail::find($id);
        $teamdetail->delete();
        return redirect('td');
    }

    public function print()
    {
        $jobdesk = Jobdesk::all();
        $karyawan = Karyawan::all();
        $teamlist = Teamlist::all();
        $teamdetail = Teamdetail::all();
        $pdfname = 'Daftar Anggota Tim.pdf';
        $pdf = PDF::loadview('content.team.detail_team.print', [
            'teamlist' => $teamlist,
            'jobdesk' => $jobdesk,
            'karyawan' => $karyawan,
            'teamdetail' => $teamdetail, 
            'pdfname' => $pdfname]);
        return $pdf->stream($pdfname);
    }



}
