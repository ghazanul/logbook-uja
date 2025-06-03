<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TugasTelur extends Model
{
    protected $table = 'tugas_telur';

    public function tugas()
{
    return $this->belongsTo(Tugas::class);
}

}
