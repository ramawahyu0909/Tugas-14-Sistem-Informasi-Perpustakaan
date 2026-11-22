
@extends('layouts.app')

@section('title', 'Edit Anggota')

@section('content')
    <h2>Edit Anggota</h2>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('members.update', $member->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label>Nama Anggota</label>
            <input type="text" name="name"
                value="{{ old('name', $member->name) }}" required>
        </div>

        <div>
            <label>Email</label>
            <input type="email" name="email"
                value="{{ old('email', $member->email) }}">
        </div>

        <div>
            <label>Nomor Telepon</label>
            <input type="text" name="phone"
                value="{{ old('phone', $member->phone) }}">
        </div>

        <div>
            <label>Alamat</label>
            <textarea name="address">{{ old('address', $member->address) }}</textarea>
        </div>

        <button type="submit">Perbarui Anggota</button>
        <a href="{{ route('members.index') }}">Kembali</a>
    </form>
@endsection
