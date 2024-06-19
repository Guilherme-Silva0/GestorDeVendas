<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Installments extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'value',
        'number',
        'due_date',
    ];
}
