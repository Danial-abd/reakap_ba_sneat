<?php

namespace App\Http\Controllers;

use App\Models\Lmaterial as ModelMaterial;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Lmaterial extends Controller
{
    public function index()
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $material = ModelMaterial::all();
        return view('content.material.index', compact('tglnow','material'));
        
    }

    public function create()
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        // $material = ModelMaterial::all();
        return view('content.material.create', compact('tglnow'));
    }

    public function store(Request $req)
    {
        $data = $req->all();

        foreach ($data['job'] as $index => $value){
            ModelMaterial::create([
                'kd_material' => $req->kd_material,
                'nama_material' => $req->nama_material,
                'job' => $data['job'][$index],
            ]);
        }    
        
        return redirect('lmaterial');
    }

    public function edit($id)
    {
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $material = ModelMaterial::find($id);
        return view('content.material.edit', compact('tglnow','material'));
    }

    public function update(Request $req,$id)
    {
        $material = ModelMaterial::find($id);
        $material->update($req->except(['_token', 'submit']));
        return redirect('lmaterial');
    }

    public function delete($id)
    {
        $material = ModelMaterial::find($id);
        $material->delete();
        return redirect('lmaterial');
    }

    public function search(Request $request)
    {
        $search = $request->search;
        $tglnow = Carbon::now()->isoFormat('dddd, D MMMM Y');

        if ($search == null) {
            $material = ModelMaterial::all();
            return view('content.material.index', compact('tglnow','material'));
        } else {
            $material = ModelMaterial::where('nama_material', 'LIKE', '%' . $search . '%')
                ->orWhere('kd_material', 'LIKE', '%' . $search . '%')
                ->get();
            return view('content.material.index', compact('material','tglnow'));
        }
    }
}
