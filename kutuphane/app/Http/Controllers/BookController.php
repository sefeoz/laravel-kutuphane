<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\BookUpdateRequest;


class BookController extends Controller
{
    public function index(){
        $books = Book::all();
        return view('books.index', compact('books'));
    }
    public function create(){
        return view('books.create');
    }
    public function store(BookStoreRequest $request){
        try {
            $data = $request->validated();
            if ($request->hasFile('image') && $request->file('image')->isValid()) { 
                $data['image'] = $request->file('image')->store('images', 'public');
            }
            Book::create($data);
            return redirect()->route('books.index')->with('success', 'Kitap başarıyla oluşturuldu');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Hata: ' . $e->getMessage())->withInput();
        }
    }
    public function edit($id){
        $book = Book::findOrFail($id);
        return view('books.edit', compact('book'));
    }
    public function update(BookUpdateRequest $request, $id){
        $data = $request->validated();
        $book = Book::findOrFail($id);
        $book->update($data);
        return redirect()->route('books.index')->with('success', 'Kitap başarıyla güncellendi');
    }
    public function destroy($id){
        $book = Book::findOrFail($id);
        $book->delete();
        return redirect()->route('books.index');
    }
    public function show($id){
        $book = Book::findOrFail($id);
        return view('books.show', compact('book'));
    }
    public function search(Request $request){
        $search = $request->input('search');
        $books = Book::where('kitap_adi', 'like', "%$search%")->orWhere('yazar', 'like', "%$search%")->orWhere('ISBN', 'like', "%$search%")->get();
        return view('books.index', compact('books'));
    }
    public function addToFavorite(Book $book){
        auth()->user()->favoriteBooks()->attach($book->id);
        return redirect()->back()->with('success', 'Kitap favorilere eklendi');
    }
    public function removeFromFavorite(Book $book){
        auth()->user()->favoriteBooks()->detach($book->id);
        return redirect()->back()->with('success', 'Kitap favorilerden kaldırıldı');
    }
    public function showFavoriteBooks(){
        $favoriteBooks = auth()->user()->favoriteBooks;
        return view('books.favorite', compact('favoriteBooks'));
    }
}
