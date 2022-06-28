<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class caixas extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'id_admin',
        'estado',
        'id_user_relation',
        'created_at',
        'updated_at',
    ];

}
