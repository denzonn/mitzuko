<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\Regency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    public function provinces(Request $request)
    {
        return Province::all();
    }
    public function regencies(Request $request, $provinces_id)
    {
        //Mencari berdasarkan provinsi

        return Regency::where('province_id', $provinces_id)->get();
    }
    public function defaultValue($id)
    {
        // Ambil data provinsi berdasarkan provinces_id di tabel users
        $provinces_id = DB::table('users')->where('id', $id)->first()->provinces_id;
        $regencies_id = DB::table('users')->where('id', $id)->first()->regencies_id;

        $provinces = DB::table('provinces')->where('id', $provinces_id)->first();
        $regencies = DB::table('regencies')->where('id', $regencies_id)->first();

        return response()->json([
            'provinces' => $provinces,
            'regencies' => $regencies,
        ]);
    }
}
