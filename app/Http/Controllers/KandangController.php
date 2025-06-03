<?php

namespace App\Http\Controllers;

use App\Models\Kandang;
use App\Models\Season;
use App\Models\Tugas;
use Illuminate\Http\Request;

class KandangController extends Controller
{
    public function index($season)
    {
        $s = Season::where('name', $season)->first();
        if ($s == null) {
            // $kandang = null;
            return redirect()->back();
        }
        $seasonId = $s->id;
        // dd($seasonId);
        // dd($season->id);
        // dd($season->id); 
        $kandang = Kandang::where('season_id', $seasonId)->get();
        // dd($kandang[1])->name;
        return view('task', ['kandang' => $kandang]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'jumlah_bebek' => 'required',
                'season' => 'required',
            ]);
            $name = $request->input('name');
            $jumlah_bebek = $request->input('jumlah_bebek');
            $season = $request->input('season');
            $seasonId = Season::where('name', $season)->first()->id;
            $kandang = new Kandang();
            $kandang->name = $name;
            $kandang->jumlah_ternak = $jumlah_bebek;
            $kandang->season_id = $seasonId;


            $kandang->save();
            return response()->json(['status' => 'success']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'failed']);
        }
    }

    public function show($season, $id)
    {
        $kandang = Kandang::find($id);
        return view('ListKegiatan', ['kandang' => $kandang]);
    }


    public function hapus(Request $request)
    {
        $ids = $request->input('ids');
        if (!$ids || !is_array($ids)) {
            return response()->json(['success' => false, 'message' => 'Data tidak valid.']);
        }

        try {
            Kandang::whereIn('id', $ids)->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus kandang.']);
        }
    }

    public function viewDataKandangPertanggal(Request $request, $season,  Kandang $kandang)
    {
        $tanggal = $request->route('tanggal');
        $tanggal = date('Y-m-d', strtotime($tanggal));
        $tugasPakan = Tugas::where('kandang_id', $kandang->id)->where('tanggal', $tanggal)->where('nama_tugas', 'Pakan')->first();
        $tugasKebersihan = Tugas::where('kandang_id', $kandang->id)->where('tanggal', $tanggal)->where('nama_tugas', 'Kebersihan Kandang')->first();
        $TugasTelur = Tugas::with('tugasTelur')->where('kandang_id', $kandang->id)->where('tanggal', $tanggal)->where('nama_tugas', 'Telur')->first();
        $tugasKeadaanBebek = Tugas::with('tugasKeadaanBebek')->where('kandang_id', $kandang->id)->where('tanggal', $tanggal)->where('nama_tugas', 'Update Keadaan Bebek')->first();
        $tugasAir = Tugas::where('kandang_id', $kandang->id)->where('tanggal', $tanggal)->where('nama_tugas', 'Air')->first();
        // dd($tugas[0]->tugasKeadaanBebek);
        return view('ViewDataKandang', ['season' => $season, 'tugasPakan' => $tugasPakan, 'tugasKebersihan' => $tugasKebersihan, 'TugasTelur' => $TugasTelur, 'tugasKeadaanBebek' => $tugasKeadaanBebek, 'tugasAir' => $tugasAir, 'tanggal' => $tanggal, 'kandang' => $kandang]);
    }
}
