<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class NilaiRTController extends Controller
{
    public function index()
    {
        $query = "SELECT nama, LOWER(nama_pelajaran) as nama_pelajaran, skor, nisn FROM nilai WHERE materi_uji_id = 7 AND nama_pelajaran != 'Pelajaran Khusus'";
        $queryExec = DB::select($query);

        foreach ($queryExec as $_query) {
            if (!isset($queryData[$_query->nama])) { // pengondisian agar data muncul satu kali per nama
                $queryData[$_query->nama] = [
                    'nama' => $_query->nama,
                    'nisn' => $_query->nisn,
                    'nilaiRt' => []
                ];
            }
            $queryData[$_query->nama]['nilaiRt'][$_query->nama_pelajaran] = $_query->skor;
        }

        // mengubah $queryData menjadi array
        $queryData = array_values($queryData);

        return response()->json([
            'hasil' => $queryData,
        ]);
    }
}
