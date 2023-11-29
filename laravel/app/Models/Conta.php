<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conta extends Model
{
    use HasFactory;

    use HasFactory;

    public $timestamps = false;

    protected $visible = ['conta_id', 'saldo'];

    protected $fillable = [
        'conta_id',
        'saldo',
    ];
}
