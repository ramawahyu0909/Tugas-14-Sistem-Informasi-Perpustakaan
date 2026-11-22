<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    // Menampilkan seluruh anggota
    public function index()
    {
        $members = Member::latest()->get();

        return view('members.index', compact('members'));
    }

    // Menampilkan form tambah anggota
    public function create()
    {
        return view('members.create');
    }

    // Menyimpan anggota baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:members,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        Member::create($validated);

        return redirect()->route('members.index')
            ->with('success', 'Data anggota berhasil ditambahkan.');
    }

    // Menampilkan form edit anggota
    public function edit(Member $member)
    {
        return view('members.edit', compact('member'));
    }

    // Memperbarui data anggota
    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:members,email,' . $member->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $member->update($validated);

        return redirect()->route('members.index')
            ->with('success', 'Data anggota berhasil diperbarui.');
    }

    // Menghapus anggota
    public function destroy(Member $member)
    {
        $member->delete();

        return redirect()->route('members.index')
            ->with('success', 'Data anggota berhasil dihapus.');
    }
}