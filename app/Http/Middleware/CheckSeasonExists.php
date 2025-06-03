<?php


namespace App\Http\Middleware;

use App\Models\Season;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CheckSeasonExists
{
    public function handle(Request $request, Closure $next)
    {
        $season = $request->route('season'); // Ambil parameter season dari URL

        // Misalnya daftar season valid ada di config atau database
        $validSeasons = Season::pluck('name')->toArray(); // bisa diganti dari DB jika dinamis

        if (!in_array($season, $validSeasons)) {
            // Bisa redirect atau throw 404
            throw new NotFoundHttpException(); // Akan munculkan halaman 404
            // return redirect('/not-found'); // alternatif redirect ke halaman khusus
        }

        return $next($request);
    }
}
