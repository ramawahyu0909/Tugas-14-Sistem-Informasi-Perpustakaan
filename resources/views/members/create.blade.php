
@extends('layouts.app')

@section('title', 'Tambah Anggota')

@section('content')
    <h2>Tambah Anggota</h2>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('members.store') }}" method="POST">
        @csrf

        <div>
            <label>Nama Anggota</label>
            <input type="text" name="name"
                value="{{ old('name') }}" required>
        </div>

        <div>
            <label>Email</label>
            <input type="email" name="email"
                value="{{ old('email') }}">
        </div>

        <div>
            <label>Nomor Telepon</label>
            <input type="text" name="phone"
                value="{{ old('phone') }}">
        </div>

        <div>
            <label>Alamat</label>
            <textarea name="address">{{ old('address') }}</textarea>
        </div>

        <button type="submit">Simpan Anggota</button>
        <a href="{{ route('members.index') }}">Kembali</a>
    </form>
@endsection
