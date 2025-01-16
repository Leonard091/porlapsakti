<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lembaga;
use App\Models\Provinsi;
use App\Models\kab_kota;
use App\Models\kecamatan;
use App\Models\kel_desa;


class lembagaController extends Controller
{
    // Menampilkan data lembaga
    public function index()
    {
        $lembagas = Lembaga::with(['provinsi', 'kab_kota', 'kecamatan', 'kel_desa'])->get();
        return view('adminpus.lembaga.index', compact('lembagas'));
    }

    // Menampilkan halaman tambah lembaga
    public function create()
    {
        $provinces = Provinsi::all();
        $kabupatenKotas = kab_kota::all();
        $kecamatans = kecamatan::all();
        
        return view('adminpus.lembaga.create', compact('provinces', 'kabupatenKotas', 'kecamatans'));
    }

    // Menyimpan data lembaga baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_prov' => 'required',
            'id_kab_kota' => 'required',
            'id_kec' => 'required|exists:kecamatans,id',
            'id_kel_desa' => 'required',
            'nama_lembaga' => 'required|max:300',
            'nama_perpus' => 'required|max:300',
            'NPP' => 'required', // Sesuaikan nama tabel
            'alamat' => 'required',
            'rt' => 'required|max:5',
            'rw' => 'required|max:5',
            'email_lembaga' => 'required|email',
            'email_perpus' => 'required|email',
        ]);

        $validated['created_by'] = auth()->user()->username;
        $validated['updated_by'] = auth()->user()->username;

        Lembaga::create($validated);

        return redirect()->route('lembaga.index')->with('success', 'Lembaga berhasil ditambahkan!');
    }

    // Menampilkan halaman edit lembaga
    public function edit($id)
    {
        $lembaga = Lembaga::findOrFail($id);
        $provinces = Provinsi::all();
        return view('adminpus.lembaga.edit', compact('lembaga', 'provinces'));
    }

    // Memperbarui data lembaga
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'id_prov' => 'required',
            'id_kab_kota' => 'required',
            'id_kec' => 'required',
            'id_kelurahan' => 'required',
            'nama_lembaga' => 'required|max:300',
            'nama_perpustakaan' => 'required|max:300',
            'alamat' => 'required',
            'rt' => 'required|max:5',
            'rw' => 'required|max:5',
            'email_lembaga' => 'required|email',
            'email_perpus' => 'required|email',
        ]);

        $validated['updated_by'] = auth()->user()->name;

        Lembaga::findOrFail($id)->update($validated);

        return redirect()->route('lembaga.index')->with('success', 'Lembaga berhasil diperbarui!');
    }

    // Menghapus data lembaga
    public function destroy($id)
    {
        Lembaga::findOrFail($id)->delete();
        return redirect()->route('lembaga.index')->with('success', 'Lembaga berhasil dihapus!');
    }
}
