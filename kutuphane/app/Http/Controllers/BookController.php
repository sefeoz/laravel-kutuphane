<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\BookUpdateRequest;
use Illuminate\Http\RedirectResponse;  
use Illuminate\View\View;

class BookController extends Controller
{
    public function index() : View
    {
        $books = Book::with(['author', 'stores'])->get();
        $stores = \App\Models\Store::all();
        return view('books.index', compact('books'));
    }
    public function create() : View
    {
        $authors = \App\Models\Author::all();
        $stores = \App\Models\Store::all();
        return view('books.create', compact('authors', 'stores'));
    }
    public function store(BookStoreRequest $request) : RedirectResponse
    {
        try {
            $data = $request->validated();
            if ($request->hasFile('image') && $request->file('image')->isValid()) { 
                $data['image'] = $request->file('image')->store('images', 'public');
            }
            $book = Book::create($data);
            if ($request->has('stores') && is_array($request->stores)) {
                $storesToAttach = [];
                foreach ($request->input('stores', []) as $storeId => $payload) {
                    if (!(isset($payload['attach']) && $payload['attach'])) {
                        continue;
                    }
                    $storesToAttach[$storeId] = [
                        'price' => $payload['price'] ?? null,
                        'stock' => isset($payload['stock']) ? (int) $payload['stock'] : 0,
                        'is_active' => isset($payload['is_active']) && (bool) $payload['is_active'],
                    ];
                }
                if (!empty($storesToAttach)) {
                    $book->stores()->attach($storesToAttach);
                }
            }
            return redirect()->route('books.index')->with('success', 'Kitap başarıyla oluşturuldu');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Hata: ' . $e->getMessage())->withInput();
        }
    }
    public function edit(Book $book) : View
    {
        $authors = \App\Models\Author::all();
        $stores = \App\Models\Store::all();
        return view('books.edit', compact('book', 'authors', 'stores'));
    }
    public function update(BookUpdateRequest $request, Book $book) : RedirectResponse
    {
        try {
            $data = $request->validated();
            
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                if ($book->image) {
                    Storage::disk('public')->delete($book->image);
                }
                $data['image'] = $request->file('image')->store('images', 'public');
            }
            
            $book->update($data);
            if ($request->has('stores') && is_array($request->stores)) {
                $storesToSync = [];
                foreach ($request->input('stores', []) as $storeId => $payload) {
                    if (!(isset($payload['attach']) && $payload['attach'])) {
                        continue;
                    }
                    $storesToSync[$storeId] = [
                        'price' => $payload['price'] ?? null,
                        'stock' => isset($payload['stock']) ? (int) $payload['stock'] : 0,
                        'is_active' => isset($payload['is_active']) && (bool) $payload['is_active'],
                    ];
                }
                if (!empty($storesToSync)) {
                    $book->stores()->sync($storesToSync);
                } else {
                    $book->stores()->detach();
                }
            } else {
                $book->stores()->detach();
            }
            
            return redirect()->route('books.index')->with('success', 'Kitap başarıyla güncellendi');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Hata: ' . $e->getMessage())->withInput();
        }
    }
    public function destroy(Book $book) : RedirectResponse
    {
        $book->delete();
        return redirect()->route('books.index');
    }
    public function show(Book $book) : View
    {
        return view('books.show', compact('book'));
    }
    public function search(Request $request) : View|RedirectResponse
    {
        $search = $request->input('search');
        if(strlen($search) < 3){
            return redirect()->route('books.index')->with('error', 'Arama kelimesi en az 3 karakter olmalıdır');
        }else{
        $books = Book::with(['author', 'stores'])
            ->where('name', 'like', "%$search%")
            ->orWhereHas('author', function($query) use ($search) {
                $query->where('name', 'like', "%$search%");
            })
            ->orWhere('ISBN', 'like', "%$search%")
            ->orWhereHas('stores', function($query) use ($search) {
                $query->where('name', 'like', "%$search%");
                })
                ->get();
        }
        return view('books.index', compact('books'));
    }
    public function addToFavorite(Book $book) : RedirectResponse
    {
        auth()->user()->favoriteBooks()->attach($book->id);
        return redirect()->back()->with('success', 'Kitap favorilere eklendi');
    }
    public function removeFromFavorite(Book $book) : RedirectResponse
    {
        auth()->user()->favoriteBooks()->detach($book->id);
        return redirect()->back()->with('success', 'Kitap favorilerden kaldırıldı');
    }
    public function showFavoriteBooks() : View
    {
        $favoriteBooks = auth()->user()->favoriteBooks;
        return view('books.favorite', compact('favoriteBooks'));
    }
}
