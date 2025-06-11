<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Measurement extends Model
{
    use SoftDeletes;

    protected $table = 'measurements';

    protected $fillable = [
        'value',
        'measurement_type_enum',
        'user_id',
    ];
}
