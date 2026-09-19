<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Epaper extends Model
{
    protected $fillable = ['edition_date', 'pdf_path'];

    protected $casts = ['edition_date' => 'date'];
}
