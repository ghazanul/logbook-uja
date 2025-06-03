<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TugasKeadaanBebek extends Model
{
    protected $table = 'tugas_keadaan_bebek';   

    public function tugas()
    {
        return $this->belongsTo(Tugas::class);
    }
}
