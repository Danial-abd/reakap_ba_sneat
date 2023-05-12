<?php

namespace App\Http\Controllers;

use App\Models\Jenistiket;
use Carbon\Carbon;
use Illuminate\Http\Request;

class JenistiketController extends Controller
{
    public function index(Request $request)
    {
        // $jenistiket = Jenistiket::all();
        // return view('content.tiket.j-tiket', compact('jenistiket'));
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $search = $request->search;

        if ($search == null) {
            $jenistiket = Jenistiket::all();
            return view('content.tiket.j-tiket', compact('jenistiket','tglnow'));
        } else {
            $jenistiket = Jenistiket::where('nama_tiket', 'LIKE' ,'%' . $search . '%')
                ->get();
            return view('content.tiket.j-tiket', compact('jenistiket','tglnow'));
        }
    }

    // public function search(Request $request)
    // {
    //     $search = $request->search;

    //     if ($search == null) {
    //         $jenistiket = Jenistiket::all();
    //         return view('content.tiket.j-index', compact('jenistiket'));
    //     } else {
    //         $jenistiket = Jenistiket::where('nama_tiket', '%' . $search . '%')
    //             ->get();
    //         return view('content.tiket.j-tiket', compact('jenistiket'));
    //     }
    // }

    public function create()
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        return view('content.tiket.j-create', compact('tglnow'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        Jenistiket::create($request->except(['_token', 'submit']));
        return redirect('/jtiket');
    }

    public function edit($id)
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $jenistiket = Jenistiket::find($id);
        return view('content.tiket.j-edit', compact('jenistiket','tglnow'));
    }

    public function update(Request $request, $id)
    {
        $jenistiket = Jenistiket::find($id);
        $jenistiket->update($request->except(['_token', 'submit']));
        return redirect('/jtiket');
    }

    public function delete($id)
    {
        $jenistiket = Jenistiket::find($id);
        $jenistiket->delete();
        return redirect('/jtiket');
    }
}
