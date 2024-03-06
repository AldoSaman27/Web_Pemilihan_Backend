<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kandidat extends Model
{
    use HasFactory;
    protected $fillable = [
        "ketua",
        "wakil",
        "motto",
        "visi_misi",
        "gambar",
        "video",
    ];
}
