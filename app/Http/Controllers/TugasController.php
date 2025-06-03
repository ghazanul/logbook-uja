<?php

namespace App\Http\Controllers;

use App\Exports\TugasExport;
use App\Models\Kandang;
use App\Models\Season;
use App\Models\Tugas;
use App\Models\TugasKeadaanBebek;
use App\Models\TugasTelur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class TugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createPakan($season, Kandang $kandang)
    {
        return view('ListTugasPakan', ['kandang' => $kandang]);
    }

    public function createPakans()
    {
        $season = Season::where('name', request()->segment(1))->first();
        return view('ListTugasPakan', ['kandangs' => Kandang::where('season_id', $season->id)->get()->sortBy('name')]);
    }


    public function storePakan(Request $request, $season, Kandang $kandang)
    {
        $request->validate([
            'status' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'tanggal' => 'required|date',
        ]);

        // Cek apakah sudah ada tugas dengan tanggal yang sama
        $tugasLama = Tugas::where('kandang_id', $kandang->id)
            ->where('nama_tugas', 'Pakan')
            ->where('tanggal', $request->tanggal)
            ->first();

        if ($tugasLama) {
            return redirect('/'.$season.'/list-TugasPakan/' . $kandang->id)->withErrors([
                'tanggal' => 'Tanggal ini telah diisi sebelumnya.',
            ])->withInput();
        }

        $tugas = new Tugas();
        $tugas->nama_tugas = 'Pakan';
        $tugas->status = $request->status;
        $tugas->keterangan = $request->keterangan;
        $tugas->tanggal = $request->tanggal;
        $tugas->kandang_id = $kandang->id;

        // Cek apakah file valid sebelum proses upload
        if ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {
            $image = $request->file('gambar');

            // Buat folder jika belum ada
            $tujuan = public_path('images/tugas');
            if (!file_exists($tujuan)) {
                mkdir($tujuan, 0755, true);
            }

            // Gunakan nama asli file
            $filename = $image->getClientOriginalName();

            // Pindahkan ke folder tujuan
            $filename = 'tugas_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move($tujuan, $filename);
            $tugas->gambar = $filename;

            // Simpan nama file ke DB
            $tugas->gambar = $filename;
        } else {
            return redirect()->back()->withErrors([
                'gambar' => 'File gambar tidak valid atau gagal diunggah.',
            ])->withInput();
        }

        $tugas->save();

        return redirect()->route('kandang.show', ['season' => $season, 'id' => $kandang->id])->with('success', 'Data Pakan berhasil disimpan.');
    }

    public function storePakans(Request $request, $season)
    {
        // try {
        // Validasi input
        $validasi = $request->validate([
            'status'   => 'required',
            'gambar'   => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5000',
            'tanggal'  => 'required|date',
            'kandang'  => 'required|array|min:1',
        ]);

        if (!$validasi) {
            return redirect()->back()->withErrors($validasi)->withInput();
        }

        // Pastikan file gambar ada dan valid
        if (!$request->hasFile('gambar')) {
            return redirect()->back()->withErrors(['gambar' => 'Gambar tidak ditemukan.']);
        }

        $image = $request->file('gambar');
        $skip = [];

        foreach ($request->kandang as $kandangId) {
            // Cek apakah tugas sudah ada
            $existing = Tugas::where('kandang_id', (int)$kandangId)
                ->where('nama_tugas', 'Pakan')
                ->where('tanggal', $request->tanggal)
                ->first();

            if ($existing) {
                // return redirect()->back()->withErrors([
                //     'tanggal' => 'Tanggal ini telah diisi sebelumnya.',
                // ]);
                $skip[] = $kandangId;
                continue;
            }

            // Buat folder tujuan
            $tujuan = public_path('images/tugas');
            if (!file_exists($tujuan)) {
                mkdir($tujuan, 0755, true);
            }

            // Buat nama file unik per kandang
            $timestamp = time();
            $filename = 'tugas_' . $timestamp . '_kandang' . $kandangId . '.' . $image->getClientOriginalExtension();

            // Salin file ke tujuan
            $imageTempPath = $image->getRealPath();
            // $image->move($tujuan, $filename);
            copy($imageTempPath, $tujuan . '/' . $filename);

            // Simpan ke DB
            Tugas::create([
                'nama_tugas' => 'Pakan',
                'status'     => $request->status,
                'keterangan' => $request->keterangan,
                'tanggal'    => $request->tanggal,
                'kandang_id' => (int) $kandangId,
                'gambar'     => $filename,
            ]);
        }
        $messageSkip = count($skip) ? 'Kandang ' . implode(', ', $skip) . ' telah di skip.' : '';

        return redirect()->route('kandang.shows', ['season' => $season])->with('success', 'Data Pakan berhasil disimpan. ' . $messageSkip);
    }






    public function storeKebersihanKandang(Request $request, $season, Kandang $kandang)
    {
        $request->validate([
            'status' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'tanggal' => 'required|date',
        ]);

        // Cek apakah sudah ada tugas dengan tanggal yang sama
        $tugasLama = Tugas::where('kandang_id', $kandang->id)
            ->where('nama_tugas', 'Kebersihan Kandang')
            ->where('tanggal', $request->tanggal)
            ->first();

        if ($tugasLama) {
            return redirect('/' . $season . '/list-TugasKebersihanKandang/' . $kandang->id)->withErrors([
                'tanggal' => 'Tanggal ini telah diisi sebelumnya.',
            ])->withInput();
        }

        $tugas = new Tugas();
        $tugas->nama_tugas = 'Kebersihan Kandang';
        $tugas->status = $request->status;
        $tugas->keterangan = $request->keterangan;
        $tugas->tanggal = $request->tanggal;
        $tugas->kandang_id = $kandang->id;

        // Cek apakah file valid sebelum proses upload
        if ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {
            $image = $request->file('gambar');

            // Buat folder jika belum ada
            $tujuan = public_path('images/tugas');
            if (!file_exists($tujuan)) {
                mkdir($tujuan, 0755, true);
            }

            // Gunakan nama asli file
            $filename = $image->getClientOriginalName();

            // Pindahkan ke folder tujuan
            // $filename = 'tugas_' . time() . '.' . $image->getClientOriginalExtension();
            // $image->move($tujuan, $filename);
            // $tugas->gambar = $filename;

            // Salin file ke tujuan
            $imageTempPath = $image->getRealPath();
            // $image->move($tujuan, $filename);
            copy($imageTempPath, $tujuan . '/' . $filename);

            // Simpan nama file ke DB
            $tugas->gambar = $filename;
        } else {
            return redirect()->back()->withErrors([
                'gambar' => 'File gambar tidak valid atau gagal diunggah.',
            ])->withInput();
        }

        $tugas->save();

        return redirect()->route('kandang.show', ['season' => $season, 'id' => $kandang->id])->with('success', 'Data Kebersihan Kandang berhasil disimpan.');
    }

    public function storeKebersihanKandangs(Request $request, $season)
    {
        $validasi = $request->validate([
            'status'   => 'required',
            'gambar'   => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5000',
            'tanggal'  => 'required|date',
            'kandang'  => 'required|array|min:1',
        ]);

        if (!$validasi) {
            return redirect()->back()->withErrors($validasi)->withInput();
        }

        // Pastikan file gambar ada dan valid
        if (!$request->hasFile('gambar')) {
            return redirect()->back()->withErrors(['gambar' => 'Gambar tidak ditemukan.']);
        }

        $image = $request->file('gambar');

        $skip = [];
        foreach ($request->kandang as $kandangId) {
            // Cek apakah tugas sudah ada
            $existing = Tugas::where('kandang_id', $kandangId)
                ->where('nama_tugas', 'Kebersihan Kandang')
                ->where('tanggal', $request->tanggal)
                ->first();

            if ($existing) {
                $skip[] = $kandangId;
                continue;
            }

            // Buat folder tujuan
            $tujuan = public_path('images/tugas');
            if (!file_exists($tujuan)) {
                mkdir($tujuan, 0755, true);
            }

            // Buat nama file unik per kandang
            $timestamp = time();
            $filename = 'tugas_' . $timestamp . '_kandang' . $kandangId . '.' . $image->getClientOriginalExtension();

            // Salin file ke tujuan
            $imageTempPath = $image->getRealPath();
            // $image->move($tujuan, $filename);
            copy($imageTempPath, $tujuan . '/' . $filename);

            // Simpan ke DB
            Tugas::create([
                'nama_tugas' => 'Kebersihan Kandang',
                'status'     => $request->status,
                'keterangan' => $request->keterangan,
                'tanggal'    => $request->tanggal,
                'kandang_id' => (int) $kandangId,
                'gambar'     => $filename,
            ]);
        }

        $messageSkip = count($skip) ? 'Kandang ' . implode(', ', $skip) . ' telah di skip.' : '';

        return redirect()->route('kandang.shows', ['season' => $season])->with('success', 'Data Kebersihan Kandang berhasil disimpan. ' . $messageSkip);
    }





    public function storeAir(Request $request, $season, Kandang $kandang)
    {
        $request->validate([
            'status' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'tanggal' => 'required|date',
        ]);

        // Cek apakah sudah ada tugas dengan tanggal yang sama
        $tugasLama = Tugas::where('kandang_id', $kandang->id)
            ->where('nama_tugas', 'Air')
            ->where('tanggal', $request->tanggal)
            ->first();

        if ($tugasLama) {
            return redirect('/' . $season . '/list-TugasAir/' . $kandang->id)->withErrors([
                'tanggal' => 'Tanggal ini telah diisi sebelumnya.',
            ])->withInput();
        }

        $tugas = new Tugas();
        $tugas->nama_tugas = 'Air';
        $tugas->status = $request->status;
        $tugas->keterangan = $request->keterangan;
        $tugas->tanggal = $request->tanggal;
        $tugas->kandang_id = $kandang->id;

        // Cek apakah file valid sebelum proses upload
        if ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {
            $image = $request->file('gambar');

            // Buat folder jika belum ada
            $tujuan = public_path('images/tugas');
            if (!file_exists($tujuan)) {
                mkdir($tujuan, 0755, true);
            }

            // Gunakan nama asli file
            $filename = $image->getClientOriginalName();

            // Pindahkan ke folder tujuan
            $filename = 'tugas_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move($tujuan, $filename);
            $tugas->gambar = $filename;

            // Simpan nama file ke DB
            $tugas->gambar = $filename;
        } else {
            return redirect()->back()->withErrors([
                'gambar' => 'File gambar tidak valid atau gagal diunggah.',
            ])->withInput();
        }

        $tugas->save();

        return redirect()->route('kandang.show', ['season' => $season, 'id' => $kandang->id])->with('success', 'Data Air berhasil disimpan.');
    }

    public function storeAirs(Request $request, $season)
    {
        $validasi = $request->validate([
            'status'   => 'required',
            'gambar'   => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5000',
            'tanggal'  => 'required|date',
            'kandang'  => 'required|array|min:1',
        ]);

        if (!$validasi) {
            return redirect()->back()->withErrors($validasi)->withInput();
        }

        // Pastikan file gambar ada dan valid
        if (!$request->hasFile('gambar')) {
            return redirect()->back()->withErrors(['gambar' => 'Gambar tidak ditemukan.']);
        }

        $image = $request->file('gambar');
        $skip = [];
        foreach ($request->kandang as $kandangId) {
            // Cek apakah tugas sudah ada
            $existing = Tugas::where('kandang_id', $kandangId)
                ->where('nama_tugas', 'Air')
                ->where('tanggal', $request->tanggal)
                ->first();

            if ($existing) {
                $skip[] = $kandangId;
                continue;
            }

            // Buat folder tujuan
            $tujuan = public_path('images/tugas');
            if (!file_exists($tujuan)) {
                mkdir($tujuan, 0755, true);
            }

            // Buat nama file unik per kandang
            $timestamp = time();
            $filename = 'tugas_' . $timestamp . '_kandang' . $kandangId . '.' . $image->getClientOriginalExtension();

            // Salin file ke tujuan
            $imageTempPath = $image->getRealPath();
            // $image->move($tujuan, $filename);
            copy($imageTempPath, $tujuan . '/' . $filename);

            // Simpan ke DB
            Tugas::create([
                'nama_tugas' => 'Air',
                'status'     => $request->status,
                'keterangan' => $request->keterangan,
                'tanggal'    => $request->tanggal,
                'kandang_id' => (int) $kandangId,
                'gambar'     => $filename,
            ]);
        }

        $messageSkip = count($skip) ? 'Kandang ' . implode(', ', $skip) . ' telah di skip.' : '';

        return redirect()->route('kandang.shows', ['season' => $season])->with('success', 'Data Air berhasil disimpan. ' . $messageSkip);
    }






    public function storeTelur(Request $request, $season, Kandang $kandang)
    {
        $request->validate([
            'jumlah_telur' => 'required|integer',
            'jumlah_telur_rusak' => 'nullable|integer',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'tanggal' => 'required|date',
        ]);

        // Cek apakah sudah ada tugas telur pada tanggal yang sama
        $tugasLama = Tugas::where('kandang_id', $kandang->id)
            ->where('nama_tugas', 'Telur')
            ->where('tanggal', $request->tanggal)
            ->first();

        if ($tugasLama) {
            return redirect('/' . $season . '/list-TugasTelur/' . $kandang->id)->withErrors([
                'tanggal' => 'Tanggal ini telah diisi sebelumnya.',
            ])->withInput();
        }

        $tugas = new Tugas();
        $tugas->nama_tugas = 'Telur';
        $tugas->keterangan = $request->keterangan;
        $tugas->tanggal = $request->tanggal;
        $tugas->kandang_id = $kandang->id;

        // Upload gambar
        if ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {
            $image = $request->file('gambar');

            $tujuan = public_path('images/tugas');
            if (!file_exists($tujuan)) {
                mkdir($tujuan, 0755, true);
            }

            $filename = 'tugas_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move($tujuan, $filename);
            $tugas->gambar = $filename;
        } else {
            return redirect()->back()->withErrors([
                'gambar' => 'File gambar tidak valid atau gagal diunggah.',
            ])->withInput();
        }

        $tugas->save();

        // Simpan ke tabel tugas_telur
        $tugasTelur = new TugasTelur();
        $tugasTelur->tugas_id = $tugas->id;
        $tugasTelur->jumlah_telur = $request->input('jumlah_telur');
        $tugasTelur->jumlah_telur_rusak = $request->input('jumlah_telur_rusak', 0);
        $tugasTelur->save();

        return redirect()->route('kandang.show', ['season' => $season, 'id' => $kandang->id])->with('success', 'Data Telur berhasil disimpan.');
    }

    public function storeTelurs(Request $request, $season)
    {
        $validasi = $request->validate([
            'gambar'   => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5000',
            'tanggal'  => 'required|date',
            'kandang'  => 'required|array|min:1',
            'jumlah_telur' => 'required',
        ]);

        if (!$validasi) {
            return redirect()->back()->withErrors($validasi)->withInput();
        }

        // Pastikan file gambar ada dan valid
        if (!$request->hasFile('gambar')) {
            return redirect()->back()->withErrors(['gambar' => 'Gambar tidak ditemukan.']);
        }

        $image = $request->file('gambar');
        $skip = [];
        foreach ($request->kandang as $kandangId) {
            // Cek apakah tugas sudah ada
            $existing = Tugas::where('kandang_id', $kandangId)
                ->where('nama_tugas', 'Telur')
                ->where('tanggal', $request->tanggal)
                ->first();

            if ($existing) {
                $skip[] = $kandangId;
                continue;
            }

            // Buat folder tujuan
            $tujuan = public_path('images/tugas');
            if (!file_exists($tujuan)) {
                mkdir($tujuan, 0755, true);
            }

            // Buat nama file unik per kandang
            $timestamp = time();
            $filename = 'tugas_' . $timestamp . '_kandang' . $kandangId . '.' . $image->getClientOriginalExtension();

            // Salin file ke tujuan
            $imageTempPath = $image->getRealPath();
            // $image->move($tujuan, $filename);
            copy($imageTempPath, $tujuan . '/' . $filename);

            // Simpan ke DB
            $tugas = Tugas::create([
                'nama_tugas' => 'Telur',
                // 'status'     => $request->status,
                'keterangan' => $request->keterangan,
                'tanggal'    => $request->tanggal,
                'kandang_id' => (int) $kandangId,
                'gambar'     => $filename,
            ]);

            // Simpan ke tabel tugas_telur
            $tugasTelur = new TugasTelur();
            $tugasTelur->tugas_id = $tugas->id;
            $tugasTelur->jumlah_telur = $request->input('jumlah_telur');
            $tugasTelur->jumlah_telur_rusak = $request->input('jumlah_telur_rusak', 0);
            $tugasTelur->save();
        }

        $messageSkip = count($skip) ? 'Kandang ' . implode(', ', $skip) . ' telah di skip.' : '';

        return redirect()->route('kandang.shows', ['season' => $season])->with('success', 'Data Telur berhasil disimpan. ' . $messageSkip);
    }




    public function storeUpdateKeadaanBebek(Request $request, $season, Kandang $kandang)
    {
        $request->validate([
            'jumlah_total_bebek' => 'required|integer',
            'jumlah_bebek_mati' => 'nullable|integer',
            'jumlah_bebek_sakit' => 'nullable|integer',
            'jumlah_bebek_sehat' => 'nullable|integer',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'tanggal' => 'required|date',
        ]);

        $tugasLama = Tugas::where('kandang_id', $kandang->id)
            ->where('nama_tugas', 'Update Keadaan Bebek')
            ->where('tanggal', $request->tanggal)
            ->first();

        if ($tugasLama) {
            return redirect('/' . $season . '/list-TugasUpdateKeadaanBebek/' . $kandang->id)->withErrors([
                'tanggal' => 'Tanggal ini telah diisi sebelumnya.',
            ])->withInput();
        }

        $tugas = new Tugas();
        $tugas->nama_tugas = 'Update Keadaan Bebek';
        $tugas->keterangan = $request->keterangan;
        $tugas->tanggal = $request->tanggal;
        $tugas->kandang_id = $kandang->id;

        // Upload gambar
        if ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {
            $image = $request->file('gambar');
            $tujuan = public_path('images/tugas');

            if (!file_exists($tujuan)) {
                mkdir($tujuan, 0755, true);
            }

            $filename = 'tugas_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move($tujuan, $filename);
            $tugas->gambar = $filename;
        } else {
            return redirect()->back()->withErrors([
                'gambar' => 'File gambar tidak valid atau gagal diunggah.',
            ])->withInput();
        }

        $tugas->save();

        // Simpan ke tabel tugas_keadaan_bebek
        $mati = (int) $request->input('jumlah_bebek_mati', 0);
        $total = (int) $request->input('jumlah_total_bebek');

        $tugasKeadaan = new TugasKeadaanBebek();
        $tugasKeadaan->tugas_id = $tugas->id;
        $tugasKeadaan->jumlah_total_bebek = $total - $mati;
        $tugasKeadaan->jumlah_bebek_mati = $mati;
        $tugasKeadaan->jumlah_bebek_sakit = $request->input('jumlah_bebek_sakit', 0);
        $tugasKeadaan->jumlah_bebek_sehat = $request->input('jumlah_bebek_sehat', 0);

        $tugasKeadaan->save();

        $kandang->save();

        return redirect()->route('kandang.show', ['season' => $season, 'id' => $kandang->id])->with('success', 'Data Update Keadaan Bebek berhasil disimpan.');
    }

    public function storeUpdateKeadaanBebeks(Request $request, $season)
    {
        $validasi = $request->validate([
            'gambar'   => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5000',
            'tanggal'  => 'required|date',
            'kandang'  => 'required|array|min:1',
            'jumlah_total_bebek' => 'required|integer',
            'jumlah_bebek_mati' => 'nullable|integer',
            'jumlah_bebek_sakit' => 'nullable|integer',
            'jumlah_bebek_sehat' => 'nullable|integer',
        ]);

        if (!$validasi) {
            return redirect()->back()->withErrors($validasi)->withInput();
        }

        // Pastikan file gambar ada dan valid
        if (!$request->hasFile('gambar')) {
            return redirect()->back()->withErrors(['gambar' => 'Gambar tidak ditemukan.']);
        }

        $image = $request->file('gambar');
        $skip = [];
        foreach ($request->kandang as $kandangId) {
            // Cek apakah tugas sudah ada
            $existing = Tugas::where('kandang_id', $kandangId)
                ->where('nama_tugas', 'Update Keadaan Bebek')
                ->where('tanggal', $request->tanggal)
                ->first();

            if ($existing) {
                $skip[] = $kandangId;
                continue;
            }

            // Buat folder tujuan
            $tujuan = public_path('images/tugas');
            if (!file_exists($tujuan)) {
                mkdir($tujuan, 0755, true);
            }

            // Buat nama file unik per kandang
            $timestamp = time();
            $filename = 'tugas_' . $timestamp . '_kandang' . $kandangId . '.' . $image->getClientOriginalExtension();

            // Salin file ke tujuan
            $imageTempPath = $image->getRealPath();
            // $image->move($tujuan, $filename);
            copy($imageTempPath, $tujuan . '/' . $filename);

            // Simpan ke DB
            $tugas = Tugas::create([
                'nama_tugas' => 'Update Keadaan Bebek',
                'keterangan' => $request->keterangan,
                'tanggal'    => $request->tanggal,
                'kandang_id' => (int) $kandangId,
                'gambar'     => $filename,
            ]);

            // Simpan ke tabel
            $tugasKeadaan = new TugasKeadaanBebek();
            $tugasKeadaan->tugas_id = $tugas->id;
            $tugasKeadaan->jumlah_total_bebek = $request->jumlah_total_bebek;
            $tugasKeadaan->jumlah_bebek_mati = $request->jumlah_bebek_mati;
            $tugasKeadaan->jumlah_bebek_sakit = $request->jumlah_bebek_sakit;
            $tugasKeadaan->jumlah_bebek_sehat = $request->jumlah_bebek_sehat;

            $tugasKeadaan->save();
        }

        $messageSkip = count($skip) ? 'Kandang ' . implode(', ', $skip) . ' telah di skip.' : '';

        return redirect()->route('kandang.shows', ['season' => $season])->with('success', 'Data Bebek berhasil disimpan. ' . $messageSkip);
    }


    //updateee

    public function updatePakan(Request $request, $season, Kandang $kandang)
    {
        $request->validate([
            'status' => 'required',
            'tanggal' => 'required|date',
        ]);

        try {
            // return $kandang;
            $tugas = Tugas::where('kandang_id', $kandang->id)->where('nama_tugas', 'Pakan')->where('tanggal', $request->input('tanggal'))->first();

            $tugas->status = $request->input('status');
            $tugas->tanggal = $request->input('tanggal');
            $tugas->keterangan = $request->input('keterangan');
            if ($request->has('gambar')) {
                $image = $request->file('gambar');

                $tujuan = public_path('images/tugas');
                if (!file_exists($tujuan)) {
                    mkdir($tujuan, 0755, true);
                }

                $filename = 'tugas_' . time() . '.' . $image->getClientOriginalExtension();
                unlink(public_path('images/tugas/' . $tugas->gambar));
                $image->move($tujuan, $filename);
                $tugas->gambar = $filename;
            }
            $tugas->save();

            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function updateAir(Request $request, $season, Kandang $kandang)
    {
        $request->validate([
            'status' => 'required',
            'tanggal' => 'required|date',
        ]);

        try {
            $tugas = Tugas::where('kandang_id', $kandang->id)->where('nama_tugas', 'Air')->where('tanggal', $request->input('tanggal'))->first();

            $tugas->status = $request->input('status');
            $tugas->tanggal = $request->input('tanggal');
            $tugas->keterangan = $request->input('keterangan');
            $tugas->save();

            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    public function updateKebersihanKandang(Request $request, $season, Kandang $kandang)
    {
        $request->validate([
            'status' => 'required',
            'tanggal' => 'required|date',
        ]);

        try {
            $tugas = Tugas::where('kandang_id', $kandang->id)->where('nama_tugas', 'Kebersihan Kandang')->where('tanggal', $request->input('tanggal'))->first();

            $tugas->status = $request->input('status');
            $tugas->tanggal = $request->input('tanggal');
            $tugas->keterangan = $request->input('keterangan');
            if ($request->has('gambar')) {
                $image = $request->file('gambar');

                $tujuan = public_path('images/tugas');
                if (!file_exists($tujuan)) {
                    mkdir($tujuan, 0755, true);
                }

                $filename = 'tugas_' . time() . '.' . $image->getClientOriginalExtension();
                unlink(public_path('images/tugas/' . $tugas->gambar));
                $image->move($tujuan, $filename);
                $tugas->gambar = $filename;
            }
            $tugas->save();

            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    public function updateTelur(Request $request,$season, Kandang $kandang)
    {
        $request->validate([
            'tanggal' => 'required|date',
        ]);

        try {
            $tugas = Tugas::where('kandang_id', $kandang->id)->where('nama_tugas', 'Telur')->where('tanggal', $request->input('tanggal'))->first();
            $tugasTelur = TugasTelur::where('tugas_id', $tugas->id)->first();

            $tugasTelur->jumlah_telur = $request->input('jumlah_telur');
            $tugasTelur->jumlah_telur_rusak = $request->input('jumlah_telur_rusak');
            $tugas->tanggal = $request->input('tanggal');
            $tugas->keterangan = $request->input('keterangan');

            if ($request->has('gambar')) {
                $image = $request->file('gambar');

                $tujuan = public_path('images/tugas');
                if (!file_exists($tujuan)) {
                    mkdir($tujuan, 0755, true);
                }

                $filename = 'tugas_' . time() . '.' . $image->getClientOriginalExtension();
                unlink(public_path('images/tugas/' . $tugas->gambar));
                $image->move($tujuan, $filename);
                $tugas->gambar = $filename;
            }

            $tugas->save();
            $tugasTelur->save();

            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    public function updateKeadaanBebek(Request $request, $season, Kandang $kandang)
    {
        // dd((int) $request->jumlah_bebek_mati);;
        $request->validate([
            'tanggal' => 'required|date',
        ]);

        try {
            $tugas = Tugas::where('kandang_id', $kandang->id)->where('nama_tugas', 'Update Keadaan Bebek')->where('tanggal', $request->input('tanggal'))->first();

            if ($request->input('jumlah_bebek_mati') > $request->input('jumlah_total_bebek')) {
                return redirect()->back()->withErrors(['jumlah_bebek_mati' => 'Jumlah Bebek Mati tidak boleh lebih besar dari jumlah total bebek.']);
            }


            $tugasKeadaanBebek = TugasKeadaanBebek::where('tugas_id', $tugas->id)->first();

            if ($request->input('jumlah_bebek_mati') != null) {
                if ((int) $request->input('jumlah_bebek_mati', 0) > $tugasKeadaanBebek->jumlah_bebek_mati) {
                    $tugasKeadaanBebek->jumlah_total_bebek = $tugasKeadaanBebek->jumlah_total_bebek - ($request->input('jumlah_bebek_mati') + $tugasKeadaanBebek->jumlah_bebek_mati);
                } else if ((int) $request->input('jumlah_bebek_mati', 0) < $tugasKeadaanBebek->jumlah_bebek_mati) {
                    $tugasKeadaanBebek->jumlah_total_bebek = $tugasKeadaanBebek->jumlah_total_bebek + (int) ((int)$tugasKeadaanBebek->jumlah_bebek_mati - (int) $request->input('jumlah_bebek_mati', 0));
                }
            }

            $tugasKeadaanBebek->jumlah_bebek_sehat = $request->input('jumlah_bebek_sehat');
            $tugasKeadaanBebek->jumlah_bebek_mati = $request->input('jumlah_bebek_mati');
            $tugasKeadaanBebek->jumlah_bebek_sakit = $request->input('jumlah_bebek_sakit');
            // $tugasKeadaanBebek->jumlah_total_bebek = $request->input('jumlah_bebek_mati') ? $request->input('jumlah_total_bebek') - $request->input('jumlah_bebek_mati') : $request->input('jumlah_total_bebek');
            $tugas->tanggal = $request->input('tanggal');
            $tugas->keterangan = $request->input('keterangan');

            if ($request->has('gambar')) {
                $image = $request->file('gambar');

                $tujuan = public_path('images/tugas');
                if (!file_exists($tujuan)) {
                    mkdir($tujuan, 0755, true);
                }

                $filename = 'tugas_' . time() . '.' . $image->getClientOriginalExtension();
                unlink(public_path('images/tugas/' . $tugas->gambar));
                $image->move($tujuan, $filename);
                $tugas->gambar = $filename;
            }

            $tugas->save();
            $tugasKeadaanBebek->save();

            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function export()
    {
        return Excel::download(new TugasExport, 'tugas.xlsx');
    }
}
