<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ustadz extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'ustadz';
    protected $guarded = ['id'];
}
