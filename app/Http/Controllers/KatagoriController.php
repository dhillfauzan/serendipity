<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\katagori;

class KatagoriController extends Controller
{
    public function index()
    {
        $katagori = katagori::orderBy('nama_katagori', 'asc')->get();
        return view('backend.katagori.index', [
        'judul' => 'Katagori',
        'index' => $katagori
        ]);

    }
    public function create()
    {
        return view('backend.katagori.create', [
            'judul' => 'Katagori',
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       // dd($request);
    $validatedData = $request->validate([
    'nama_katagori' => 'required|max:255|unique:katagori',
    ]);
    katagori::create($validatedData);
    return redirect()->route('backend.katagori.index')->with('success', 'Data berhasil tersimpan');
    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $katagori = katagori::find($id);
        return view('backend.katagori.edit', [
        'judul' => 'Katagori',
        'edit' => $katagori
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'nama_katagori' => 'required|max:255|unique:katagori,nama_katagori,' . $id,
            ];
            $validatedData = $request->validate($rules);
            katagori::where('id', $id)->update($validatedData);
            return redirect()->route('backend.katagori.index')->with('success', 'Data berhasil diperbaharui');
            
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = katagori::findOrFail($id);
        $user->delete();
        return redirect()->route('backend.katagori.index')->with('success', 'Data berhasil dihapus');
        
    }
}


