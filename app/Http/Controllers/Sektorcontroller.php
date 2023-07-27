<?php

namespace App\Http\Controllers;

use App\Models\Sektor;
use App\Models\Sektortim;
use App\Models\Teamdetail;
use App\Models\Teamlist;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Sektorcontroller extends Controller
{
    public function index()
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $sektortim = Sektortim::all();
        $sektor = Sektor::with('teamlist')->get();
        $teamdetail = Teamdetail::all();
        $teamlist = Teamlist::all();
        return view('content.sektor.index',compact('sektor','sektortim','tglnow','teamdetail','teamlist'));
    }

    public function create()
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $sektor = Sektor::all();
        $teamlist = Teamlist::all();
        $teamdetail = Teamdetail::all();
        $nickname = "sektor";
        return view('content.sektor.create',compact('sektor','tglnow','nickname','teamlist','teamdetail'));
    }

    public function store(Request $req)
    {
        // dd($req->all());
        Sektor::create($req->all());
        return redirect('/sektor');
    }

    public function edit(Request $req, $id)
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $sektor = Sektor::find($id);
        
        $teamlist = Teamlist::all();
        $teamdetail = Teamdetail::all();
        $nickname = "sektor";
        return view('content.sektor.edit',compact('nickname','sektor','teamlist','teamdetail','tglnow'));
    }

    public function update(Request $req, $id)
    {
        Sektortim::where('id_sektor', $id)->delete();

        $data = $req->all();
        
        // dd($data['id_tim']);

        if ($req->id_tim == null){
            return redirect('/sektor');
        }else{
            foreach ($data['id_tim'] as $item => $value){
                {
                    $data2 = array(
                        'id_sektor' => $id,
                        'id_tim' => $data['id_tim'][$item]
                    );
                    Sektortim::create($data2);
                }
            }
    
        }

        

        
        // $id_tim = Teamdetail::where('id_team', $req->id_tim)->first('id');

        return redirect('/sektor');
    }

    public function delete(Request $req, $id)
    {
        $sektor = Sektor::find($id);
        $sektor->delete();
        return redirect('/sektor');
    }
}
