<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Color;
use App\Models\User;

class Encuesta extends Model
{
    use HasFactory;

    protected $fillable = [
        'edad',
        'color_id',
        'user_id'
    ];

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
