<?php

namespace App\Http\Controllers;

use App\Models\Ggnpenyebab;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ggnpenyebabcontroller extends Controller
{
    public function index(Request $request)
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $Ggnpenyebab = Ggnpenyebab::all();
        return view('content.penyebab.index', compact('Ggnpenyebab','tglnow'));
    }

    public function create()
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $nickname = "pg";
        return view('content.penyebab.create', compact('tglnow','nickname'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        Ggnpenyebab::create($request->all());
        return redirect('/pg-ggn');
    }

    public function edit($id)
    {
        $nickname = "pg";
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $Ggnpenyebab = Ggnpenyebab::find($id);  
        return view('content.penyebab.edit', compact('Ggnpenyebab','tglnow','nickname'));
    }

    public function update(Request $request, $id)
    {
        $Ggnpenyebab = Ggnpenyebab::find($id);
        $Ggnpenyebab->update($request->except(['_token', 'submit']));
        return redirect('/pg-ggn');
    }

    public function delete($id)
    {
        $Ggnpenyebab = Ggnpenyebab::find($id);
        $Ggnpenyebab->delete();
        return redirect('/pg-ggn');
    }
}
