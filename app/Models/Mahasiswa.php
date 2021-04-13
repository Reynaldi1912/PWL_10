<?php

namespace App\Models;

use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; //Model Eloquent

class Mahasiswa extends Model
{
    protected $table = 'Mahasiswa';
    protected $primaryKey = 'nim';

    protected $fillable = [
        'nim',
        'nama',
        'kelas_id',
        'jurusan',
        ];

    public function kelas(){
        return $this->belongsTo(Kelas::class);
    }
    public function Nilai(){
        return $this->hasMany(Nilai::class);
    }
}
