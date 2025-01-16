<?php

namespace App\Http\Controllers;

use App\Models\Kel_desa;
use Illuminate\Http\Request;

class KelurahanDesaController extends Controller
{
    public function getKelurahanDesa($id_kecamatan)
    {
        $kelurahanDesas = kel_desa::where('id_kecamatan', $id_kecamatan)->get();

        return response()->json($kelurahanDesas);
    }
}
