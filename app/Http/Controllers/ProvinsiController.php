<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Provinsi;

class ProvinsiController extends Controller
{
    // Menampilkan semua data provinsi
    public function index()
    {
        $provinces = Provinsi::all(); // Mengambil semua data provinsi
        return view('adminpus.provinsi.index', compact('provinces'));
    }

    // Menampilkan form tambah provinsi
    public function create()
    {
        return view('adminpus.provinsi.create');
    }

    // Menyimpan data provinsi baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_provinsi' => 'required|max:255|unique:provinsis,nama_provinsi',
        ]);

        Provinsi::create([
            'nama_provinsi' => $validated['nama_provinsi'],
        ]);

        return redirect()->route('provinsi.index')->with('success', 'Provinsi berhasil ditambahkan!');
    }

    // Menampilkan form edit provinsi
    public function edit($id)
    {
        $provinsi = Provinsi::findOrFail($id); // Cari provinsi berdasarkan ID
        return view('adminpus.provinsi.edit', compact('provinsi'));
    }

    // Memperbarui data provinsi
    public function update(Request $request, $id)
    {
        $provinsi = Provinsi::findOrFail($id);

        $validated = $request->validate([
            'nama_provinsi' => 'required|max:255|unique:provinsis,nama_provinsi,' . $id,
        ]);

        $provinsi->update([
            'nama_provinsi' => $validated['nama_provinsi'],
        ]);

        return redirect()->route('provinsi.index')->with('success', 'Provinsi berhasil diperbarui!');
    }

    // Menghapus data provinsi
    public function destroy($id)
    {
        $provinsi = Provinsi::findOrFail($id);
        $provinsi->delete();

        return redirect()->route('provinsi.index')->with('success', 'Provinsi berhasil dihapus!');
    }
}
