<?php

namespace App\Http\Controllers;

use App\Models\kab_kota;
use Illuminate\Http\Request;

class kabupatenKotaController extends Controller
{
    public function getKabupatenKota($id_prov)
    {
        $kabupatenKotas = kab_kota::where('id_prov', $id_prov)->get();
        return response()->json($kabupatenKotas);
    }
}
