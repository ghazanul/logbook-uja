<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{

    protected $guarded = [];
    public function tugasTelur()
    {
        return $this->hasOne(TugasTelur::class);
    }

    public function tugasKeadaanBebek()
    {
        return $this->hasOne(TugasKeadaanBebek::class);
    }

    public function kandang()
    {
        return $this->belongsTo(Kandang::class);
    }
}
