<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use App\Http\Requests\AuthorStoreRequest;
use App\Http\Requests\AuthorUpdateRequest;

class AuthorController extends Controller
{
    public function index(){
        $authors = Author::all();
        return view('authors.index', compact('authors'));
    }
    public function create(){
        return view('authors.create');
    }
    public function store(AuthorStoreRequest $request){
        Author::create($request->all());
        return redirect()->route('authors.index')->with('success', 'Yazar başarıyla eklendi');
    }
    public function show(Author $author){
        return view('authors.show', compact('author'));
    }
    public function edit(Author $author){
        return view('authors.edit', compact('author'));
    }
    public function update(AuthorUpdateRequest $request, Author $author){
        $author->update($request->all());
        return redirect()->route('authors.index')->with('success', 'Yazar başarıyla güncellendi');
    }
    public function destroy(Author $author){
        $author->delete();
        return redirect()->route('authors.index')->with('success', 'Yazar başarıyla silindi');
    }
    public function search(Request $request){
        $search = $request->input('search');
        $authors = Author::where('name', 'like', "%$search%")->get();
        return view('authors.index', compact('authors'));
    }
}
