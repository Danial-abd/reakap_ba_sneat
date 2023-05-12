<?php

namespace App\Http\Controllers;

use App\Models\Teamlist;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TeamlistController extends Controller
{
    public function index(Request $request)
    {
        // $jenistiket = Jenistiket::all();
        // return view('content.tiket.j-tiket', compact('jenistiket'));
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $search = $request->search;

        if ($search == null) {
            $teamlist = Teamlist::orderBy('list_tim', 'ASC')->get();
            return view('content.team.list_team.index', compact('teamlist','tglnow'));
        } else {
            $teamlist = Teamlist::where('list_tim', 'LIKE' ,'%' . $search . '%')
                ->orderBy('list_tim', 'ASC')->get();
            return view('content.team.list_team.index', compact('teamlist','tglnow'));
        }
    }
    
    public function create()
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        return view('content.team.list_team.create', compact('tglnow'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        Teamlist::create($request->except(['_token', 'submit']));
        return redirect('/tl');
    }

    public function edit($id)
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $teamlist = Teamlist::find($id);
        return view('content.team.list_team.edit', compact('teamlist','tglnow'));
    }

    public function update(Request $request, $id)
    {
        $teamlist = Teamlist::find($id);
        $teamlist->update($request->except(['_token', 'submit']));
        return redirect('/tl');
    }

    public function delete($id)
    {
        $teamlist = Teamlist::find($id);
        $teamlist->delete();
        return redirect('/tl');
    }
}
