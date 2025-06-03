<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KandangController;
use App\Http\Controllers\SeasonController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\UserController;
use App\Models\Kandang;
use App\Models\Season;
use App\Models\Tugas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/tes', function () {
    return view('welcome');
});

Route::resource('season', SeasonController::class)->middleware('auth');

Route::prefix('{season}')->middleware(['auth', 'check.season'])->group(function () {
    Route::get('/home', function () {

        return view('home');
    })->name('home');

    Route::get('/task', [KandangController::class, 'index'])->name('kandang.index');
    Route::post('/task', [KandangController::class, 'store'])->name('kandang.store');

    Route::get('list-kegiatan/{id}', [KandangController::class, 'show'])->name('kandang.show');
    Route::get('/list-kegiatan', function () {
        return view('ListKegiatan');
    })->name('kandang.shows');

    Route::get('/view-data', function () {
        $season = Season::where('name', request()->segment(1))->first();
        $kandang = Kandang::where('season_id', $season->id)->get()->sortBy('name');
        return view('view', ['kandang' => $kandang]);
    });

    Route::get('/list-TugasPakan/{kandang}', [TugasController::class, 'createPakan'])->name('tugas.createPakan');
    Route::post('/list-TugasPakan/{kandang}', [TugasController::class, 'storePakan'])->name('tugas.storePakan');
    Route::get('/list-TugasPakan', [TugasController::class, 'createPakans'])->name('tugas.createPakans');
    Route::post('/list-TugasPakan', [TugasController::class, 'storePakans'])->name('tugas.storePakans');


    Route::get('/list-TugasTelur/{kandang}', function ($season, Kandang $kandang) {
        return view('ListTugasTelur', ['kandang' => $kandang, 'season' => $season]);
    });
    Route::post('/list-TugasTelur/{kandang}', [TugasController::class, 'storeTelur'])->name('tugas.storeTelur');
    Route::get('/list-TugasTelur', function () {
        $season = Season::where('name', request()->segment(1))->first();
        return view('ListTugasTelur', [
            'kandangs' => Kandang::where('season_id', $season->id)->get()->sortBy('name'),
            'season' => $season
        ]);
    });
    Route::post('/list-TugasTelur', [TugasController::class, 'storeTelurs'])->name('tugas.storeTelurs');



    Route::get('/list-TugasUpdateKeadaanBebek/{kandang}', function ($season, Kandang $kandang) {

        return view('ListTugasUpdateKeadaanBebek', ['kandang' => $kandang, 'season' => $season]);
    });
    Route::post('/list-TugasUpdateKeadaanBebek/{kandang}', [TugasController::class, 'storeUpdateKeadaanBebek'])->name('tugas.storeUpdateKeadaanBebek');
    Route::get('/list-TugasUpdateKeadaanBebek', function () {

        $season = Season::where('name', request()->segment(1))->first();
        return view('ListTugasUpdateKeadaanBebek', ['kandangs' => Kandang::where('season_id', $season->id)->get()->sortBy('name'), 'season' => $season]);
    });
    Route::post('/list-TugasUpdateKeadaanBebek', [TugasController::class, 'storeUpdateKeadaanBebeks'])->name('tugas.storeUpdateKeadaanBebeks');




    Route::get('/list-TugasKebersihanKandang/{kandang}', function ($season, Kandang $kandang) {
        return view('ListTugasKebersihanKandang', ['kandang' => $kandang]);
    });
    Route::post('/list-TugasKebersihanKandang/{kandang}', [TugasController::class, 'storeKebersihanKandang'])->name('tugas.storeKebersihanKandang');
    Route::get('/list-TugasKebersihanKandang', function () {
        $season = Season::where('name', request()->segment(1))->first();
        return view('ListTugasKebersihanKandang', ['kandangs' => Kandang::where('season_id', $season->id)->get()->sortBy('name')]);
    });
    Route::post('/list-TugasKebersihanKandang', [TugasController::class, 'storeKebersihanKandangs'])->name('tugas.storeKebersihanKandangs');





    Route::get('/list-TugasAir/{kandang}', function ($season, Kandang $kandang) {
        return view('ListTugasAir', ['kandang' => $kandang, 'season' => $season]);
    });
    Route::post('/list-TugasAir/{kandang}', [TugasController::class, 'storeAir'])->name('tugas.storeAir');
    Route::get('/list-TugasAir', function (Kandang $kandang, $season) {
        $season = Season::where('name', request()->segment(1))->first();
        return view('ListTugasAir', [
            'kandangs' => Kandang::where('season_id', $season->id)->get()->sortBy('name'),
            'season' => $season
        ]);
    });
    Route::post('/list-TugasAir', [TugasController::class, 'storeAirs'])->name('tugas.storeAirs');


    Route::get('/view-data-kandang/{kandang}/{tanggal}', [KandangController::class, 'viewDataKandangPertanggal']);



    Route::post('/hapus-kandang', [KandangController::class, 'hapus']);

    Route::get('/view-data-kandang/{kandang}', function ($season, Kandang $kandang) {
        return view('viewKalender', ['kandang' => $kandang]);
    });

    Route::get('/events', function () {

        $tugas = Tugas::all();

        $data = [];

        foreach ($tugas as $item) {
            $data[] = [
                'title' => $item->title,
                'start' => $item->start_date,
                'end' => $item->end_date,
            ];
        }

        return response()->json($data);
    });
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::get('/tugas/export', [TugasController::class, 'export'])->name('tugas.export');

    Route::get('/download-data', function () {
        $kandang = Kandang::all();
        return view('viewDownloadData', ['kandang' => $kandang]);
    });

    Route::get('/download-data/{kandang}', function (Kandang $kandang) {
        return view('viewDownloadDataTugas', ['kandang' => $kandang]);
    });

    Route::get('/laporan', function () {

        $season = Season::where('name', request()->segment(1))->first();
        return view('viewLaporan', ['kandangs' => Kandang::where('season_id', $season->id)->get()->sortBy('name')]);
    });

    Route::post('/laporan-json', function (Request $request) {
        $tugas = Tugas::whereIn('kandang_id', $request->kandang)
            ->with('tugasTelur', 'tugasKeadaanBebek', 'kandang')
            ->get();

        return response()->json($tugas);
    });

    Route::post('/laporan-pertanggal', function (Request $request) {
        $startDate = Carbon::createFromFormat('m/d/Y', explode(' - ', $request->tanggal)[0])->format('Y-m-d');
        $endDate = Carbon::createFromFormat('m/d/Y', explode(' - ', $request->tanggal)[1])->format('Y-m-d');
        $tugas = Tugas::whereIn('kandang_id', $request->kandang)
            ->where('tanggal', '>=', $startDate)
            ->where('tanggal', '<=', $endDate)
            ->with('tugasTelur', 'tugasKeadaanBebek', 'kandang')
            ->get();
        return response()->json($tugas);
    });

    Route::resource('user', UserController::class);
    Route::get('user/{user}/edit-password', [UserController::class, 'editPassword'])->name('user.editPassword');
    Route::put('user/{user}/edit-password', [UserController::class, 'updatePassword'])->name('user.updatePassword');


    Route::get('/pilihan-tugas', function (Kandang $kandang) {
        return view('pilihanTugas', ['kandang' => $kandang]);
    });


    Route::put('/update-pakan/{kandang}', [TugasController::class, 'updatePakan'])->name('tugas.updatePakan');
    Route::put('/update-air/{kandang}', [TugasController::class, 'updateAir'])->name('tugas.updateAir');
    Route::put('/update-kebersihan/{kandang}', [TugasController::class, 'updateKebersihanKandang'])->name('tugas.updateKebersihan');
    Route::put('/update-telur/{kandang}', [TugasController::class, 'updateTelur'])->name('tugas.updateTelur');
    Route::put('update-keadaan-bebek/{kandang}', [TugasController::class, 'updateKeadaanBebek'])->name('tugas.updateKeadaanBebek');

    Route::delete('/delete-image', [TugasController::class, 'deleteImage'])->name('tugas.deleteImage');

    Route::get('season', [SeasonController::class, 'index'])->name('season.index');
    Route::get('season/create', [SeasonController::class, 'create'])->name('season.create');
    Route::post('season', [SeasonController::class, 'store'])->name('season.store');

    Route::get('season/{seasons}/edit', [SeasonController::class, 'edit'])->name('season.edit');
    Route::put('season/{seasons}', [SeasonController::class, 'update'])->name('season.update');
    Route::delete('season/{seasons}', [SeasonController::class, 'destroy'])->name('season.destroy');
});

Route::middleware('auth')->group(function () {});

Route::get('/', function () {
    $season = Season::all()->last()->name;
    session(['season' => $season]);
    return view('Login');
})->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
