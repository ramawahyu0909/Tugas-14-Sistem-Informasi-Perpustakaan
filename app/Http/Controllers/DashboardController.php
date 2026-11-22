<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Member;
use App\Models\Borrowing;

class DashboardController extends Controller
{
    public function index()
    {
        $appName = 'Library System';

        $appDescription = 'Sistem Informasi Perpustakaan Sederhana untuk pengelolaan buku, kategori, anggota, dan peminjaman.';

        // Mengambil jumlah data langsung dari database
        $totalBooks = Book::count();
        $totalMembers = Member::count();
        $totalCategories = Category::count();
        $totalBorrowings = Borrowing::count();

        // Menghitung transaksi yang masih dipinjam
        $activeBorrowings = Borrowing::where('status', 'dipinjam')->count();

        return view('dashboard.index', compact(
            'appName',
            'appDescription',
            'totalBooks',
            'totalMembers',
            'totalCategories',
            'totalBorrowings',
            'activeBorrowings'
        ));
    }
}
