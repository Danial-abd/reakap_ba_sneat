<?php

namespace App\Http\Controllers;

use App\Models\Jobdesk;
use Carbon\Carbon;
use Illuminate\Http\Request;

class JobdeskController extends Controller
{
    public function index()
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $jobdesk = Jobdesk::all();
        return view('content.jobdesk.index', compact('jobdesk','tglnow'));
    }

    public function search(Request $request)
    {
        $search = $request->search;

        if ($search == null) {
            $jobdesk = Jobdesk::all();
            return view('content.jobdesk.index', compact('jobdesk'));
        } else {
            $jobdesk = Jobdesk::where('jobdesk','LIKE','%'.$search.'%')
            ->orWhere('kd_jd','LIKE','%'.$search.'%')
            ->get();
            return view('content.jobdesk.index', compact('jobdesk'));
        }
    }

    public function create()
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $cek = Jobdesk::count();

        if($cek == 0){
            $num = 01;
            $an = 'jd' . $num;
        }else{
            $get = Jobdesk::all()->last();
            $num = 0 . (int)substr($get->kd_jd, -2) + 1;
            $an = 'jd' . $num;
        }

        return view('content.jobdesk.create', compact('an','tglnow'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        Jobdesk::create($request->except(['_token','submit']));
        return redirect('jd');
    }

    public function edit($id)
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $jobdesk = Jobdesk::find($id);
        return view('content.jobdesk.edit', compact('jobdesk','tglnow'));
    }

    public function update(Request $request, $id)
    {
        $jobdesk = Jobdesk::find($id);
        $jobdesk->update($request->except(['_token','submit']));
        return redirect('jd');
    }

    public function delete($id)
    {
        $jobdesk = Jobdesk::find($id);
        $jobdesk->delete();
        return redirect('jd');
    }
}
