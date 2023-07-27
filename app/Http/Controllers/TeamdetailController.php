<?php

namespace App\Http\Controllers;

use App\Models\Jobdesk;
use App\Models\Karyawan;
use App\Models\Teamdetail;
use App\Models\Teamlist;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;

class TeamdetailController extends Controller
{
    public function index(Request $request)
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $search = $request->search;

        $karyawan = Karyawan::all();
        $teamlist = Teamlist::all();

        if ($search == null) {
            $teamdetail = Teamdetail::with(['teamlist'])->orderBy('id_team', 'ASC')->get();
            return view('content.team.detail_team.index', compact('teamdetail', 'tglnow', 'karyawan', 'teamlist'));
        } else {
            $teamdetail = Teamdetail::with(['teamlist'])->orderBy('id_team', 'ASC')->filter(request(['search']))->get();
            return view('content.team.detail_team.index', compact('teamdetail', 'tglnow', 'karyawan', 'teamlist'));
        }
    }

    public function create()
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $jobdesk = Jobdesk::where('jobdesk', 'Teknisi')->get();

        $teamdetail = Teamdetail::all();
        $karyawan = Karyawan::doesntHave('user')->doesntHave('teamdetails')->get();
        $teamlist = Teamlist::all();
        return view('content.team.detail_team.create', compact('teamdetail', 'teamlist', 'karyawan', 'jobdesk', 'tglnow'));
    }

    public function store(Request $request)
    {
        Teamdetail::create($request->except(['_token', 'submit']));

        $user_get = User::where('id_karyawan', $request->id_karyawan)->value('id');

        if ($user_get != null) {
            $user = User::where('id_karyawan', $request->id_karyawan);
            $user->update([
                'role_t' => $request->id_karyawan
            ]);
            return redirect('td');
        } else {
            return redirect('td');
        }
    }

    public function edit($id)
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $jobdesk = Jobdesk::all();
        $karyawan = Karyawan::doesntHave('teamdetails')->doesntHave('user')->get();
        $teamlist = Teamlist::doesntHave('teamdetail')->get();
        $teamdetail = Teamdetail::where('id_team', $id)->get();

        return view('content.team.detail_team.edit', compact('teamlist', 'teamdetail', 'karyawan', 'jobdesk', 'tglnow'));
    }

    public function update(Request $request, $id)
    {
        Teamdetail::where('id_team', $id)->delete();
        $data = $request->all();
        foreach ($data['id_karyawan'] as $item => $value) {
            $data2 = array(
                'id_team' => $request->id_team,
                'id_karyawan' => $data['id_karyawan'][$item],
                'id_jobdesk' => $request->id_jobdesk
            );

            Teamdetail::create($data2);
            $user_get = User::where('id_karyawan', $data['id_karyawan'][$item])->value('id');
            if ($user_get != null) {
                $user = User::where('id_karyawan', $data['id_karyawan'][$item]);
                $user->update([
                    'role_t' => $data['id_karyawan'][$item]
                ]);
                return redirect('td');
            } else {
                return redirect('td');
            }
        }

        return redirect('td');
    }

    public function delete($id)
    {
        Teamdetail::where('id_team', $id)->delete();
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
            'pdfname' => $pdfname
        ]);
        return $pdf->stream($pdfname);
    }
}
