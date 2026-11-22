
@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')
    <h2>Edit Kategori Buku</h2>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label>Nama Kategori</label>
            <input
                type="text"
                name="name"
                value="{{ old('name', $category->name) }}"
                required
            >
        </div>

        <br>

        <button type="submit">Simpan Perubahan</button>

        <a href="{{ route('categories.index') }}">Kembali</a>
    </form>
@endsection
