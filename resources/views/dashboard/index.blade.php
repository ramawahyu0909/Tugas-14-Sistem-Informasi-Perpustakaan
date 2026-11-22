
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h2>{{ $appName }}</h2>
    <p>{{ $appDescription }}</p>

    <h3>Statistik Perpustakaan</h3>

    <table border="1" cellpadding="12" cellspacing="0">
        <thead>
            <tr>
                <th>Informasi</th>
                <th>Jumlah</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>Total Judul Buku</td>
                <td>{{ $totalBooks }}</td>
            </tr>

            <tr>
                <td>Total Anggota Terdaftar</td>
                <td>{{ $totalMembers }}</td>
            </tr>

            <tr>
                <td>Total Kategori</td>
                <td>{{ $totalCategories }}</td>
            </tr>

            <tr>
                <td>Total Transaksi Peminjaman</td>
                <td>{{ $totalBorrowings }}</td>
            </tr>

            <tr>
                <td>Peminjaman yang Belum Dikembalikan</td>
                <td>{{ $activeBorrowings }}</td>
            </tr>
        </tbody>
    </table>
@endsection
