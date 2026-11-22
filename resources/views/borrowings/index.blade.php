
@extends('layouts.app')

@section('title', 'Data Peminjaman')

@section('content')
    <h2>Data Peminjaman Buku</h2>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if ($errors->any())
        <div style="color: red;">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <a href="{{ route('borrowings.create') }}">+ Tambah Peminjaman</a>

    <br><br>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Anggota</th>
                <th>Tanggal Pinjam</th>
                <th>Batas Pengembalian</th>
                <th>Buku yang Dipinjam</th>
                <th>Status</th>
                <th>Tanggal Kembali</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($borrowings as $borrowing)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $borrowing->member->name }}</td>
                    <td>{{ $borrowing->borrow_date->format('d-m-Y') }}</td>
                    <td>{{ $borrowing->due_date->format('d-m-Y') }}</td>

                    <td>
                        @foreach ($borrowing->details as $detail)
                            {{ $detail->book->title }}
                            ({{ $detail->quantity }} buku)
                            <br>
                        @endforeach
                    </td>

                    <td>{{ ucfirst($borrowing->status) }}</td>

                    <td>
                        {{ $borrowing->return_date
                            ? $borrowing->return_date->format('d-m-Y')
                            : '-' }}
                    </td>

                    <td>
                        @if ($borrowing->status === 'dipinjam')
                            <form
                                action="{{ route('borrowings.return', $borrowing->id) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin ingin mengembalikan buku ini?')">
                                @csrf
                                @method('PATCH')

                                <button type="submit">Kembalikan</button>
                            </form>
                        @else
                            Sudah dikembalikan
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">Belum ada transaksi peminjaman.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
