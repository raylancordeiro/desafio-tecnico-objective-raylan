<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conta extends Model
{
    use HasFactory;

    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'conta_id';

    protected $visible = ['conta_id', 'saldo'];

    protected $fillable = [
        'conta_id',
        'saldo',
    ];

    public function setSaldo($value)
    {
        if ($value < 0) {
            throw new \InvalidArgumentException('O saldo não pode ser menor que zero.');
        }
        $this->attributes['saldo'] = $value;
    }
}
