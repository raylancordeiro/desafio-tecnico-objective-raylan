<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transacao extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $visible = ['conta_id', 'forma_pagamento', 'valor'];

    protected $fillable = [
        'conta_id',
        'valor',
        'forma_pagamento'
    ];

    protected $table = 'transacoes';

    public function conta()
    {
        return $this->belongsTo(Conta::class);
    }
}
