<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    private function branchId(): ?int
    {
        return Auth::user()?->branch_id ?? Branch::query()->value('id');
    }

    public function index()
    {
        $books = Book::where('branch_id', $this->branchId())
            ->orderBy('title')
            ->get();

        return view('app.library.books.index', compact('books'));
    }

    public function create()
    {
        return view('app.library.books.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'author'       => 'nullable|string|max:100',
            'isbn'         => 'nullable|string|max:20',
            'publisher'    => 'nullable|string|max:100',
            'edition'      => 'nullable|string|max:20',
            'category'     => 'nullable|string|max:50',
            'price'        => 'nullable|numeric|min:0',
            'quantity'     => 'required|integer|min:1',
            'available'    => 'required|integer|min:0|lte:quantity',
            'shelf_number' => 'nullable|string|max:20',
        ]);

        $data['branch_id'] = $this->branchId();
        Book::create($data);

        return redirect()->route('library.books.index')
            ->with('message', 'Book added to library.')->with('alert-type', 'success');
    }

    public function show(Book $book)
    {
        $book->load(['issues' => fn ($q) => $q->with('user')->orderByDesc('issue_date')]);
        return view('app.library.books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        return view('app.library.books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'author'       => 'nullable|string|max:100',
            'isbn'         => 'nullable|string|max:20',
            'publisher'    => 'nullable|string|max:100',
            'edition'      => 'nullable|string|max:20',
            'category'     => 'nullable|string|max:50',
            'price'        => 'nullable|numeric|min:0',
            'quantity'     => 'required|integer|min:1',
            'available'    => 'required|integer|min:0|lte:quantity',
            'shelf_number' => 'nullable|string|max:20',
        ]);

        $book->update($data);

        return redirect()->route('library.books.index')
            ->with('message', 'Book updated.')->with('alert-type', 'success');
    }

    public function destroy(Book $book)
    {
        if ($book->issues()->where('status', 'issued')->exists()) {
            return back()->with('message', 'Cannot delete — this book has active issues.')
                ->with('alert-type', 'error');
        }

        $book->delete();

        return redirect()->route('library.books.index')
            ->with('message', 'Book deleted.')->with('alert-type', 'success');
    }
}
