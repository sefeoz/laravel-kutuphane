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
        $stores = \App\Models\Store::all();
        return view('books.index', compact('books'));
    }
    public function create(){
        $yazarlar = \App\Models\Yazar::all();
        $stores = \App\Models\Store::all();
        return view('books.create', compact('yazarlar', 'stores'));
    }
    public function store(BookStoreRequest $request){
        try {
            $data = $request->validated();
            if ($request->hasFile('image') && $request->file('image')->isValid()) { 
                $data['image'] = $request->file('image')->store('images', 'public');
            }
            $book = Book::create($data);
                if($request->has('stores') && is_array($request->stores)){
                $stores = [];
                foreach($request->stores as $store_id){
                    $stores[$store_id] = [
                        'price' => $request->input("prices.{$store_id}"),
                        'stock' => $request->input("stock.{$store_id}", 0),
                        'is_active' => $request->has("is_active.{$store_id}")
                    ];
                }
                $book->stores()->attach($stores);
            }
            return redirect()->route('books.index')->with('success', 'Kitap başarıyla oluşturuldu');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Hata: ' . $e->getMessage())->withInput();
        }
    }
    public function edit($id){
        $book = Book::findOrFail($id);
        $yazarlar = \App\Models\Yazar::all();
        $stores = \App\Models\Store::all();
        return view('books.edit', compact('book', 'yazarlar', 'stores'));
    }
    public function update(BookUpdateRequest $request, $id){
        try {
            $data = $request->validated();
            $book = Book::findOrFail($id);
            
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                if ($book->image) {
                    Storage::disk('public')->delete($book->image);
                }
                $data['image'] = $request->file('image')->store('images', 'public');
            }
            
            $book->update($data);
                if($request->has('stores') && is_array($request->stores)){
                $stores = [];
                foreach($request->stores as $store_id){
                    $stores[$store_id] = [
                        'price' => $request->input("prices.{$store_id}"),
                        'stock' => $request->input("stock.{$store_id}", 0),
                        'is_active' => $request->has("is_active.{$store_id}")
                    ];
                }
                $book->stores()->sync($stores);
            } else {
                $book->stores()->detach();
            }
            
            return redirect()->route('books.index')->with('success', 'Kitap başarıyla güncellendi');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Hata: ' . $e->getMessage())->withInput();
        }
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
        $books = Book::where('kitap_adi', 'like', "%$search%")
            ->orWhereHas('yazar', function($query) use ($search) {
                $query->where('isim', 'like', "%$search%");
            })
            ->orWhere('ISBN', 'like', "%$search%")
            ->orWhereHas('stores', function($query) use ($search) {
                $query->where('name', 'like', "%$search%");
            })
            ->get();
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
