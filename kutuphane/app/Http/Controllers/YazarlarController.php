<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Yazar;
use App\Http\Requests\YazarlarStoreRequest;
use App\Http\Requests\YazarlarUpdateRequest;

class YazarlarController extends Controller
{
    public function index(){
        $yazarlar = Yazar::all();
        return view('yazarlar.index', compact('yazarlar'));
    }
    public function create(){
        return view('yazarlar.create');
    }
    public function store(YazarlarStoreRequest $request){
        Yazar::create($request->all());
        return redirect()->route('yazarlar.index')->with('success', 'Yazar başarıyla eklendi');
    }
    public function show($id){
        $yazar = Yazar::findOrFail($id);
        return view('yazarlar.show', compact('yazar'));
    }
    public function edit($id){
        $yazar = Yazar::findOrFail($id);
        return view('yazarlar.edit', compact('yazar'));
    }
    public function update(YazarlarUpdateRequest $request, $id){
        $yazar = Yazar::findOrFail($id);
        $yazar->update($request->all());
        return redirect()->route('yazarlar.index')->with('success', 'Yazar başarıyla güncellendi');
    }
    public function destroy($id){
        $yazar = Yazar::findOrFail($id);
        $yazar->delete();
        return redirect()->route('yazarlar.index')->with('success', 'Yazar başarıyla silindi');
    }
    public function search(Request $request){
        $search = $request->input('search');
        $yazarlar = Yazar::where('isim', 'like', "%$search%")->get();
        return view('yazarlar.index', compact('yazarlar'));
    }
}
