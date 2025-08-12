<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use App\Http\Requests\AuthorStoreRequest;
use App\Http\Requests\AuthorUpdateRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AuthorController extends Controller
{
    public function index() : View
    {
        $authors = Author::all();
        return view('authors.index', compact('authors'));
    }
    public function create() : View
    {
        return view('authors.create');
    }
    public function store(AuthorStoreRequest $request) : RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'required|string|max:255',
            'birth_date' => 'required|date',
        ]);
        Author::create($request->all());
        return redirect()->route('authors.index')->with('success', 'Yazar başarıyla eklendi');
    }
    public function show(Author $author) : View
    {

        return view('authors.show', compact('author'));
    }
    public function edit(Author $author) : View
    {
        return view('authors.edit', compact('author'));
    }
    public function update(AuthorUpdateRequest $request, Author $author) : RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'required|string|max:255',
            'birth_date' => 'required|date',
        ]);
        $author->update($request->all());
        return redirect()->route('authors.index')->with('success', 'Yazar başarıyla güncellendi');
    }
    public function destroy(Author $author) : RedirectResponse
    {
        $author->delete();
        return redirect()->route('authors.index')->with('success', 'Yazar başarıyla silindi');
    }
    public function search(Request $request) : View|RedirectResponse    
    {
        $search = trim($request->input('search'));

        if (strlen($search) < 3) {
            return redirect()->route('authors.index')->with('error', 'Arama kelimesi en az 3 karakter olmalıdır');
        } else {
            $authors = Author::where('name', 'like', "%$search%")
                ->orWhere('bio', 'like', "%$search%")
                ->orWhere('birth_date', 'like', "%$search%")
                ->get();
        }

        return view('authors.index', compact('authors', 'search'));
    }
}
