<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Member;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BorrowingController extends Controller
{
    // Menampilkan daftar peminjaman
    public function index()
    {
        $borrowings = Borrowing::with(['member', 'details.book'])
            ->latest()
            ->get();

        return view('borrowings.index', compact('borrowings'));
    }

    // Menampilkan form peminjaman
    public function create()
    {
        $members = Member::orderBy('name')->get();
        $books = Book::where('stock', '>', 0)
            ->orderBy('title')
            ->get();

        return view('borrowings.create', compact('members', 'books'));
    }

    // Menyimpan transaksi peminjaman
    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'borrow_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:borrow_date',
            'items' => 'required|array',
            'items.*' => 'nullable|integer|min:0',
        ]);

        $items = collect($validated['items'])
            ->filter(fn ($quantity) => $quantity > 0);

        if ($items->isEmpty()) {
            throw ValidationException::withMessages([
                'items' => 'Pilih minimal satu buku untuk dipinjam.',
            ]);
        }

        DB::transaction(function () use ($validated, $items) {
            $borrowing = Borrowing::create([
                'member_id' => $validated['member_id'],
                'borrow_date' => $validated['borrow_date'],
                'due_date' => $validated['due_date'],
                'status' => 'dipinjam',
            ]);

            foreach ($items as $bookId => $quantity) {
                $book = Book::whereKey($bookId)
                    ->lockForUpdate()
                    ->first();

                if (!$book || $book->stock < $quantity) {
                    throw ValidationException::withMessages([
                        'items' => 'Stok buku tidak mencukupi. Silakan periksa kembali.',
                    ]);
                }

                $borrowing->details()->create([
                    'book_id' => $book->id,
                    'quantity' => $quantity,
                ]);

                $book->decrement('stock', $quantity);
            }
        });

        return redirect()->route('borrowings.index')
            ->with('success', 'Transaksi peminjaman berhasil disimpan.');
    }

    // Memproses pengembalian buku
    public function returnBook(Borrowing $borrowing)
    {
        DB::transaction(function () use ($borrowing) {
            $borrowing = Borrowing::whereKey($borrowing->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($borrowing->status === 'dikembalikan') {
                throw ValidationException::withMessages([
                    'return' => 'Buku pada transaksi ini sudah dikembalikan.',
                ]);
            }

            $borrowing->load('details.book');

            foreach ($borrowing->details as $detail) {
                $book = Book::whereKey($detail->book_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                $book->increment('stock', $detail->quantity);
            }

            $borrowing->update([
                'status' => 'dikembalikan',
                'return_date' => now()->toDateString(),
            ]);
        });

        return redirect()->route('borrowings.index')
            ->with('success', 'Buku berhasil dikembalikan dan stok telah diperbarui.');
    }
}
