
@extends('layouts.app')

@section('title', 'Tambah Peminjaman')

@section('content')
    <h2>Form Peminjaman Buku</h2>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('borrowings.store') }}" method="POST">
        @csrf

        <div>
            <label>Nama Anggota</label>
            <select name="member_id" required>
                <option value="">-- Pilih Anggota --</option>

                @foreach ($members as $member)
                    <option value="{{ $member->id }}"
                        {{ old('member_id') == $member->id ? 'selected' : '' }}>
                        {{ $member->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <br>

        <div>
            <label>Tanggal Peminjaman</label>
            <input type="date" name="borrow_date"
                value="{{ old('borrow_date', date('Y-m-d')) }}" required>
        </div>

        <br>

        <div>
            <label>Tanggal Pengembalian</label>
            <input type="date" name="due_date"
                value="{{ old('due_date') }}" required>
        </div>

        <br>

        <h3>Pilih Buku</h3>

        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>Judul Buku</th>
                    <th>Penulis</th>
                    <th>Stok</th>
                    <th>Jumlah Pinjam</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($books as $book)
                    <tr>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->author }}</td>
                        <td>{{ $book->stock }}</td>
                        <td>
                            <input
                                type="number"
                                name="items[{{ $book->id }}]"
                                min="0"
                                max="{{ $book->stock }}"
                                value="{{ old('items.' . $book->id, 0) }}">
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Tidak ada buku dengan stok tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <br>

        <button type="submit">Simpan Peminjaman</button>

        <a href="{{ route('borrowings.index') }}">Kembali</a>
    </form>
@endsection
